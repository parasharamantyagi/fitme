<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	// protected $table = 'customers';
    public function product_images(){
    	return $this->hasMany('App\Model\ProductImage', 'product_id', 'id');
    }
}
