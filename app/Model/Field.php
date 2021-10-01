<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
	protected $table = 'fields';
	
    public function category(){
    	return $this->belongsTo('App\Model\Category', 'cat_id', 'id');
    }
}
