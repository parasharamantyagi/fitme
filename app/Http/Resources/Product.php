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
			$product_array[] = $returnData;
		}
        return $product_array;
    }
}
