<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;

use Image;
use File;

class ResizeController extends Controller
{
    //

    public function resize(Request $request){
    	//dd($request);

    	 $image = $request->file('category_image');
    	 //dd($image);

    	$image_name = 'Cat-'.time() . '.' . $image->getClientOriginalExtension();
    	//dd(public_path());
    	 $destinationpath = public_path()."/thumbnails";

    	 if (!File::exists($destinationpath)) {
                    File::makeDirectory($destinationpath, 0777, true, true);
                }

    	  $resize_image = Image::make($image->getRealPath());

    	   $resize_image->resize(150, 150, function($constraint){
		      		$constraint->aspectRatio();
		     })->save($destinationpath . '/' . $image_name);

    	     $destinationpath = public_path()."/images";

    	     if (!File::exists($destinationpath)) {
                    File::makeDirectory($destinationpath, 0777, true, true);
                }

    	      $image->move($destinationpath, $image_name);

    	      return 'Success';
    }
}
