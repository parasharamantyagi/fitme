<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
	public function implementFunction($arrayData,$whereObj){
		return array_map(function ($a) { return $a; },array_filter($arrayData,function ($a) use ($whereObj) {
					 if(array_key_exists('cup_size',$whereObj) && array_key_exists('band_size',$whereObj)){
						 if($whereObj['cup_size'] && $whereObj['band_size']){
							 if($a['Cup_size_ID'] === $whereObj['cup_size'] && $a['Band_size_ID'] === $whereObj['band_size']){
								 return true;
							 }else{
								 return false;
							 }
						 }else{
							 return true;
						 }
					 }else{
						 return true;
					 }
                   })
                 );
	}
	
    public function toArray($request)
    {	
		$product_array = array();
		$returnDatas = parent::toArray($request);
		foreach($returnDatas as $returnData){
			if(!count($returnData['product_images'])){
				$returnData['product_images'] = array(array(
									'id'=>0,
									'file_path'=>'products/logo.jpg',
									'product_id'=>$returnData['id'],
									'image_id'=>00000,
									'status'=>1,
									'created_at'=>"",
									'updated_at'=>""
						));
			}
			$returnData['product_field'] = $this->implementFunction($returnData['product_field'],$request->all());
			if($returnData['product_field']){
				$product_array[] = $returnData;
			}
		}
        return $product_array;
    }
}
