<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function admin(Request $request){
    	return view('admindashboard.index');
    }
}
