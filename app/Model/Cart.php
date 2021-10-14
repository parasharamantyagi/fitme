<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	// protected $table = 'customers';
    // public function user(){
    	// return $this->belongsTo('App\User', 'user_id', 'id');
    // }
	
	public function category(){
    	return $this->hasOne('App\Model\Category', 'id', 'cat_id');
		// return $returnData;
    }
	
	public function product(){
    	return $this->hasOne('App\Model\Product', 'id', 'product_id');
		// return $returnData;
    }
}
