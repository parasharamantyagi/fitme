<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
	// protected $table = 'customers';
    public function my_product(){
    	return $this->hasMany('App\Model\UserProduct', 'ph_id', 'id');
    }
}
