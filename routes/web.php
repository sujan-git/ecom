<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/', 'FrontendController@home')->name('home');
Route::get('/product_detail/{slug}', 'FrontendController@productDetail')->name('product-detail');
//Route::get('/shop/{slug}', 'FrontendController@productByCategory')->name('category-product');
Route::post('/verify_user', 'FrontendController@loginCall')->name('login-ajax');
Route::get('/cart', 'FrontendController@getCartItems')->name('cart-view');
Route::get('/loadmore/{slug}', 'FrontendController@loadMore')->name('load-more');
Route::get('/shop/{slug}', 'FrontendController@shopByCategory')->name('category-shop');
Route::get('/contact', 'FrontendController@contact')->name('contact');
Route::post('/contact', 'ContactController@sendMail')->name('contact-send');
Route::get('/blog', 'FrontendController@blog')->name('blog');
Route::get('/about', 'FrontendController@about')->name('about');
Route::get('/cart', 'FrontendController@showCart')->name('view-cart');
Route::get('/search', 'FrontendController@getSearchResults')->name('search');
Route::get('/offer/{slug}', 'FrontendController@shopOfferItems')->name('offer-shop');




Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::group(['prefix'=>'admin','middleware'=>['auth','admin']],function(){
	Route::get('/index','PageController@admin')->name('admin-dashboard');
	Route::group(['prefix'=>'category','middleware'=>'admin'],function(){
		Route::get('/add','CategoryController@add')->name('category-add');
		Route::post('/post','CategoryController@store')->name('category-post');
		//Route::post('/post','ResizeController@resize')->name('category-post');
		Route::get('/list','CategoryController@list')->name('category-list');
		Route::get('/edit/{id}','CategoryController@edit')->name('category-edit');
		Route::get('/delete/{id}','CategoryController@delete')->name('category-delete');
		Route::post('/update/{id}','CategoryController@update')->name('category-update');
		Route::get('get_child/category/{id}','CategoryController@getChild');
	});
	Route::group(['prefix'=>'product','middleware'=>['auth','admin']],function(){
		Route::get('/add','ProductController@add')->name('product-add'); 
		Route::post('/post','ProductController@store')->name('product-post');
		Route::get('get_child/category/{id}','CategoryController@getChild'); 
		Route::get('/list','ProductController@list')->name('product-list');
		Route::get('/edit/{id}','ProductController@edit')->name('product-edit');
		Route::get('/delete/{id}','ProductController@delete')->name('product-delete');
		Route::post('/update/{id}','ProductController@update')->name('product-update');
		//Route::get('get_child/category/{id}','CategoryController@getChild');   //ajax call route problem
		Route::get('/deleteImage/{id}','ProductController@deleteImage');
		Route::post('/update/{id}','ProductController@update')->name('product-update');
	});
	Route::group(['prefix'=>'offers','middleware'=>['auth','admin']],function(){
		Route::get('/add','OfferController@add')->name('offer-add'); 
		Route::get('/list','OfferController@list')->name('offer-list'); 
		Route::post('/post','OfferController@post')->name('offer-post'); 
		Route::get('/edit/{id}','OfferController@edit')->name('offer-edit');
		Route::post('/update/{id}','OfferController@update')->name('offer-update'); 
		Route::get('/delete/{id}','OfferController@delete')->name('offer-delete'); 
	});

});

Route::any('/add/cart/{id}/{quantity}','CartContoller@addToCart')->name('add-cart');
Route::get('/update/cart/','CartContoller@updateCart')->name('add-cart');
//Route::get('/getcartjson','FrontendContoller@getCartJson')->name('cart-json');
Route::any('/add/cart_/','CartContoller@addToCart_')->name('cart-add');
Route::any('/review/', 'ReviewController@addReview')->name('add-review');
Route::get('/product-info/{slug}','FrontendController@getProductInfo')->name('product-info');
Route::get('/cartjson','FrontendController@getCartJson');