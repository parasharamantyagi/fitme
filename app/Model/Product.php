<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	// protected $table = 'customers';
    public function app_product_images(){
    	return $this->hasMany('App\Model\ProductImage', 'product_id', 'id');
    }
	
	public function product_field(){
    	return $this->hasMany('App\Model\ProductField', 'product_id', 'id')->where('status',1);
    }
	
	public function admin_product_field(){
    	return $this->hasMany('App\Model\ProductField', 'product_id', 'id');
    }
	
	public function product_images(){
    	return $this->hasMany('App\Model\ProductImage', 'product_id', 'id')->where('status',1)->where('product_field_id',0);
    }
}
