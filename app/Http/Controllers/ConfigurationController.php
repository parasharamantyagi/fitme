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
use App\Model\Video;
use Illuminate\Support\Facades\Hash;
Use Illuminate\Support\Facades\Validator;
use Mail;
use DB;


class ConfigurationController extends Controller
{
	use ResponseTrait;
	
    public function addConfiguration(){
		try{
			$category = Token::orderBy('id','desc')->get();
			$title = 'Add Configuration';
			return view('admin/configuration/add')->with('title',$title)->with('categories',$category);
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	
	public function viewConfiguration(){
		try{
			$videos = Video::orderBy('id','desc')->get();
			$title = 'View Configuration';
			return view('admin/configuration/view')->with('title',$title)->with('videos',$videos);
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function addConfigurationPost(Request $request){
		try{
			$inputData = array();
			if ($request->hasFile('video_name')) {
				   $image = $request->file('video_name'); //get the file
				   $namefile = 	rand(1,999999) .time() . '.' . $image->getClientOriginalExtension();
				   $destinationPath = public_path('/videos'); //public path folder dir
				   $image->move($destinationPath, $namefile);  //mve to destination you mentioned
				   $inputData['name'] = 'videos/'.$namefile;
				   $inputData['created_at'] = Carbon::now();
				   $inputData['updated_at'] = Carbon::now();
				   Video::insert($inputData);
				   $response['delayTime'] = 2000;
					$response['message'] = 'Configuration add successfully';
					$response['url'] = url('/admin/view-token');
					return response($this->getSuccessResponse($response));
			}else{
				return response($this->getErrorResponse('File not found'));
			}
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	

	
	
}