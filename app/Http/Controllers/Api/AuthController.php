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
use App\Model\Cart;
use App\Model\PaymentHistory;
use App\Model\UserProduct;
use Stripe;
// use DB;
use Mail;

class AuthController extends Controller
{
	use ResponseTrait;
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
			if(!$checkUser->email_verified_at)
				$user = User::find($checkUser->id);
			$user->name = $request->name;
			$user->email = $request->email;
			$user->phone = $request->phone;
			$user->password = bcrypt($request->password);
			$user->save();
			$user->user_otp(array('user_id'=>$user->id,'otp'=>$user_otp,'status'=>0));
			$email_s = $request->email;
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
			}else if(count($request->all()) == 5 && $request->social_type && (strtoupper($request->social_type) == 'A' || strtoupper($request->social_type) == 'F' || strtoupper($request->social_type) == 'G' || strtoupper($request->social_type) == 'I')){
				$request->validate([
					'email' => 'required|string|email',
					'device_type' => 'required|string',
					'social_type' => 'required|string',
					'social_token' => 'required|string'
				]);
				$user = User::where('email',$request->input('email'))->first();
				if($user){
					User::where('id', $user->id)->update(array(
												'device_type'=>strtoupper($request->device_type),
												'social_type'=>strtoupper($request->social_type),
												'social_token'=>$request->social_token));
				}else{
					$user = User::create(array(
												'email'=>$request->email,
												'email_verified_at'=>Carbon::now(),
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
	
	
	public function getCategories(Request $request)
    {
		$allCat = Category::where('status',1)->get();
        return response()->json(api_response(1, "Category list", $allCat));
    }
	
	public function getProducts(Request $request)
    {
		try{
			$product =array();
			$allCat = Category::where('id',$request->cat_id)->first();
			if($allCat->field){
				$product = Product::with(['product_images'])->where('cat_id',$request->cat_id);
				if($request->name){
					$product = $product->where('Bra_name',$request->name);
				}
				$product = $product->get();
			}
			return response()->json(api_response(1, "Product list", $product));
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
				$product = Product::with(['product_images'])->where('id',$request->product_id)->first();
				$all_Cat['product'] = $product;
			}
			return response()->json(api_response(1, "Product list", $all_Cat));
		}catch(\Exception $e){
            return response($this->getApiErrorResponse($e->getMessage()));
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
					$product = Product::with('product_images')->where('id',$myCart->product_id)->first();
				$resultArray[] = array(
							'id'=>$myCart_one->id,'user_id'=>$myCart_one->user_id,'cat_id'=>$myCart_one->cat_id,
							'product_id'=>$myCart_one->product_id,'quantity'=>$myCart_one->quantity,'status'=>$myCart_one->status,
							'created_at'=>$myCart_one->created_at,'updated_at'=>$myCart_one->updated_at,
							'category'=>array('id'=>$myCart_one->category->id,'title'=>$myCart_one->category->title),
							'product'=>$product
							);
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
			$user = $request->user()->id;
			Stripe\Stripe::setApiKey(config('services.stripe.secret'));
			$products = Cart::with('product')->where('user_id',$user)->get();
			$userProduct = array();
			$createCharge = Stripe\Charge::create ([
					"amount" => $request->amount,
					"currency" => "USD",
					"source" => $request->token,
					"description" => "Making test payment." 
			]);
			// $payId = PaymentHistory::insertGetId(array('user_id'=>$user,'charge_id'=>'ch_3JkP8fFmFQnpPZgU0vEnjCd6','amount'=>50,'currency'=>'usd'));
			if($createCharge->id){
				$payId = PaymentHistory::insertGetId(array('user_id'=>$user,'charge_id'=>$createCharge->id,'amount'=>$createCharge->amount,'currency'=>$createCharge->currency,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()));
				foreach($products as $product){
					$userProduct[] = array('user_id'=>$user,'ph_id'=>$payId,'product_id'=>$product->product_id,'quantity'=>$product->quantity,'price'=>$product->product->price,'status'=>1);
				}
				UserProduct::insert($userProduct);
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
			$payHistorys = PaymentHistory::select('id','user_id','amount','currency','created_at')->where('user_id',$user)->orderBy('id', 'DESC')->get();
			foreach($payHistorys as $payHistory){
				$payHistory->my_order = UserProduct::with('product')->where('ph_id',$payHistory->id)->get();
				$myProductArray[] = $payHistory;
			}
			return response()->json(api_response(1, "My product list", $myProductArray));
		}catch(\Exception $e){
			return response($this->getApiErrorResponse($e->getMessage()));
        }
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}