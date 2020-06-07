<?php

namespace App\Repositories\Product;

use App\Product;
use App\ProductImages;
use File;
use Exception;
use Image;

class EloquentProduct implements ProductRepository{

	private $product,$prod_image;

	public function __construct(Product $product,ProductImages $prod_image){
		$this->product = $product;
        $this->prod_image = $prod_image;
	}

	 public function getAll()
    {
        return $this->product->get();
    }

    public function getById($id){
    	return $this->product->findOrFail($id);
    }

    public function create(array $attributes){
         $attributes['slug'] = $this->product->getSlug($attributes['name']);
         //dd($attributes);

         
        if(isset($attributes['is_offered'])){
           if($attributes['offer_id'] == ''){
                $attributes['offer_id'] = null;
           }
        }else{
            $attributes['offer_id'] = null;
        }

        $product = $this->product->create($attributes);

          return $product->id; 
    }



     public function update(array $attributes,$id)
    {
        //dd($attributes);
        $product = $this->getById($id);
        $attributes['slug'] = $this->product->getSlug($attributes['name']);
        //dd($attributes);
        if(isset($attributes['is_offered'])){
           if($attributes['offer_id'] == ''){
                $attributes['offer_id'] == null;
           }
        }else{
            $attributes['offer_id'] = null;
        }
        $product->update($attributes);
        //dd($product);
        return $product->id;
    }

    public function delete($data,$id)
    {
        try{
            if(isset($data->thumb_image) && !empty($data->thumb_image)){
                if($data->thumb_image != '' && file_exists(public_path().'/uploads/productimage/'.$data->thumb_image)){
                        unlink(public_path().'/uploads/productimage/'.$data->thumb_image);
                    }
            }
            $this->getById($id)->delete();
            if(isset($data->product_images) && !empty($data->product_images)){
                foreach($data->product_images as $image){
                   if($image->image_name != '' && file_exists(public_path().'/uploads/productimage/'.$image->image_name)){
                        unlink(public_path().'/uploads/productimage/'.$image->image_name);
                    }
                }
            }
            $msg = true;
        }catch(Exception $e){
            $msg = false;
        }
        return $msg;

    }

}