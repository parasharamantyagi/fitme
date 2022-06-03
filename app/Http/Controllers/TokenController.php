<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
// use App\Validators\ProductValidator;
use Auth;
use Redirect;
use App\User;
use App\Model\Token;
use App\Model\UserVoucher;
use Illuminate\Support\Facades\Hash;
Use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Mail;
use DB;


class TokenController extends Controller
{
	use ResponseTrait;
	
    public function addToken(){
		try{
			$title = 'Add Token';
			return view('admin/token/add')->with('title',$title)->with('current_date',Carbon::now()->format('Y-m-d'));
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	
	public function viewToken(){
		try{
			$tokens = Token::whereIn('category',['fixed','referral'])->orderBy('id','desc')->get();
			$title = 'View Token';
			return view('admin/token/view')->with('title',$title)->with('tokens',$tokens);
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function addTokenPost(Request $request){
		try{
			$inputData = $request->all();
			$token_check = Token::where('token_name',$inputData['token_name'])->first();
			if(!$token_check){
				$inputData['category'] = 'fixed';
				$inputData['created_at'] = Carbon::now();
				$inputData['updated_at'] = Carbon::now();
				unset($inputData['_token']);
				Token::insert($inputData);
				$response['delayTime'] = 2000;
				$response['message'] = 'Token add successfully';
				$response['url'] = url('/admin/view-token');
				return response($this->getSuccessResponse($response));
			}else{
				return response($this->getErrorResponse('Token is already exists'));
			}
			
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	
	public function addMembershipVoucher(){
		try{
			$title = 'Add Voucher';
			$form_url = 'admin/add-membership-voucher';
			$token = array('token_name'=>'','amount'=>'','type'=>'','valid_to'=>'','misapplying_message'=>'','applying_message'=>'');
			return view('admin/membership-voucher/add')->with('title',$title)->with('form_url',$form_url)->with('token',$token)->with('current_date',Carbon::now()->format('Y-m-d'));
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function editMembershipVoucher($id){
		try{
			$token_id = Crypt::decrypt($id);
			$form_url = 'admin/add-membership-voucher/'.$id;
			$token = Token::find($token_id)->toArray();
			$title = 'Edit Voucher';
			return view('admin/membership-voucher/add')->with('title',$title)->with('form_url',$form_url)->with('token',$token)->with('current_date',Carbon::now()->format('Y-m-d'));
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function membershipVoucherDetail($id){
		try{
			$token_id = Crypt::decrypt($id);
			$userVoucher = UserVoucher::find($token_id);
			$title = 'Voucher detail';
			return view('admin/membership-voucher/verify-voucher-detail')->with('title',$title)->with('user_voucher',$userVoucher);
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	public function membershipVoucherVerify(Request $request, $id){
		try{
			$inputData = $request->all();
			$user_voucher_id = Crypt::decrypt($id);
			if($request->submit === 'Verify'){
				UserVoucher::find($user_voucher_id)->update(array('status'=>1));
			}else{
				UserVoucher::find($user_voucher_id)->delete();
			}
			$response['delayTime'] = 2000;
			$response['message'] = 'User voucher verified successfully';
			$response['url'] = url('/admin/verify-membership-voucher');
			return response($this->getSuccessResponse($response));
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function viewMembershipVoucher(){
		try{
			$tokens = Token::where('category','membership_voucher')->orderBy('id','desc')->get();
			$title = 'View Membership Voucher';
			return view('admin/membership-voucher/view')->with('title',$title)->with('tokens',$tokens);
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function verifyMembershipVoucher(Request $request){
		try{
			$tokens = UserVoucher::select('user_vouchers.*','tokens.token_name','tokens.amount','type','valid_to','misapplying_message','applying_message','users.name','users.email','users.phone','users.address')
					 ->join('users', 'users.id', 'user_vouchers.user_id')
					 ->join('tokens', 'tokens.id', 'user_vouchers.token_id');
			if($request->action){
				$form_array = array('url'=>'admin/verify-membership-voucher','link_name'=>'Membership voucher request');
				$tokens = $tokens->where('user_vouchers.status',1);
			}else{
				$form_array = array('url'=>'admin/verify-membership-voucher?action=active-voucher','link_name'=>'Verify Member');
				$tokens = $tokens->where('user_vouchers.status',0);
			}
			$tokens = $tokens->orderBy('id','desc')->get();
			$title = 'Verify Membership Voucher';
			return view('admin/membership-voucher/verify-voucher')->with('title',$title)->with('tokens',$tokens)->with('form_array',$form_array);
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function updateMembershipVoucherPost(Request $request,$id){
		try{
			$token_id = Crypt::decrypt($id);
			$inputData = $request->all();
			if ($request->hasFile('image')) {
				$image = $request->file('image'); //get the file
				$namefile = rand(1,999999) .time() . '.' . $image->getClientOriginalExtension();
				$destinationPath = public_path('/membership-voucher'); //public path folder dir
			    $image->move($destinationPath, $namefile);  //mve to destination you mentioned
			    $inputData['image'] = 'membership-voucher/'.$namefile;
			}
			$token_check = Token::where('id','!=',$token_id)->where('token_name',$inputData['token_name'])->first();
			if(!$token_check){
				unset($inputData['_token']);
				Token::where('id',$token_id)->update($inputData);
				$response['delayTime'] = 2000;
				$response['message'] = 'Token update successfully';
				$response['url'] = url('/admin/view-membership-voucher');
				return response($this->getSuccessResponse($response));
			}else{
				return response($this->getErrorResponse('Token is already exists'));
			}
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function addMembershipVoucherPost(Request $request){
		try{
			$inputData = $request->all();
			if ($request->hasFile('image')) {
				$image = $request->file('image'); //get the file
				$namefile = rand(1,999999) .time() . '.' . $image->getClientOriginalExtension();
				$destinationPath = public_path('/membership-voucher'); //public path folder dir
			    $image->move($destinationPath, $namefile);  //mve to destination you mentioned
			    $inputData['image'] = 'membership-voucher/'.$namefile;
			}
			$token_check = Token::where('token_name',$inputData['token_name'])->first();
			if(!$token_check){
				$inputData['category'] = 'membership_voucher';
				$inputData['created_at'] = Carbon::now();
				$inputData['updated_at'] = Carbon::now();
				unset($inputData['_token']);
				Token::insert($inputData);
				$response['delayTime'] = 2000;
				$response['message'] = 'Token add successfully';
				$response['url'] = url('/admin/view-membership-voucher');
				return response($this->getSuccessResponse($response));
			}else{
				return response($this->getErrorResponse('Token is already exists'));
			}
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}

	
	
}
