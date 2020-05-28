<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\ProductImages;

class Product extends Model
{
    protected $fillable = ['name','status','summary','slug','discount_price','parentcategory_id','childcategory_id','is_featured','is_trending','is_discountable','tax_percent','description','thumb_image','price'];

    public function getRules(){
    	return [
            'name' => 'required|string',
            'status' => 'string|in:active,inactive',
            'summary'=> 'sometimes|string',
            'parentcategory_id'=>'required|integer|exists:categories,id',
            'summary'=>'sometimes|string',
            'description'=>'sometimes|string',
            'price'=>'required|numeric',
            'discount_price'=>'sometimes|numeric',
            'childcategory_id'=>'sometimes|integer|exists:categories,parent_id',
            'thumb_image' => 'image|max:5000|nullable',
            'image_name.*' => 'sometimes|image|max:5000',
            'is_featured'=>'sometimes|in:yes',
            'is_discountable'=>'sometimes|in:yes',
            'is_trending'=>'sometimes|in:yes',

            
        ];
    }

    public function getSlug($title){
    	$slug = str_slug($title);
		$found = $this->where('slug', $slug)->first();
        if ($found) {
            $slug .= "-" . date('Ymdhis') . rand(0, 99);
        }
        return $slug;
    }

    public function child_category(){
        return $this->belongsTo('App\Category','childcategory_id');
    }

    public function parent_category(){
        return $this->belongsTo('App\Category','parentcategory_id');
    }

    public function product_images(){
        return $this->hasMany('App\ProductImages','product_id');
    }

    public function getAll(){
        return $this->get();
    }

    public function getAllProduct(){
        return $this->with('product_images')->with('parent_category')->with('child_category')->orderBy('created_at', 'desc')->limit(3)->get();
        //return $this->with('product_images')->with('parent_category')->with('child_category')->get();
    }

    public function findProductById($id){
        return $this->with('product_images')->with('parent_category')->with('child_category')->findOrFail($id);
    }

    public function getFeaturedProduct(){
        return $this->where('is_featured','yes')->latest()->limit(50)->get();
    }

    public function getTrendingProduct(){
        return $this->where('is_trending','yes')->latest()->limit(3)->get();
    }

    public function getProductDetail($slug){
        $product =  $this->with('product_images')->with('parent_category')->where('slug',$slug)->first();
        if($product){
            return $product;
        }else{
            abort(404);
        }
    }

    public function getRelatedProduct($parent_id){
        return $this->with('product_images')->with('parent_category')->where('parentcategory_id',$parent_id)->limit(100)->get();
    }

    public function loadMoreProduct($slug){
        $product_id = ($this->where('slug',$slug)->first())->id;
        if(!$product_id){
            return null;
        }
        return $this->with('product_images')->with('parent_category')->with('child_category')->where('id','<',$product_id)->orderBy('id', 'desc')->limit(2)->get();

        
    }

    public function getProductByCategory($id){
        return $this->with('product_images')->where('parentcategory_id',$id)->get();
    }
}
