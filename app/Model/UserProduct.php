<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
	// protected $table = 'customers';
    public function product(){
    	return $this->hasOne('App\Model\Product', 'id', 'product_id');
    }
}
