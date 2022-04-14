<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReferralCode extends Model
{
	protected $table = 'referral_codes';
	
	protected $fillable = [
        'user_id', 'referral_id','referral_code','amount','status','is_used'
    ];
    // public function product(){
    	// return $this->hasOne('App\Model\Product', 'id', 'ph_id');
    // }
}
