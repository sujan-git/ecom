<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $fillable = [
        'description', 'name', 'product_id','user_rating'
    ];
}
