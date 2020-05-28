<?php

namespace App\Repositories\Offer;

use App\Offers;
use File;

class EloquentOffer implements OfferRepository{

	private $offer;

    public function __construct(Offers $offer){
        $this->offer = $offer;
    }

    public function getAll(){
        return $this->offer->all();
    }

    public function getById($id){
        return $this->offer->findOrFail($id);
    }

    public function create(array $attributes){
        $attributes['slug'] = $this->offer->getSlug($attributes['title']);
        if (isset($attributes['banner_image'])) {
            $path = public_path() . "/uploads/bannerimage";
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $file_name = "Banner-" . date('Ymdhis') . rand(0, 999) . "." . $attributes['banner_image']->getClientOriginalExtension();
                $attributes['banner_image']->move($path, $file_name);
                $attributes['banner_image'] = $file_name;
        }
        $offer = $this->offer->create($attributes);
        return $offer;
    }

    public function update($id, array $attributes){
        $offer = $this->getById($id);
        $img = $offer->banner_image;
        $attributes['slug'] = $this->offer->getSlug($attributes['title']);
            if(isset($attributes['banner_image'])){
                if($img != '' && file_exists(public_path().'/uploads/bannerimage/'.$img)){
                    unlink(public_path().'/uploads/bannerimage/'.$img);
                }
                $path = public_path() . "/uploads/bannerimage";
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $file_name = "Banner-" . date('Ymdhis') . rand(0, 999) . "." . $attributes['banner_image']->getClientOriginalExtension();
                $attributes['banner_image']->move($path, $file_name);
                $attributes['banner_image'] = $file_name;
            }
        
         $offer = $offer->update($attributes);

        return $offer;
    }

    public function delete($id){
        $offer = $this->getById($id);
        $img = $offer->banner_image;
        if($img != '' && file_exists(public_path().'/uploads/bannerimage/'.$img)){
            unlink(public_path().'/uploads/bannerimage/'.$img);
        }
        $offer->delete();
        return true;
    }
}