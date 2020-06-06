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
       //session()->flush('cart');
        //dd($request->quantity);
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
       // dd(session('cart'));
        return response()->json(['status'=>true, 'msg' => 'Cart created successfully.', 'data' =>['current_item'=>$current_item,'cart'=>session('cart')]]);

               
    }

   public function updateCart(Request $request){
        /*Update Session Info*/
        $cart = session('cart');
        $cart[$request->index]['quantity'] = $request->quantity;
        $cart[$request->index]['total_amount'] = ($request->quantity) * ($cart[$request->index]['price']);
        session(['cart'=>$cart]);
        /*Update Session Info*/

        /*Database Cart Update*/
        /*Database Cart Update*/

        return response()->json(['success' => true, 'message' => 'Cart Updated', 'cart'=>$cart]);

   }
}
