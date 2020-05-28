<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    //
    protected $fillable = ['image_name','product_id'];

    public function findProductImages($id){
    	return $this->where('id',$id)->get();
    }

    public function deleteProductImageById($id){
    	$data = $this->find($id);$msg = 'error';
    	$img = $data->image_name;
    	if($data){
    		$del = $data->delete();
    		if($del){
	    		if($img != '' && file_exists(public_path().'/uploads/productimage/'.$img)){
	                unlink(public_path().'/uploads/productimage/'.$img);
	            }
	            $msg = 'success';
    		}
    		
    	}
    	return $msg;
    }
}
