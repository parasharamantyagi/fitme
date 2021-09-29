<?php
// use Auth;
use App\User;

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

?>
