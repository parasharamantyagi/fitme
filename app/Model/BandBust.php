<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class BandBust extends Model
{
	protected $table="band_busts";
	
	protected $fillable = [
        'user_id', 'bust','band','age','date','image_path'
    ];
	
	// public function order(){
		// return $this->hasMany('App\Order', 'user_order_id','id');
    // }
	
	// public function item(){
		// return $this->hasOne('App\Order', 'App\Item');
    // }
	
	
}
