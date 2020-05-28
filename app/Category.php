<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    //use Sluggable;

    /*public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }*/


	protected $fillable = ['title','status','summary','slug','parent_id','category_image','is_featured'];

    public function getRules(){
    	return [
            'title' => 'required|string',
            'status' => 'string|in:active,inactive',
            'summary'=> 'sometimes',
            'category_image'=> 'sometimes|image|max:5000',
            'parent_id'=>'sometimes|integer|nullable',
            'is_featured'=>'sometimes|boolean|nullable'
            
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

    public function getParentCategory(){
        return $this->where(['status'=>'active','parent_id'=>NULL])->get();
    }

    public function getFeaturedCollection(){
        return $this->where([['status','active'],['is_featured',1],['category_image','!=' ,null]])->get();
    }
}
