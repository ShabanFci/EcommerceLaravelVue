<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    protected $fillable = ['product_id','user_id','quantity','address'];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function product(){
    	return $this->belongsTo(Product::class);
    }
}
