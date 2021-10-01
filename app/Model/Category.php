<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';
	
    public function field(){
    	return $this->hasOne('App\Model\Field', 'cat_id', 'id');
		// return $returnData;
    }
}
