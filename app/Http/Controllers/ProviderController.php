<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;
use App\User;
use App\UserDetail;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Hash;
Use Illuminate\Support\Facades\Validator;
// use App\Helpers\PlivoSms;


class ProviderController extends Controller
{
    public function dashboard(){
		return view('dashboard');
	}
	
	public function client(){
		$users = User::where('roll_id',3)->where('provider_id',Auth::user()->id)->orderBy('id','DESC')->get();
		return view('client.client')->with('users',$users);
	}
	
	
	public function clientDetail($id = null){
		
		$client = (object)array(
				'email'=>'','phone'=>'','name'=>'','dob'=>'','origin'=>'','gender'=>'','eyes'=>'','hair'=>'',
				'status'=>'','image'=>false
			);
		$form_action = 'provider/client-add';
		if($id){
			$client = User::where('user_id',$id)->first();
			$form_action = 'provider/client-add/'.$id;
		}
		return view('client.clientDetail')->with('client',$client)->with('form_action',$form_action);
	}
	
	
	public function clientAddPost(Request $request,$id = null){
		
			$validations = array(
                'phone' => 'required',
                'name' => 'required',
                'dob' => 'required',
                'origin' => 'required',
                'eyes' => 'required',
                'hair' => 'required',
                'status' => 'required',
            );
			if(!$id){
				// $validations['email'] = 'required|email|unique:users';
				$validator = Validator::make($request->all(),$validations);
				if($validator->fails())
				  {
				   return redirect('provider/client-add')->withErrors($validator)->withInput();
				  }
				
			}else{
				$validator = Validator::make($request->all(),$validations);
				if($validator->fails())
				  {
				   return redirect('provider/client-detail/'.$id)->withErrors($validator)->withInput();
				  }
			}
		if($id){
			$input = array(
						'phone'=>$request->phone,'name'=>$request->name,'dob'=>$request->dob,
						'origin'=>$request->origin,'gender'=>$request->gender,'eyes'=>$request->eyes,'hair'=>$request->hair,
						'status'=>$request->status
					);
			if ($request->hasFile('image')) {
				   $image = $request->file('image'); //get the file
				   $namefile = 	rand(1,999999) .time() . '.' . $image->getClientOriginalExtension();
				   $destinationPath = public_path('/assets/provider'); //public path folder dir
				   $image->move($destinationPath, $namefile);  //mve to destination you mentioned
				   $input['image'] = 'assets/provider/'.$namefile;
			}
			User::where('user_id',$id)->update($input);
			$message = 'Client update successfully';
		}else{
			$user_id_user_id = rand(111111,999999);
			$input = array(
						'phone'=>$request->phone,'name'=>$request->name,'dob'=>$request->dob,
						'origin'=>$request->origin,'gender'=>$request->gender,'eyes'=>$request->eyes,'hair'=>$request->hair,
						'status'=>$request->status,'user_id'=>$user_id_user_id,'roll_id'=>3,'provider_id'=>Auth::user()->id
					);
			if ($request->hasFile('image')) {
				   $image = $request->file('image'); //get the file
				   $namefile = 	rand(1,999999) .time() . '.' . $image->getClientOriginalExtension();
				   $destinationPath = public_path('/assets/provider'); //public path folder dir
				   $image->move($destinationPath, $namefile);  //mve to destination you mentioned
				   $input['image'] = 'assets/provider/'.$namefile;
			}
			try {
				if($request->send_sms){
					$account_sid = "ACdef2796627e6eec74dff940ed8cfef14";
					$auth_token = "c4d4a9a7757bfadbdb1e111a62c4e400";
					$twilio_number = "+1 323 370 0709";
					$message = "Please click on this link to add number. \n";
					$message .= "https://softelevation.com/camip/index.php?id={$user_id_user_id}";
					$client = new Client($account_sid, $auth_token);
					$client->messages->create($request->phone, [
							'from' => $twilio_number, 
							'body' => $message]);
				}
			}catch (Exception $e) {
			}
			echo '<pre>';
			// print_r($request->send_sms);
			print_r($input);
			die;
			User::insert($input);
			$message = 'Client add successfully';
		}
		return Redirect::to('/provider/client')->with('success_message',$message);
	}
	
	
	public function adminProfile(){
		$users = User::where('id',Auth::user()->id)->orderBy('id','DESC')->first();
		return view('providerProfile')->with('userAuth',$users);
	}
	
	public function adminProfilePost(Request $request){
		User::where('id',Auth::user()->id)->update(array('email'=>$request->email,'phone'=>$request->phone,'name'=>$request->name,'dob'=>$request->dob,'gender'=>$request->gender));
		return Redirect::to('/admin/profile')->with('success_message','Profile update successfully');
		
	}
}
