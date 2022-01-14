<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
	// protected $table = 'customers';
    public function product(){
    	return $this->belongsTo('App\Model\Product', 'product_id', 'id');
    }
}
