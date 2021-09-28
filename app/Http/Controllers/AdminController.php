<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Auth;
use Redirect;
use App\User;
use App\Category;
// use App\UserDetail;
// use Twilio\Rest\Client;
use Illuminate\Support\Facades\Hash;
Use Illuminate\Support\Facades\Validator;
use Mail;


class AdminController extends Controller
{
	use ResponseTrait;
	
    public function index(){
		
		$users = User::with(['user_detail'])->where('roll_id',1)->orderBy('id','DESC')->get();
		return view('provider.index')->with('users',$users);
	}
	
	
	public function dashboard(){
		$title = 'dashboard';
		return view('admin/dashboard')->with('title',$title);
	}
	
	public function addCategory(){
		$title = 'Add Category';
		return view('admin/category/add')->with('title',$title);
	}
	
	public function addCategoryPost(Request $request){
		
		try{
			$inputData = array('title'=>$request->title,'stock'=>$request->stock,'status'=>$request->status);
			Category::insert($inputData);
			$response['message'] = 'Category add successfully';
			$response['delayTime'] = 2000;
			$response['url'] = url('/admin/view-category');
			return response($this->getSuccessResponse($response));
			
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function CategoryDelete(Request $request){
		
		try{
			$inputData = $request->all();
			Category::where('id',$request->id)->delete();
			$response['message'] = 'Category delete successfully';
			$response['delayTime'] = 2000;
			$response['url'] = url('/admin/view-category');
			return response($this->getSuccessResponse($response));
			
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function viewCategory(){
		$category = Category::all();
		$title = 'View Category';
		return view('admin/category/view')->with('title',$title)->with('categories',$category);
	}
	
	
	public function provideradd($id = null){
		$pageData['title'] = 'Provider add';
		
		// die('wwwww');
		$client = (object)array(
				'email'=>'','phone'=>'','contact'=>'','name'=>'','dob'=>'','origin'=>'','gender'=>'','eyes'=>'','hair'=>'','address'=>'',
				'mailing_address'=>'','mailing_city'=>'','mailing_state'=>'','mailing_zip'=>'','shiping_address'=>'','shiping_city'=>'',
				'shiping_state'=>'','shiping_zip'=>'','card_rate'=>'','status'=>'','document'=>'','image'=>false
			);
		$pageData['form_action'] = 'admin/provider-add';
		if($id){
			$client = User::where('user_id',$id)->first();
			$userDetail = UserDetail::where('user_id',$id)->first();
			if($userDetail){
				$client->mailing_address = $userDetail->mailing_address;
				$client->mailing_city = $userDetail->mailing_city;
				$client->mailing_state = $userDetail->mailing_state;
				$client->mailing_zip = $userDetail->mailing_zip;
				$client->shiping_address = $userDetail->shiping_address;
				$client->shiping_city = $userDetail->shiping_city;
				$client->shiping_state = $userDetail->shiping_state;
				$client->shiping_zip = $userDetail->shiping_zip;
				$client->card_rate = $userDetail->card_rate;
			}else{
				$client->mailing_address = '';
				$client->mailing_city = '';
				$client->mailing_state = '';
				$client->mailing_zip = '';
				$client->shiping_address = '';
				$client->shiping_city = '';
				$client->shiping_state = '';
				$client->shiping_zip = '';
				$client->card_rate = '';
			}
		
			$pageData['form_action'] = 'admin/provider-add/'.$id;
		}
		return view('provider.provideradd')->with('client',$client)->with('pageData',$pageData);
	}
	
	public function provideraddPost(Request $request,$id = null){
		
		if($id){
			$input = array(
						'name'=>$request->name,'contact'=>$request->contact,'phone'=>$request->phone_no,'email'=>$request->email,'roll_id'=>1,
						'status'=>$request->status
					);
			User::where('user_id',$id)->update($input);
			$inputDteail = array(
							'mailing_address'=>$request->mailing_address,'mailing_city'=>$request->mailing_city,'mailing_state'=>$request->mailing_state,
							'mailing_zip'=>$request->mailing_zip,'shiping_address'=>$request->shiping_address,'shiping_city'=>$request->shiping_city,
							'shiping_state'=>$request->shiping_state,'shiping_zip'=>$request->shiping_zip,'card_rate'=>$request->card_rate
						);
			UserDetail::updateOrCreate(array('user_id'=>$id),$inputDteail);
			$message = 'Provider update successfully';
		}else{
			$validations = array(
                'name' => 'required',
                'contact' => 'required',
                'phone_no' => 'required',
                'email' => 'required|email|unique:users',
                'card_rate' => 'required',
                'mailing_address' => 'required',
                'mailing_city' => 'required',
                'mailing_state' => 'required',
                'mailing_zip' => 'required',
                'shiping_address' => 'required',
                'shiping_city' => 'required',
                'shiping_state' => 'required',
                'shiping_zip' => 'required',
            );
			$validator = Validator::make($request->all(),$validations);
			if($validator->fails())
			  {
			   return redirect('admin/provider-add')->withErrors($validator)->withInput();
			  }
			  
			$user_id = rand(111111,999999);
			$input = array(
						'name'=>$request->name,'contact'=>$request->contact,'phone'=>$request->phone_no,'email'=>$request->email,'roll_id'=>1,
						'user_id'=>$user_id,'status'=>$request->status,'password'=>Hash::make($user_id)
					);
			$inputDteail = array(
							'mailing_address'=>$request->mailing_address,'mailing_city'=>$request->mailing_city,'mailing_state'=>$request->mailing_state,
							'mailing_zip'=>$request->mailing_zip,'shiping_address'=>$request->shiping_address,'shiping_city'=>$request->shiping_city,
							'shiping_state'=>$request->shiping_state,'shiping_zip'=>$request->shiping_zip,'user_id'=>$user_id,'card_rate'=>$request->card_rate
						);
			$inputUser = User::insertGetId($input);
			UserDetail::insert($inputDteail);
			$email_s = $request->email;
			Mail::send('emails.contact', ['name' => $request->name, 'email' => $request->email, 'password' => $user_id], function ($message) use($email_s) {
				$message->from('uscisdev@gmail.com', 'USCIS');
				$message->to($email_s);
				$message->subject('Registration');
			});
			$message = 'Provider add successfully';
		}
		return Redirect::to('/admin/providers')->with('success_message',$message);
	}
	
	
	public function adminProfile(){
		$users = User::with(['user_detail'])->where('id',Auth::user()->id)->orderBy('id','DESC')->first();
		return view('adminProfile')->with('userAuth',$users);
	}

	
	
}
