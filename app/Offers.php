<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    //
    protected $fillable = ['title','slug','banner_image','status','summary'];

    public function getSlug($title){
    	$slug = str_slug($title);
		$found = $this->where('slug', $slug)->first();
        if ($found) {
            $slug .= "-" . date('Ymdhis') . rand(0, 99);
        }
        return $slug;
    }
    
}
