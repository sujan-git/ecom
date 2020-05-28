<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offers;
use App\Repositories\Offer\OfferRepository;
use Exception;
use File;

class OfferController extends Controller
{
    public function __construct(OfferRepository $offer){
        $this->offer= $offer;
    }

    public function add(){
    	return view('offer.add');
    }

    public function list(){
        $offers = $this->offer->getAll();
    	return view('offer.list')->with('offers',$offers);
    }

    public function post(Request $request){
        
        try{
            $this->offer->create($request->except('_token'));
            \Session::flash('success','Offer Added successfully');
        }catch(Exception $e){
            \Session::flash('error','Unable to add offer at this moment');
        }
        return redirect()->route('offer-list');
        
    }

    public function edit($id){
        $offer_data = $this->offer->getById($id);
        return view('offer.edit')->with('offer',$offer_data);
    }

    public function update(Request $request,$id){
        try {
           $this->offer->update( $id, $request->all() );
            \Session::flash('success','Offer Updated successfully');

        }catch( Exception $e ) {
            \Session::flash('error','Unable to Update Offer At This Moment...Internal ERROR');
        }

        return redirect()->route('offer-list');
    }
    

    public function delete($id){
        $this->offer->delete($id);
    	return redirect()->back()->with( 'success', 'Offer is Successfully deleted!!' );
    }

    
}
