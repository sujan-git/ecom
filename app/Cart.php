<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable = ['user_id','product_id','name','price','quantity','total_amount','image'];

    public function getCartByUserId($id){
    	return $this->where('user_id',$id)->get();
    }

    public function getParticularCart($user_id, $product_id){
    	return $this->where([['user_id','=',$user_id],['product_id','=',$product_id]])->first();
    }

    public function getUserCart($id){
    	return $this->where('user_id',$id)->get();
    }
}
