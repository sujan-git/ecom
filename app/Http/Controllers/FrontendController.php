<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductImages;
use App\Offers;
use App\Cart;
use App\Repositories\Offer\OfferRepository;
use Auth;

class FrontendController extends Controller
{
	private $product,$category,$offer,$cart;

    public function __construct(Category $category,Product $product, ProductImages $productimages,OfferRepository $offer,Cart $cart){
    	$this->product = $product;
		$this->category = $category;
		$this->offer = $offer;
		$this->cart = $cart;
   	}

   	public function home(Request $request){
		$title = 'Ecom Demo !Welcome | Home | Your online shopping platform';
		$featured_products = $this->product->getFeaturedProduct();
		$trending_products  = $this->product->getTrendingProduct();
   		//$parent_cats = $this->category->getParentCategory();
		$all_products = $this->product->getAllProduct();
		//dd($all_products);
		$offer = $this->offer->getAll();
		$featured_collections = $this->category->getFeaturedCollection();
		//dd($featured_collections);
		
	   		//dd($cart);
		   return view('frontend.home')
		   	   //->with('parent_cats',$parent_cats)
			   ->with('featured_products',$featured_products)
			   ->with('trending_products',$trending_products)
			   ->with('all_products',$all_products)
			   ->with('offers',$offer)
			   ->with('title',$title)
			   ->with('featured_collections',$featured_collections);
			   //->with('cart',$cart);
	}
	   
	public function productDetail($slug){
		$prod_detail = $this->product->getProductDetail($slug);
		   //dd($prod_detail);
		   if($prod_detail != null){
		   	 $related_prod = $this->product->getRelatedProduct($prod_detail->parentcategory_id);
		   }else{
		   	$related_prod = null;
		   }
		   
		   //review section baki xa hai
		   //dd($prod_detail);
		   return view('frontend.detail')
						   ->with('product',$prod_detail)
						   ->with('related_products',$related_prod)
						   ->with('title',$prod_detail->name);
	}

	public function shopByCategory($slug){
	   	$category = $this->category->where('slug',$slug)->first();
		   $product = $this->product->getProductByCategory($category->id);
		   if(!empty($product)){
		   	 return view('frontend.category-shop')
		   	 		->with('products',$product)
		   	 		->with('title',$category->title. '| Ecomm. An online shopping store')
		   	 		->with('category',$category);
		   }
		   else{
		   	 return 'Products are not found for this category';
		   }
		   
	}


	public function loginCall(Request $request){
	   	
        return response()->json($request);
	}

	   public function getCart($request){
	   	//dd($request);
	   		$cart = null;
	   		if(Auth::user()){
	   			$cart = $this->cart->getUserCart(Auth::user()->id);
	   		}else{
	   			$cart = $request->session()->get('cart');
	   		}
	   		return $cart;
	   }

	   public function getCartItems(Request $request){
	   		$cart = $this->getCart($request);
	   		return view('frontend.cart')
	   				->with('cart',$cart)
	   				->with('title','My Cart | Eshopper.com');
	   }

	   public function loadMore(Request $request){
	   		$products = $this->product->loadMoreProduct($request->slug);
	   		 $pod_arr = array();
	   		foreach($products as $key =>$product){
	   			$prod_arr[$key] = $product;
	   			$prod_arr[$key]['image'] = asset('uploads/productimage/'.$product->thumb_image);
	   			$prod_arr[$key]['route'] = Route('product-detail',$product->slug);

	   		}
	   		return response()->json(['status'=>true, 'products' =>$prod_arr]);

	   }

	   public function getProductInfo(Request $request){
	   		$prod_detail = $this->product->getProductDetail($request->slug);

	   		if(!isset($prod_detail)){
	   			return response()->json(['status'=>false,'data'=>null]);
	   		}
	   		return response()->json(['status'=>true,'data'=>$prod_detail]);
	   }

	   public function getCartJson(Request $request){
	   	$cart = $this->getCart($request);
	   	   return response()->json(['cart'=>$cart]);
	   }

	   public function contact(Request $request){
	   		return view('frontend.contact')
	   				->with('title','Contact Us | Ecom | An online shopping platform');
	   }

	   public function blog(Request $request){

	   }

	   public function about(Request $request){
	   	
	   }
}
