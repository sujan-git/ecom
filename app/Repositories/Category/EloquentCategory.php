<?php

namespace App\Repositories\Category;

use App\Category;
use File;
use Illuminate\Support\Facades\Storage;

class EloquentCategory implements CategoryRepository{

	private $category;

	public function __construct(Category $category){
		$this->category = $category;
	}

	 public function getAll()
    {
        return $this->category->all();
    }

    public function getById($id){
    	return $this->category->findOrFail($id);
    }

    public function create(array $attributes){
        if(isset($attributes['category_image'])){
            
                $file_name = "Category-" . date('Ymdhis') . rand(0, 999) . "." . $attributes['category_image']->getClientOriginalExtension();
                $path = public_path() . "/uploads/categoryimage";
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $attributes['category_image']->move($path,$file_name);
                $attributes['category_image'] = $file_name;
        }
       

        $attributes['slug'] = $this->category->getSlug($attributes['title']);
        //dd($attributes);
        $this->category->create($attributes);
    }



     public function update($id, array $attributes)
    {

       // dd($attributes);
        $category = $this->getById($id);  
        if (isset($attributes['category_image'])) {
            
            //delete previous image if already image exists
            if (isset($category->category_image) && !empty($category->category_image) && file_exists(public_path() . '/uploads/categoryimage/' . $category->category_image)) {
        
                $img_path = public_path().'/uploads/categoryimage/'.$category->category_image;
                //dd($img_path);
                unlink($img_path);
                
            }
            //save new image in server and in database
            $file_name = "Category-" . date('Ymdhis') . rand(0, 999) . "." . $attributes['category_image']->getClientOriginalExtension();
                $path = public_path() . "/uploads/categoryimage";
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $attributes['category_image']->move($path,$file_name);
                $attributes['category_image'] = $file_name;
            
        }

        if(!isset($attributes['is_featured'])){
            $attributes['is_featured'] = null;
        }

        
        $attributes['slug'] = $this->category->getSlug($attributes['title']);
        //dd($attributes);
        $category->update($attributes);
    }

    public function delete($id)
    {
        $category =  $this->getById($id);
            //delete image if already image exists
            if (isset($category->category_image) && !empty($category->category_image) && file_exists(public_path() . '/uploads/categoryimage/' . $category->category_image)) {
        
                $img_path = public_path().'/uploads/categoryimage/'.$category->category_image;
                //dd($img_path);
                unlink($img_path);
                
            }
        $category->delete();
        return true;
    }

}