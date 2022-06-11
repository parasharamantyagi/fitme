<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	// protected $table = 'customers';
    public function user_product(){
    	return $this->hasMany('App\Model\UserProduct', 'order_id', 'id');
    }
}
