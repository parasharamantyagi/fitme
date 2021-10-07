<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserFile extends Model
{
	protected $table="user_files";
	
	protected $fillable = [
        'user_id', 'name','my_file','my_folder','type'
    ];
	
	// public function order(){
		// return $this->hasMany('App\Order', 'user_order_id','id');
    // }
	
	// public function item(){
		// return $this->hasOne('App\Order', 'App\Item');
    // }
	
	
}
