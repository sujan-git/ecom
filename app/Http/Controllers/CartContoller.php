<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductImages;
use App\Cart;
use Auth;

class CartContoller extends Controller
{
    private $product = null;private $cart = null;

    public function __construct(Product $product){
    	$this->product = $product;
       // $this->cart = $cart;
    }

    public function addToCart(Request $request){        //storre cart in session//
       // session()->flush('cart');
        $this->product = $this->product->find($request->id);
        $quantity = $request->quantity;
        
        if(!$this->product){
            return response()->json(['status'=>false,'msg'=>'Product Not found.','data' => null]);
        }

        /** IF product found */
        // session()->flush('cart');
        if(session()->has('cart')){
            $cart = session('cart');
        } else {
            $cart = array();
        }
        $current_item = array();

        $current_item['id'] = $this->product->id;
        $current_item['name'] =$this->product->name;
        $current_item['price'] = $this->product->price;
        if($this->product->is_discountable == 'yes'){
           $current_item['price'] = $this->product->price- $this->product->discount_price; 
        }
        //$current_item['product_id'] = $this->product->id;
        $current_item['image'] = asset('/uploads/productimage/'.$this->product->thumb_image);
        $current_item['quantity'] = $quantity;
        $current_item['total_amount'] = $quantity*$current_item['price'];

        if(!empty($cart)){
            if(null !== $request->user()){
                $cart_obj = new Cart();
                $cart_obj = $cart_obj->where('product_id', $this->product->id)->where('user_id',$request->user()->id)->first();
                if(!$cart_obj){
                    $cart_obj =  new Cart();
                }
                $cart_obj->user_id = $request->user()->id;
                $cart_obj->name = $this->product->name;
                $cart_obj->product_id = $this->product->id;
                $cart_obj->image = $current_item['image'];
                $cart_obj->price = $current_item['price'];
            }
            $index = null;
            foreach($cart as $key=>$value){
                // return response()->json($value);

                if($value['id'] == $this->product->id){
                    $index = $key;
                    break;
                }
            }
            if($index === null){
                $current_item['total_amount'] = $quantity*$current_item['price'];
                $current_item['quantity'] = $quantity;    
                $cart[] = $current_item;
                
                if(null !== $request->user()){
                    $cart_obj->quantity = $current_item['quantity'];
                    $cart_obj->total_amount = $current_item['total_amount'];
    
                }
            } else {
                $cart[$index]['quantity'] = $cart[$index]['quantity']+$quantity;    
                $cart[$index]['total_amount'] = $cart[$index]['quantity']*$current_item['price'];
                if(null !== $request->user()){
                    $cart_obj->quantity = $cart[$index]['quantity'];
                    $cart_obj->total_amount = $cart[$index]['total_amount'];
    
                }
            }
        } else {
            $cart_obj = new Cart();
            $current_item['total_amount'] = $quantity*$current_item['price'];
            $current_item['quantity'] = $quantity;    
            $cart[] = $current_item;
            if(null !== $request->user()){
                $cart_obj->quantity = $current_item['quantity'];
                $cart_obj->total_amount = $current_item['total_amount'];

            }
        }


        

        session(['cart'=>$cart]);
        if(null !== $request->user()){
            $cart_obj->save();
    
        }
            // cart db ->save
        // $request->session()->push('cart',$cart);

        //return response()->json(session());

        return response()->json(['status'=>true, 'msg' => 'Cart created successfully.', 'data' =>['current_item'=>$current_item,'cart'=>session('cart')]]);

               
    }

    public function addToCart_(Request $request){
       // dd(Auth::user()->id);
        $data = $request->except(['_token']);
        //dd($data);
        if(!Auth::user()){
           return response()->json(['status'=>false, 'msg' => 'Please Login To Continue.', 'data' =>null]); 
        }
        $this->product = $this->product->find($request->id);
            //dd($this->product);
        
        if(!$this->product){
            return response()->json(['status'=>false,'msg'=>'Product Not found.','data' => null]);
        }
        $cart_info = $this->cart->getCartByUserId(Auth::user()->id);
        //dd($cart_info);
        $data['quantity'] = $request->quantity;
        if( $cart_info!= null){
            $index = null;
            foreach($cart_info as $key=>$cart){
                if($request->id == $cart->product_id){
                    //dd('here');
                    $data['quantity'] = $data['quantity'] + $cart->quantity;
                    $this->cart = $this->cart->getParticularCart(Auth::user()->id, $request->id);
                    //dd($this->cart);
                    break;
                }
            }
        }

        if($this->product->is_discountable == 'yes'){
            $price = $this->product->price - $this->product->discount_price;
        }else{
            $price = $this->product->price;
        }
        
        
        $data['user_id']  = Auth::user()->id;//saomething;
        $data['product_id'] = $this->product->id;
        $data['image'] =  asset('/uploads/productimage/'.$this->product->thumb_image);;
        $data['name'] = $this->product->name;
        //$data['quantity = $quantity;
        $data['price']  = $price; 
        $data['total_amount'] = $data['quantity'] * $price;
        //dd($this->cart);
        $this->cart->fill($data);
         $succ = $this->cart->save();
         

        //return json; */
         if($succ){
            $msg = 'Cart Created successfully';
        }else{
            $msg  = 'Problem While Creating Cart';
        }    
        return response()->json(['status'=>true, 'msg' => $msg, 'data' => ['cart'=>$this->cart]]); 
    }
}
