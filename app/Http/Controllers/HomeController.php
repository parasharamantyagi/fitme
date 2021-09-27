<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;
use App\User;
use App\Traits\ResponseTrait;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Mail;


class HomeController extends Controller
{
    use ResponseTrait;
	
    public function index(){
		return view('welcome');
	}
	
	public function adminIndex(){
		
		return view('adminlogin');
		
	}
	
	public function forgetPassword(Request $request){
		$user = User::where('email',$request->email)->first();
		if($user){
			// return view('emails.email')->with('name',$user->name)->with('with_url',url('reset-password/'.Crypt::encrypt($user->id)));
			$email_s = $request->email;
			Mail::send('emails.email', ['name' => $user->name, 'with_url' => url('reset-password/'.Crypt::encrypt($user->id))], function ($message) use($email_s) {
				$message->from('uscisdev@gmail.com', 'USCIS');
				$message->to($email_s);
				$message->subject('Reset password');
			});
			return Redirect::to('/')->with('success_message','Please check your mail');
		}else{
			return Redirect::to('/')->with('invalid_email','This is invalid email');
		}
		
	}
	
	public function adminLoginPost(Request $request){
		$userdata = array(
			'email'     => $request->email,
			'password'  => $request->password,
			'roll_id'  => 2
		);
		if(Auth::attempt($userdata)) {
			$authUser = Auth::user()->roll_id;
			if($authUser === 1){
				return Redirect::to('provider/dashboard');
			}else if($authUser === 2){
				return Redirect::to('admin/dashboard');
			}else{
				return Redirect::to('/');
			}
		} else {
			return Redirect::to('/admin')->with('invalid_login','Invalid email or password');
		}
	}
	
	public function sendSms($data) {
    // Your Account SID and Auth Token from twilio.com/console
		$account_sid = 'ACdef2796627e6eec74dff940ed8cfef14';
		$auth_token = 'c4d4a9a7757bfadbdb1e111a62c4e400';
		$twilio_number = "+13233700709";
		$client = new Client($account_sid, $auth_token);
		return $client->messages->create(
				   $data['phone'], array(
				   'from' => $twilio_number,
				   'body' => $data['message'],
				 )
		);
	}
	
	
	
	public function twilioSand(Request $request){
		try {
			$this->sendSms(array('phone'=>+917830300796,'message'=>"hellooooooo"));
			print_r('wwwwwwwwwwwwwwww');
			// die('wwwwwwwwwwww');
		} catch (Exception $e) {
			die('wwwwwwaaaaaaaaaa');
            // dd("Error: ". $e->getMessage());
        }
		// return view('adminlogin');
		
	}
	
	
	public function loginPost(Request $request){
		
		// return $this->getErrorResponse('Invalid email or password');
		$userdata = array(
			'email'     => $request->email,
			'password'  => $request->password,
			'roll_id'  => 1,
			'status'  => 'Active'
		);
		if(Auth::attempt($userdata)) {
			$authUser = Auth::user()->roll_id;
			if($authUser === 1){
				$response['url'] = url('provider/dashboard');
				$response['message'] = 'provider login successfully';
				$response['delayTime'] = 5000;
				return $this->getSuccessResponse($response);
				// return Redirect::to('provider/dashboard');
			}else if($authUser === 2){
				$response['url'] = url('provider/dashboard');
				$response['message'] = 'admin login successfully';
				$response['delayTime'] = 5000;
				return $this->getSuccessResponse($response);
				// return Redirect::to('admin/dashboard');
			}else{
				$response['url'] = url('/');
				$response['message'] = 'admin login successfully';
				$response['delayTime'] = 5000;
				return $this->getSuccessResponse($response);
				// return Redirect::to('/');
			}
		} else {
			return $this->getErrorResponse('Invalid email or password');
		}
	}
	
	
	public function loginOut(){
		Auth::logout();
		return redirect('/');
	}

