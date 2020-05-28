<?php



namespace App\Http\ViewComposers;
use App\Category;
use App\Cart;
use Auth;
use Illuminate\Http\Request;

use Illuminate\View\View;

class HeaderComposer {


	public function __construct( Request $request,Category $category ,Cart $cart) {
		$this->request = $request;
			$this->category = $category;
			$this->cart = $cart;
	}

	public function compose( View $view ) {
		$parent_cats = $this->category->getParentCategory();
		$view->with( 'parent_cats', $parent_cats )
			  ;	
	}

}
