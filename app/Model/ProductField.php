<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductField extends Model
{
	protected $table = 'product_fields';
    // public function app_product_images(){
    	// return $this->hasMany('App\Model\ProductImage', 'product_id', 'id');
    // }
	
	public function product_field_images(){
    	return $this->hasMany('App\Model\ProductImage', 'product_field_id', 'id')->where('status',1);
    }
	
	public function admin_product_field_images(){
    	return $this->hasMany('App\Model\ProductImage', 'product_field_id', 'id');
    }
	
	public function product(){
    	return $this->hasOne('App\Model\Product', 'id', 'product_id');
		// return $returnData;
    }
}
