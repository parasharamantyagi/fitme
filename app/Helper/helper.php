<?php
// use Auth;
use App\User;
use Illuminate\Support\Facades\Crypt;


if (! function_exists('user_url')) {
	
    function user_url($value) {
		
		if(Auth::user()->roll_id == 1){
			return 'provider/'.$value;
		}else if(Auth::user()->roll_id == 2){
			return 'admin/'.$value;
		}else{
			return 'provider/'.$value;
		}
		
        // $token= '251e40bf7def2e9d52dc5332eede9798ea04dce671b1bb5c55ea0a8ed5354e36';
        // return $token;
    }
}

/*
     * @method       :  encryptDataId
     * @created_date :  22-03-2019
     * @purpose      :  to encrypt the data
     */
    function encryptID($id = null) {
        if ($id) {
            return Crypt::encrypt($id);
        }
        return false;
    }

    /*
     * @method       : decryptDataId
     * @created_date : 22-03-2019
     * @purpose      : to decrypt the data
     */
    function decryptId($encrypted_string = null) {
        if ($encrypted_string) {
            return Crypt::decrypt($encrypted_string);
        }
        return false;
    }
	
	function name_of_filed($input,$val) {
		return array_column(json_decode($input), $val);
	}
	
	function validation_name_of_filed($input) {
		$array_columns = array_column(json_decode($input), 'name');
		$new_array = [];
		foreach ($array_columns as $value) 
			$new_array[$value] = 'required';
		return $new_array;
	}
	

	if (!function_exists('remove_null')) {
		function remove_null($array){
			return array_map(function($v){
					return (is_null($v)) ? "" : $v;
				},$array);
		}
	}


if (!function_exists('api_response')) {
	
	function api_response($status,$message,$data)
    {
        return array("status"=>$status,"message"=>$message,"data"=>$data);
    }
}


if (! function_exists('my_fitme')) {
	
    function my_fitme($provider_id,$card_rate) {
		$users = User::with(['user_detail'])->where('provider_id',$provider_id)->orderBy('id','DESC')->count();
		if(!$users){
			$users = 1;
		}
        return $users * $card_rate;
    }
}


if (! function_exists('user_card_rate')) {
	
    function user_card_rate($provider_id,$card_rate) {
		$users = User::with(['user_detail'])->where('provider_id',$provider_id)->orderBy('id','DESC')->count();
		if(!$users){
			$users = 1;
		}
        return $users * $card_rate;
    }
}

if (! function_exists('my_currecy')) {
    function my_currecy($val) {
        return '£ '.$val;
    }
}

if (! function_exists('product_first_image')) {
    function product_first_image($input) {
		if(isset($input[0])){
			$my_ob = $input[0];
			return $my_ob->file_path;
		}else{
			return 'products/no_product_image.png';
		}
    }
}



?>
