<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Model\BandBust;
// use App\Model\Product;
// use App\Model\Cart;
// use App\Model\PaymentHistory;
// use App\Model\UserProduct;
// use App\Model\Order;
use Stripe;
use App\Helpers\PlivoSms;
// use DB;
use Mail;

use App\Http\Resources\Product as ProductResource;

class BandController extends Controller
{
	use ResponseTrait;
	
	public function getBandBust(Request $request){
		try{
			$response = array();
			$user_id = $request->user()->id;
			$band_busts = BandBust::where('user_id',$user_id)->get();
			foreach($band_busts as $band_bust){
				if (!file_exists('user_image/'.$band_bust->image_path.'/image001.jpeg')) {
					$band_bust['image_url'] = "";
				}else{
					$band_bust['image_url'] = 'user_image/'.$band_bust->image_path.'/image001.jpeg';
				}
				$response[] = $band_bust;
			}
			return response()->json(api_response(1, "Band Bust list", $response));
		}catch(\Exception $e){
			return response($this->getApiErrorResponse($e->getMessage()));
        }
	}
	
	public function addBandBust(Request $request){
		try{
			$input = $request->all();
			$input['user_id'] = $request->user()->id;
			BandBust::insert($input);
			$content_array = array($input["band"],$input["bust"]);
			if($request->example){
				array_push($content_array,$request->example);
				// $content_array = array($input["band"],$input["bust"],$input["example"],$input["age"]);
			}else{
				array_push($content_array,"0.00");
			}
			if($request->age){
				array_push($content_array,$request->age);
			}else{
				array_push($content_array,0);
			}
			$content = implode(",",$content_array);
			$fp = fopen(public_path('/bb/'.$input['image_path'].'.txt'),"wb");
			fwrite($fp,$content);
			fclose($fp);
			return response()->json(api_response(1, "Band Bust add successfully", $input));
		}catch(\Exception $e){
			return response($this->getApiErrorResponse($e->getMessage()));
        }
	}
	
	public function deleteBandBust(Request $request,$id){
		try{
			$user_id = $request->user()->id;
			BandBust::where('id',$id)->where('user_id',$user_id)->delete();
			$band_bust = BandBust::where('user_id',$user_id)->get();
			return response()->json(api_response(1, "Band Bust delete successfully", $band_bust));
		}catch(\Exception $e){
			return response($this->getApiErrorResponse($e->getMessage()));
        }
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}