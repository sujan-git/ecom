<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductImages;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use Exception;
use File;
use Image;
use Validator;

class ProductController extends Controller
{
    public function __construct(ProductRepository $product,Category $model_cat,Product $model_prod, ProductImages $productimages){
    	$this->product = $product;
        $this->model_prod = $model_prod;
        $this->model_cat = $model_cat;
        $this->productimage = $productimages;
    }

    public function add(){
        $parent_cats = $this->model_cat->where('parent_id',NULL)->get();
    	return view('product.add')
    		->with('parent_cats',$parent_cats);
    }

    public function store(Request $request){   
            //dd($request);
        $validate = Validator::make($request->all(), [
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
        ]);
        //dd($validate);
        if($validate->fails()){
            return 'Validation Unsuccessful';
        }
        $file_name = $this->resizeandSaveThumbImage($request,$prod_info =null);
        if($file_name){
             $id = $this->product->create(array_merge($request->except('_token','image_name','thumb_image'),['thumb_image'=>$file_name]));
             $saved = $this->resizeandSaveOtherImages($request,$id);
             \Session::flash('success','Product Saved successfully'); 
        }else{
            \Session::flash('error','Problem in saving Product');   
        }

        return redirect()->route('product-list');
    }

    public function resizeandSaveThumbImage($request,$prod_info){
        $image = $request->file('thumb_image');
        try{
            if($image){
                if($prod_info != null){
                    if (isset($prod_info->thumb_image) && !empty($prod_info->thumb_image) && file_exists(public_path() . '/uploads/productimage/' . $prod_info->thumb_image)) {
                            unlink(public_path() . '/uploads/productimage/' . $prod_info->thumb_image);
                    }
                }
                $image_name = "Prod_thumb-" . date('Ymdhis') . rand(0, 999) . "." . $image->getClientOriginalExtension();
                $path = public_path()."/uploads/productimage";
                if (!File::exists($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }

                $resize_image = Image::make($image->getRealPath());
               // dd($resize_image);

               $resize_image->resize(env('THUMB_WIDTH'), env('THUMB_HEIGHT'), function($constraint){
                        $constraint->aspectRatio();
                 })->save($path . '/' . $image_name);

               
            }else{
                $image_name = false;
            }
              
        }catch(Exception $e){
            $image_name = false;
        }
        return $image_name;
        
    }

    public function resizeandSaveOtherImages($request,$id){
        $succ = true;
        if($request->image_name){
            foreach($request->image_name as $image){
               if($succ){
                     $image_name = "Prod_Img-" . date('Ymdhis') . rand(0, 999) . "." . $image->getClientOriginalExtension();
                    $path = public_path()."/uploads/productimage";
                    if (!File::exists($path)) {
                            File::makeDirectory($path, 0777, true, true);
                        }
                    /*Save Other Image in Database and resize*/
                   $product_image = new ProductImages();
                   $product_image->product_id = $id;
                   $product_image->image_name = $image_name;
                   $product_image->save();
                    $resize_image = Image::make($image->getRealPath());
                   // dd($resize_image);

                   $resize_image->resize(300, null, function($constraint){
                            $constraint->aspectRatio();
                     })->save($path . '/' . $image_name);
                  // dd($succ);
               }else{
                 $succ = false;
                 break;
               }
            }
        }else{
            $succ = false;
        }

        return $succ;
    }

    public function list(){
        $product = $this->model_prod->getAll();
        //dd($product);
        return view('product.list')->with('product',$product);
    }

    public function edit($id){
        $product = $this->model_prod->findProductById($id);
        //dd($product);
        $parent_cats = $this->model_cat->where('parent_id',NULL)->get();
        return view( 'product.edit' )->with('product',$product)->with('parent_cats',$parent_cats);
    }

    public function delete($id){
        $product_data = $this->model_prod->findProductById($id);
        $msg = $this->product->delete($product_data,$id);
        if($msg){
            return redirect()->back()->with( 'success', 'Product is Successfully deleted!!' );
        }else{
            return redirect()->back()->with( 'error', 'Problem Encountered While Deleting. Try Again' );   
        }
    }

    public function update(Request $request){
        if($request->id){
            $prod_info = $this->model_prod->findOrFail($request->id);
        }else{
            $prod_info = null;
        }
        $rules = $this->model_prod->getRules();
        $validate = Validator::make($request->all(), [
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
        ]);
        //dd($validate);
        if($validate->fails()){
            return 'Validation Unsuccessful';
        }
        $file_name = $this->resizeandSaveThumbImage($request,$prod_info);
        $saved = $this->resizeandSaveOtherImages($request, $request->id);
        if($file_name){
            $id = $this->product->update(array_merge($request->except('_token','image_name','thumb_image'),['thumb_image'=>$file_name]), $request->id);
        }else{
             $id = $this->product->update(array_merge($request->except('_token','image_name','thumb_image')), $request->id);
        }
        if($id != null){
             \Session::flash('success','Product Updated successfully'); 
        }else{
            \Session::flash('error',"Unable To Update Product at This Moment."); 
        }
        return redirect()->route('product-list');

    }

    public function deleteImage($id){
        $data = $this->productimage->deleteProductImageById($id);
        return response()->json($data);
    }
}

