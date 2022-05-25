<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
	protected $table = 'user_vouchers';
	
	protected $fillable = [
        'user_id', 'token_id','fron_image','back_image','description','status'
    ];
	
    public function user_detail(){
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
	
	public function token_detail(){
    	return $this->hasOne('App\Model\Token', 'id', 'token_id');
    }
	
	// public function product_field_images(){
    	// return $this->hasMany('App\Model\ProductImage', 'product_field_id', 'id')->where('status',1);
    // }
}
