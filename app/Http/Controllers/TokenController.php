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
use Illuminate\Support\Facades\Hash;
Use Illuminate\Support\Facades\Validator;
use Mail;
use DB;


class TokenController extends Controller
{
	use ResponseTrait;
	
    public function addToken(){
		try{
			$category = Token::orderBy('id','desc')->get();
			$title = 'Add Token';
			return view('admin/token/add')->with('title',$title)->with('categories',$category)->with('current_date',Carbon::now()->format('Y-m-d'));
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	
	public function viewToken(){
		try{
			$tokens = Token::orderBy('id','desc')->get();
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
	

	
	
}