	public function does_url_exists($url) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($code == 200) {
			$status = true;
		} else {
			$status = false;
		}
		curl_close($ch);
		return $status;
	}
	
	public function searchResult(Request $request){
			
		try {
			if($request->client){
				$client = User::where('user_id',$request->client)->where('roll_id',3)->first();
				$image_name = 'https://softelevation.com/camip/images/'.$request->client.'.png';
				if($this->does_url_exists($image_name)){
					$client->image = $image_name;
				}
				$admin = User::where('id',$client->provider_id)->first();
				if($client){
					return view('searchResult')->with('client',$client)->with('admin',$admin);
				}else{
					return Redirect::to('/')->with('invaid_cient','This is invaid ID Number');
				}
			}else{
				return Redirect::to('/')->with('invaid_cient','ID Number is requred');
			}
		}catch(\Exception $e){
            return Redirect::to('/')->with('invaid_cient','This is invaid ID Number');
        }
	}
	
	public function updateimage(){
		
		
		$account_sid = getenv("SKd046b216db3592fd987c14a7ea8a1f66");
		$auth_token = getenv("mipwys9ZRvqoQDXTknKvPyFxqq45EYL7");
		$twilio_number = getenv("+916239463839");
		
		$client = new Twilio\Rest\Client($account_sid, $auth_token);
		$message = $client->messages->create(
		  $twilio_number, // Text this number
		  [
			'from' => '+9178303000796', // From a valid Twilio number
			'body' => 'Hello from Twilio!'
		  ]
		);
		// $client = new Client($account_sid, $auth_token);
		// $client->messages->create($recipients, 
            // ['from' => $twilio_number, 'body' => 'wwwwwwwwwww'] );
		// $input = $_REQUEST;
		print_r($message);
		die('wwwwwwwwwww');
		// return view('changePassword');
	}
	
	public function changePasswordPost(Request $request){
		$validations = array(
                'old_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required',
            );
		$validator = Validator::make($request->all(),$validations);
		if($validator->fails())
		  {
		   return redirect('change-password')->withErrors($validator)->withInput();
		  }	
			
		
		if($request->new_password == $request->confirm_password){
			$password_sss = Hash::make($request->new_password);
			$userId = Auth::user();
			$user_data = User::where('id',$userId->id)->first();
			if(Hash::check($request->old_password, $user_data->password)){
				User::where('id',$userId->id)->update(array('password'=>$password_sss));
				return Redirect::to('/change-password')->with('success_message','Your password has been change successfully');
			}else{
				return Redirect::to('/change-password')->with('error_message','Your old password does not match');
			}
		}else{
			return Redirect::to('/change-password')->with('error_message','Your confirm password does not match');
		}
	}
	
	public function updateimagePost(Request $request){
		header('Access-Control-Allow-Origin:  *');
		header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Authorization, Origin');
		header('Access-Control-Allow-Methods:  GET, POST, PUT, DELETE, OPTIONS');
		$request = $request->all();
		if(isset($request->href) && isset($request->user_id)){
			$image = $request['href'];
			$imageInfo = explode(";base64,", $image);     
			$image = str_replace(' ', '+', $imageInfo[1]);
			$file = base64_decode($image);
			$folderName = 'public/clients/';
			$safeName = time().'.png';
			$success = file_put_contents(public_path().'/clients/'.$safeName, $file);
			$safeName_image = 'clients/'.$safeName;
			User::where('user_id',$request['user_id'])->update(array('image'=>$safeName_image));
			return response()->json(['status' => 1], 200);
		}else{
			return response()->json(['status' => 0], 200);
		}
	}
	
	public function changePassword(){
		return view('changePassword');
	}
	
	public function checkVersion(){
		echo phpinfo();
		die();
		// return view('changePassword');
	}
	
	public function webOpen(Request $request){
		if($request->user_id){
			$user_id = $request->user_id;
		}else{
			$user_id = '';
		}
		return view('web_open')->with('user_id',$user_id);
	}
	
	
	public function resetPasswordPost(Request $request, $id){
		if($request->new_password){
			if($request->new_password == $request->confirm_password){
				User::find(Crypt::decrypt($id))->update(array('password'=>Hash::make($request->new_password)));
				return Redirect::to('/')->with('success_message','Your password has been successfully');
			}else{
				return Redirect::to('/reset-password/'.$id)->with('error_message','Your confirm password does not match');
			}
			// $password_sss = Hash::make($request->new_password);
			// $userId = Auth::user();
			// $user_data = User::where('id',$userId->id)->first();
			// if(Hash::check($request->old_password, $user_data->password)){
				// User::where('id',$userId->id)->update(array('password'=>$password_sss));
				// return Redirect::to('/change-password')->with('success_message','Your password has been change successfully');
			// }else{
				// return Redirect::to('/change-password')->with('error_message','Your old password does not match');
			// }
		}else{
			return view('resetPassword');
		}
	}
}
