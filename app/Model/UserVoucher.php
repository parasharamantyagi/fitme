<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
	protected $table = 'user_vouchers';
    // public function app_product_images(){
    	// return $this->hasMany('App\Model\ProductImage', 'product_id', 'id');
    // }
	
	// public function product_field_images(){
    	// return $this->hasMany('App\Model\ProductImage', 'product_field_id', 'id')->where('status',1);
    // }
}
