<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Model\Category;
use App\Model\Cart;
use DB;
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
		if(!$checkUser){
			$user_otp = rand(1111,9999);
			$user = new User([
				'name' => $request->name,
				'email' => $request->email,
				'phone' => $request->phone,
				'password' => bcrypt($request->password)
			]);
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
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        // $credentials['email_verified_at'] = Carbon::now();
		
        if(!Auth::attempt($credentials))
            return response()->json(api_response(0,'Invalid email or password',array()));
        $user = $request->user();
		if(!$user->email_verified_at)
			return response()->json(api_response(0,'Invalid email or password',array()));
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
					return response()->json(api_response(1, "OTP match successfully", $user_otp));
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
        return response()->json(api_response(1, "User list", $request->user()));
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
				$product = DB::table($allCat->field->table_name);
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
				$product = DB::table($allCat->field->table_name);
				if($request->id){
					$product = $product->where('id',$request->id);
				}
				$product = $product->first();
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
			$myCarts = Cart::where('user_id',$request->user()->id)->get();
			$product = array();
			foreach($myCarts as $myCart){
				$myCart_one  = $myCart;
				if($myCart->category->field){
					$product = DB::table($myCart->category->field->table_name)->where('id',$myCart->product_id)->first();
				}
				$resultArray[] = array(
							'id'=>$myCart_one->id,'user_id'=>$myCart_one->user_id,'cat_id'=>$myCart_one->cat_id,
							'product_id'=>$myCart_one->product_id,'quantity'=>$myCart_one->quantity,'status'=>$myCart_one->status,
							'created_at'=>$myCart_one->created_at,'updated_at'=>$myCart_one->updated_at,
							'category'=>array('id'=>$myCart_one->category->id,'title'=>$myCart_one->category->title),
							'product'=>$product
							);
			}
			return response()->json(api_response(1, "My cart", $resultArray));
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}