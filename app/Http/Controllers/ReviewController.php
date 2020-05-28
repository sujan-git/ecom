<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\Product;
use App\User;

class ReviewController extends Controller
{
	protected $review,$product,$user;

    public function __construct(Review $review, Product $product,User $user){
    	$this->review = $review;
    	$this->product = $product;
    	$this->user = $user;
    }

    public function addReview(Request $request){
    	$rating = $request->rating;
    	//return response()->json($request);
    	if($request->email == null){
    		$msg = 'Email Field Is Empty';
    		return response()->json(['msg'=>$msg,'desciption'=>$request->desciption,'rating'=>$rating]);
    	}
    	$user  = User::where('email',$request->email)->first();
    	
    	if($user == null){
    		return response()->json(['msg'=>'Your Email Could Not Be Found','desciption'=>$request->desciption,'rating'=>$rating]);
    	}
    	// dd($id);
    	

    	if($request->rating == 0 && $request->description == null){
    			$msg = 'Please provide some text review or rating';
    			return response()->json(['msg'=>$msg,'desciption'=>$request->desciption,'rating'=>$rating]);
    	}else{
    		$id = ($this->product->getProductDetail($request->slug))->id;
	    	$review = new Review();
	    	$review->description = $request->description;
	    	$review->user_rating = $rating;
	    	$review->product_id = $id;
	    	$review->name= $user->name;
	    	//dd($review);
	    	 $succ = $review->save();
	    	 if($succ){
	    	 	$msg = 'Review Added successfully!';
	    	 }
	    	return response()->json(['msg'=>$msg,'desciption'=>$request->desciption,'rating'=>$rating]);
    	}

    	
    }
}
