<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
	// protected $table = 'customers';
    public function product_field(){
    	return $this->hasOne('App\Model\ProductField', 'id', 'product_id');
    }
}
