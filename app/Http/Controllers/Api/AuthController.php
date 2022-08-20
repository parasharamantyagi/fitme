<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Model\Category;
use App\Model\Product;
use App\Model\ProductField;
use App\Model\Video;
use App\Model\CurlRequest;
use App\Model\WatchVideo;
use App\Model\Cart;
use App\Model\PaymentHistory;
use App\Model\UserProduct;
use App\Model\UserVoucher;
use App\Model\Order;
use App\Model\Token;
use App\Model\UserToken;
use App\Model\ReferralCode;
use Stripe;
use App\Helper\PlivoSms;
use Illuminate\Support\Facades\Crypt;
use App\Traits\CurlTrait;
// use DB;
use Mail;

use App\Http\Resources\Product as ProductResource;

// pr($this->paython_get_band_bust([
			// 'band' => 32, 
			// 'bust' => 38,
			// 'age' => 1,
		// ]));

class AuthController extends Controller
{
	use ResponseTrait, CurlTrait;
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed'
        ]);
		$checkUser = User::where('email',$request->email)->first();
		if(!$checkUser || !$checkUser->email_verified_at){
			$user_otp = rand(1111,9999);
			$user = new User;
			if($checkUser && !$checkUser->email_verified_at)
				$user = User::find($checkUser->id);
			$user->name = $request->name;
			$user->email = $request->email;
			$user->phone = $request->phone;
			if($request->year_of_birth){
				$user->year_of_birth = $request->year_of_birth;
			}
			$user->password = bcrypt($request->password);
			$user->save();
			$user->user_otp(array('user_id'=>$user->id,'otp'=>$user_otp,'status'=>0));
			$email_s = $request->email;
			if($request->referral_code){
				if (base64_decode($request->referral_code, true)) {
					ReferralCode::updateOrCreate(
					array('user_id'=>$user->id),
					array(
								'user_id'=>$user->id,'referral_id'=>base64_decode($request->referral_code),
								'referral_code'=>rand(111111,999999),'amount'=>20.00,'created_at'=>Carbon::now(),
								'updated_at'=>Carbon::now()
					));
				}
				
			}
			Mail::send('emails.verify', ['name' => $user->name, 'otp' => $user_otp], function ($message) use($email_s) {
				$message->from('uscisdev@gmail.com', 'FITME');
				$message->to($email_s);
				$message->subject('Reset password');
			});
			return response()->json(api_response(1,"User Create successfully",$user));
		}else{
			return response()->json(api_response(0,"This email is already exit",array()));
		}
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        try{
			if($request->social_type && strtoupper($request->social_type) == 'N')
			{
				$request->validate([
					'email' => 'required|string|email',
					'password' => 'required|string',
					'remember_me' => 'boolean'
				]);
				$credentials = request(['email', 'password']);
				if(!Auth::attempt($credentials))
					return response()->json([
						'message' => 'Unauthorized'
					], 401);
				$user = $request->user();
				User::where('id', $user->id)->update(array('device_token'=>$request->device_token));
				if(!$user->email_verified_at)
					return response()->json(api_response(0,"This is invalid email or password",(object)array()));
				$tokenResult = $user->createToken('Personal Access Token');
				$token = $tokenResult->token;
				if ($request->remember_me)
					$token->expires_at = Carbon::now()->addWeeks(1);
				$token->save();
				
				return response()->json(api_response(1,"User login successfully",[
					'access_token' => $tokenResult->accessToken,
					'token_type' => 'Bearer',
					'expires_at' => Carbon::parse(
						$tokenResult->token->expires_at
					)->toDateTimeString()
				]));
			}else if(count($request->all()) == 6 && $request->social_type && (strtoupper($request->social_type) == 'A' || strtoupper($request->social_type) == 'F' || strtoupper($request->social_type) == 'G' || strtoupper($request->social_type) == 'I')){
				$request->validate([
					'email' => 'required|string|email',
					'device_type' => 'required|string',
					'social_type' => 'required|string',
					'social_token' => 'required|string'
				]);
				$user = User::where('email',$request->input('email'))->first();
				if($user){
					User::where('id', $user->id)->update(array(
												'device_token'=>$request->device_token,
												'device_type'=>strtoupper($request->device_type),
												'social_type'=>strtoupper($request->social_type),
												'social_token'=>$request->social_token));
				}else{
					$user = User::create(array(
												'email'=>$request->email,
												'email_verified_at'=>Carbon::now(),
												'device_token'=>$request->device_token,
												'device_type'=>strtoupper($request->device_type),
												'social_type'=>strtoupper($request->social_type),
												'social_token'=>$request->social_token));				
				}
				
				$tokenResult = $user->createToken('Personal Access Token');
				$token = $tokenResult->token;
				if ($request->remember_me)
					$token->expires_at = Carbon::now()->addWeeks(1);
				$token->save();
				return response()->json(api_response(1,"User login successfully",[
						'access_token' => $tokenResult->accessToken,
						'token_type' => 'Bearer',
						'expires_at' => Carbon::parse(
							$tokenResult->token->expires_at
						)->toDateTimeString()
					]));
			}else{
				return response()->json(api_response(0,"This is invalid entry",(object)array()));
			}
		}catch(\Exception $e){
            return response(api_response(0,$e->getMessage(),array()));
        }
    }
	
	public function forgotPassword(Request $request){
		try{
			$request->validate([
				'email' => 'required|string|email'
			]);
			$user_otp = User::select(['id','name'])->where('email',$request->email)->first();
			if($user_otp){
				$email_s = $request->email;
				Mail::send('emails.email', ['name' => $user_otp->name, 'with_url' => url('reset-password/'.Crypt::encrypt($user_otp->id))], function ($message) use($email_s) {
					$message->from('uscisdev@gmail.com', 'FITME');
					$message->to($email_s);
					$message->subject('Reset password');
				});
				return response()->json(api_response(1, "Please check you mail for reset password", array()));
			}else{
				return response()->json(api_response(0, "This email id does not exit", array()));
			}
		}catch(\Exception $e){
			return response($this->getApiErrorResponse($e->getMessage()));
        }
	}
	
	public function verifyOtp(Request $request)
    {
		try{
			$request->validate([
				'email' => 'required|string|email',
				'otp' => 'required',
			]);
			$credentials = request(['email', 'otp']);
			$user_otp = User::select(['users.id','otps.otp'])->join('otps','otps.user_id','users.id')->where('users.email',$credentials['email'])->first();
			if($user_otp){
				if($user_otp->otp == $credentials['otp']){
					User::where('id',$user_otp->id)->update(array('email_verified_at'=>Carbon::now()));
					ReferralCode::where('user_id',$user_otp->id)->update(array('status'=>1));
					$tokenResult = $user_otp->createToken('Personal Access Token');
					return response()->json(api_response(1, "OTP match successfully", [
						'access_token' => $tokenResult->accessToken,
						'token_type' => 'Bearer',
						'expires_at' => Carbon::parse(
							$tokenResult->token->expires_at
						)->toDateTimeString()
					]));
				}else{
					return response()->json(api_response(0, "Your otp does not match", array()));
				}
			}else{
				return response()->json(api_response(0, "Sorry this is invalid request", array()));
			}
		}catch(\Exception $e){
            return response($this->getApiErrorResponse($e->getMessage()));
        }
	}
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
		$userData = remove_null($request->user()->toArray());
		$userData['referral_code'] = base64_encode($userData['id']);
        return response()->json(api_response(1, "User list", $userData));
    }
	
	
	/**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function userProfileUpdate(Request $request)
    {
		$my_user = $request->user();
		$updateData = array_filter($request->all());
		User::where('id',$my_user->id)->update($updateData);
		$user = User::find($my_user->id);
        return response()->json(api_response(1, "User update successfully", $user));
    }
	
	/**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function notificationStatus(Request $request)
    {
		$my_user = $request->user();
		$updateData = $request->all();
		User::where('id',$my_user->id)->update($updateData);
		$user = User::find($my_user->id);
        return response()->json(api_response(1, "Notification has been update successfully", $user));
    }
	
	public function notificationPost(Request $request)
    {
		$inputData = explode('_',$request->folder);
		$user = User::find($inputData[1]);
		$cccccccccc = array();
		if($user->notification_status){
			$cccccccccc = PlivoSms::push_notification($user->device_token,"Your new 3D-Model has been generated",1);
		}
		return response()->json(api_response(1, "Notification send successfully", $cccccccccc));
	}
	
	public function reset_password(Request $request)
    {
		$my_user = $request->user();
		$updateData = $request->all();
		// $user->password = bcrypt($request->password);
		if(Auth::guard('web')->attempt(array('email'=>$my_user->email,'password'=>$updateData['old']), false, false)) {
			User::where('id',$request->user()->id)->update(array('password'=>bcrypt($updateData['new'])));
			return response()->json(api_response(1, "Your password has been update successfully", $my_user));
		  } else {
			return response()->json(api_response(0, "Your old password does't match", $my_user));
		 }
	}
	
	public function curlRequestPost(Request $request)
    {
		$inputData = array();
		if($request->user_id){
			$inputData['user_id'] = $request->user_id;
		}
		if($request->destination){
			$inputData['destination'] = $request->destination;
		}
		if($request->status){
			$inputData['status'] = $request->status;
		}
		if($request->user_id){
			$device_token = User::select(['device_token','notification_status'])->where('id',$request->user_id)->first();
			if($device_token->notification_status){
				if((int)$request->status){
					PlivoSms::push_notification($device_token->device_token,'Your latest 3D model is ready to download',1);
				}else{
					PlivoSms::push_notification($device_token->device_token,'Sorry to inform for that there was a problem in processing your information please can yourself again',2);
				}
			}
		}
		CurlRequest::insert($inputData);
		return response()->json(true);
	}
	
	public function getCategories(Request $request)
    {
		$allCat = Category::where('status',1)->get();
        return response()->json(api_response(1, "Category list", $allCat));
    }
	
	public function getVideo(Request $request)
    {
		$returnData = array();
		$allVideos = Video::where('status',1)->get();
		foreach($allVideos as $my_video){
			$watchVideo = WatchVideo::where('user_id',$request->user()->id)->where('video_id',$my_video->id)->first();
			$my_video->is_seen = ($watchVideo) ? 1 : 0;
			$returnData[] = $my_video;
		}
        return response()->json(api_response(1, "Video list", $returnData));
    }
	
	public function watchVideo(Request $request)
    {
		$inputData = $request->all();
		$inputData['user_id'] = $request->user()->id;
		$inputData['created_at'] = Carbon::now();
		$inputData['updated_at'] = Carbon::now();
		WatchVideo::insert($inputData);
        return response()->json(api_response(1, "Your activity saved successfully", $inputData));
    }
	
	public function getProducts(Request $request)
    {
		try{
			$product =array();
			$product_array = array();
			$allCat = Category::where('id',$request->cat_id)->first();
			$brand_name = json_decode($allCat->field->filed);
			$brand_name_arrays = $brand_name[0]->field;
			$brand_array = array();
			foreach($brand_name_arrays as $key => $brand_name_array){
				$brand_array[] = array("name"=>$key,"value"=>$brand_name_array);
			}
			if($allCat->field){
				$product = Product::with(['product_images','product_field.product_field_images'])->where('cat_id',$request->cat_id)->where('status',1);
				if($request->name){
					$product = $product->where('Bra_name',$request->name);
				}
				if($request->brand_name){
					$product = $product->whereIn('brand_name',$request->brand_name);
				}
				$product = $product->orderBy('id', 'DESC')->paginate(10);
			}
			$product = $product->toArray();
			$product_array['current_page'] = $product['current_page'];
			$product_array['data'] = new ProductResource($product['data']);
			$product_array['first_page_url'] = $product['first_page_url'];
			$product_array['from'] = $product['from'];
			$product_array['last_page'] = $product['last_page'];
			$product_array['last_page_url'] = $product['last_page_url'];
			$product_array['next_page_url'] = $product['next_page_url'];
			$product_array['path'] = $product['path'];
			$product_array['per_page'] = $product['per_page'];
			$product_array['prev_page_url'] = $product['prev_page_url'];
			$product_array['to'] = $product['to'];
			$product_array['total'] = $product['total'];
			return response()->json(array("status"=>1,"message"=>"Product list","data"=>remove_null($product_array),'brand_name'=>$brand_array));
		}catch(\Exception $e){
            return response($this->getApiErrorResponse($e->getMessage()));
        }
    }
	
	public function getProductDetail(Request $request)
    {
		try{
			$product =array();
			$all_Cat =array();
			$allCat = Category::select(['id','title','stock','status'])->where('id',$request->cat_id)->first();
			$all_Cat =array('id'=>$allCat->id,'title'=>$allCat->title,
							'stock'=>$allCat->stock,'status'=>$allCat->status);
			if($allCat->field){
				$product = Product::with(['product_images','product_field.product_field_images'])->where('id',$request->product_id)->first();
				$all_Cat['product'] = $product;
			}
			return response()->json(api_response(1, "Product list", $all_Cat));
		}catch(\Exception $e){
            return response($this->getApiErrorResponse($e->getMessage()));
        }
    }
	
	
	/**
     * Get the authenticated Referral
     *
     * @return [json] Referral object
     */
    public function myReferral(Request $request)
    {
		$referralCode = ReferralCode::where('referral_id',$request->user()->id)->where('status',1)->get();
        return response()->json(api_response(1, "My active voucher code", $referralCode));
    }
	
	public function myVoucher(Request $request)
    {
		$userVoucher = UserVoucher::where('user_id',$request->user()->id)->where('status',1)->pluck('token_id')->toArray();
		$referralCode = Token::select('*')->whereNotIn('id',$userVoucher)->where('category','membership_voucher')->get();
        return response()->json(api_response(1, "My Voucher code", $referralCode));
    }
	
	public function myActiveVoucher(Request $request)
    {
		$referralCode = Token::select('tokens.*')
		->join('user_vouchers', 'user_vouchers.token_id', 'tokens.id')
		->where('user_vouchers.user_id',$request->user()->id)
		->where('user_vouchers.status',1)
		->where('tokens.category','membership_voucher')->get();
        return response()->json(api_response(1, "My Active Voucher code", $referralCode));
    }
	
	
	public function addVoucherPost(Request $request)
    {
		$inputData = $request->all();
		$inputData['user_id'] = $request->user()->id;
		
		if ($request->hasFile('image')) {
		   $files = $request->file('image');
		   unset($inputData['image']);
		   foreach ($files as $file) {
			   $namefile = 	rand(1,999999) .time() . '.' . $file->getClientOriginalExtension();
			   $destinationPath = public_path('/voucher'); //public path folder dir
			   $file->move($destinationPath, $namefile);
			   $inputData['image'][] = 'voucher/'.$namefile;
		   }
		   if(count($inputData['image']) == 2){
			   $inputData['front_image'] = $inputData['image'][0];
			   $inputData['back_image'] = $inputData['image'][1];
		   }else{
			   $inputData['front_image'] = $inputData['image'][0];
		   }
		   unset($inputData['image']);
		}
		$inputData['status'] = 0;
		UserVoucher::insert($inputData);
        return response()->json(api_response(1, "Voucher detail add successfully", $inputData));
    }
	
	public function applyReferral(Request $request)
    {
		$inputData = $request->all();
		if($request->type && $request->type == 'referral'){
			$referralCode = ReferralCode::where('referral_id',$request->user()->id)->where('referral_code',$request->token)->where('status',1)->first();
			if($referralCode){
				$update_array = array('is_used'=>1);
				$message = "Your token has been apply";
				if($request->action && $request->action === 'remove'){
					$update_array = array('is_used'=>0);
					$message = "Your token has been remove";
				}
				$referralCode->update($update_array);
				return response()->json(api_response(1, $message, $referralCode));
			}else{
				return response()->json(api_response(0, "This is invalid token", $inputData));
			}
		}elseif($request->type && $request->type == 'membership_voucher'){
			$referralCode = UserVoucher::join('tokens','tokens.id','user_vouchers.token_id')->where('tokens.token_name',$request->token)->where('user_id',$request->user()->id)->where('category','membership_voucher')->first();
			if($referralCode){
				UserToken::insert(array('user_id'=>$request->user()->id,'token_id'=>$referralCode->token_id,'status'=>0,'created_at'=>Carbon::now()));
				return response()->json(api_response(1, "Your token has been apply", $referralCode));
			}else{
				return response()->json(api_response(0, "This is invalid token", $inputData));
			}
		}else{
			$referralCode = Token::where('token_name',$request->token)->first();
			if($referralCode){
				UserToken::insert(array('user_id'=>$request->user()->id,'token_id'=>$referralCode->id,'status'=>0,'created_at'=>Carbon::now()));
				return response()->json(api_response(1, "Your token has been apply", $referralCode));
			}else{
				return response()->json(api_response(0, "This is invalid token", $inputData));
			}
		}
    }
	
	public function getCart(Request $request)
    {
		try{
			$resultArray =array();
			$message = 'My cart item';
			$myCarts = Cart::where('user_id',$request->user()->id)->get();
			$product = array();
			$total_amount = array();
			foreach($myCarts as $myCart){
				$myCart_one  = $myCart;
				$product_id = $myCart->product_id;
				$my_product = ProductField::where('id',$product_id)->first();
				$my_product->total_quantity = $my_product->quantity;
				$my_product->quantity = $myCart_one->quantity;
				$product = Product::with(['product_images'])->where('id',$my_product->product_id)->first();
				$resultArray[] = array(
							'id'=>$myCart_one->id,'user_id'=>$myCart_one->user_id,'cat_id'=>$myCart_one->cat_id,
							'product_id'=>$myCart_one->product_id,'quantity'=>$myCart_one->quantity,'status'=>$myCart_one->status,
							'created_at'=>$myCart_one->created_at,'updated_at'=>$myCart_one->updated_at,
							'category'=>array('id'=>$myCart_one->category->id,'title'=>$myCart_one->category->title),
							'my_product'=>$my_product,'product'=>$product
							);
				if($product && $product->price)
					$total_amount[] = $myCart_one->quantity * $product->price;
			}
			if(empty($resultArray)){
				$message = 'No item in cart';
			}
			return response()->json(api_response(1, $message, array('total_amount'=>array_sum($total_amount),'vat'=>'0%','my_item'=>$resultArray)));
		}catch(\Exception $e){
            return response($this->getApiErrorResponse($e->getMessage()));
        }
    }
	
	
	public function addCart(Request $request)
    {
		try{
			$inputData = $request->all();
			$inputData['user_id'] = $request->user()->id;
			$inputData['status'] = 1;
			$inputData['created_at'] = Carbon::now();
			$inputData['updated_at'] = Carbon::now();
			$resultArray =array();
			Cart::insert($inputData);
			return response()->json(api_response(1, "Add to cart successfully", $resultArray));
		}catch(\Exception $e){
			return response($this->getApiErrorResponse($e->getMessage()));
        }
	}
	
	public function updateCart(Request $request)
    {
		try{
			$quantity = $request->quantity;
			foreach($request->id as $key => $my_val){
				Cart::where('id',$my_val)->update(array('quantity'=>$quantity[$key]));
			}
			return response()->json(api_response(1, "Cart update successfully", array()));
		}catch(\Exception $e){
			return response($this->getApiErrorResponse($e->getMessage()));
        }
	}
	
	public function removeCart(Request $request)
    {
		try{
			$resultArray =array();
			Cart::where('id',$request->id)->delete();
			return response()->json(api_response(1, "Cart remove successfully", $resultArray));
		}catch(\Exception $e){
			return response($this->getApiErrorResponse($e->getMessage()));
        }
	}
	
	public function proceedToCheckout(Request $request)
    {
		try{
			// GBP
			$user = $request->user()->id;
			// $stripe = new \Stripe\StripeClient(
			  // 'sk_test_51JdZSuFmFQnpPZgUeFWN6NDtUalFH3j9Y8HtK3f63K2GqjPCgsfS6ETqriL5bVVgE1DqQsGQu56yjbCrKR31Ha1n00CrrDekew'
			// );
			// $uuuuu = $stripe->tokens->create([
			  // 'card' => [
				// 'number' => '4242424242424242',
				// 'exp_month' => 2,
				// 'exp_year' => 2023,
				// 'cvc' => '314',
			  // ],
			// ]);
			// pr($uuuuu);
			Stripe\Stripe::setApiKey(config('services.stripe.secret'));
			$products = Cart::with('product')->where('user_id',$user)->get();
			$userProduct = array();
			$my_amount = $request->amount;
			$charge_amount = round($request->amount);
			$createCharge = Stripe\Charge::create ([
					"amount" => $charge_amount * 100,
					"currency" => "GBP",
					"source" => $request->token,
					"description" => "Payment has been done for Tesco" 
			]);
			if($createCharge->id){
				$my_order = array('user_id'=>$user,'amount'=>$my_amount);
				if($request->token_id){
					$my_order['token_id'] = $request->token_id;
				}
				$Oid = Order::insertGetId($my_order);
				ReferralCode::where('referral_id',$user)->where('is_used',1)->update(array('status'=>0));
				$payId = PaymentHistory::insertGetId(array('user_id'=>$user,'order_id'=>$Oid,'charge_id'=>$createCharge->id,'amount'=>$my_amount,'currency'=>$createCharge->currency,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()));
				foreach($products as $product){
					$productField = ProductField::find($product->product_id);
					$userProduct[] = array('user_id'=>$user,'order_id'=>$Oid,'product_id'=>$product->product_id,'quantity'=>$product->quantity,'color'=>$product->color,'price'=>$productField->product->price,'status'=>1);
				}
				UserProduct::insert($userProduct);
				UserToken::where('user_id',$user)->where('status',0)->update(array('status'=>1,'updated_at'=>Carbon::now()));
				Cart::where('user_id',$user)->delete();
			}
			return response()->json(api_response(1, "Product buy successfully", $userProduct));
		}catch(\Exception $e){
			return response($this->getApiErrorResponse($e->getMessage()));
        }
	}
	
	public function myProduct(Request $request){
		try{
			$user = $request->user()->id;
			$myProductArray = array();
			$payHistorys = Order::select('id','user_id','amount','created_at')->where('user_id',$user)->orderBy('id', 'DESC')->get();
			foreach($payHistorys as $payHistory){
				$payHistory->my_order = UserProduct::with('product')->where('order_id',$payHistory->id)->get();
				$myProductArray[] = $payHistory;
			}
			return response()->json(api_response(1, "My product list", $myProductArray));
		}catch(\Exception $e){
			return response($this->getApiErrorResponse($e->getMessage()));
        }
	}
	
	public function testing(Request $request)
    {
		try{
			$input = $request->all();
			// $array_val = array('aaa');
			// if($request->example){
				// array_push($array_val,$request->example);
			// }
			// pr($array_val);
			return response()->json(api_response(1, "testing 1", array()));
		}catch(\Exception $e){
			return response($this->getApiErrorResponse($e->getMessage()));
        }
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}