<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WatchVideo extends Model
{
	protected $table = 'watch_videos';
	
	protected $fillable = [
        'video_id', 'user_id'
    ];
    // public function product(){
    	// return $this->hasOne('App\Model\Product', 'id', 'ph_id');
    // }
}
