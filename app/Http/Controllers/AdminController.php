<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Validators\ProductValidator;
use Auth;
use Redirect;
use App\User;
use App\Model\Category;
use App\Model\Product;
use App\Model\ProductImage;
// use App\UserDetail;
// use Twilio\Rest\Client;
use Illuminate\Support\Facades\Hash;
Use Illuminate\Support\Facades\Validator;
use Mail;
use DB;


class AdminController extends Controller
{
	use ProductValidator, ResponseTrait;
	
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
	
	public function deleteData(Request $request){
		try{
			$inputData = $request->all();
			if($request->action == 'category'){
				Category::where('id',$request->id)->delete();
				$response['message'] = 'Category delete successfully';
				$response['url'] = url('/admin/view-category');
			}else if($request->action == 'product'){
				Product::where('id',$request->id)->delete();
				$response['message'] = 'Product delete successfully';
				$response['url'] = url('/admin/view-product');
			}else if($request->action == 'user_by_id'){
				User::where('id',$request->id)->delete();
				$response['message'] = 'User delete successfully';
				$response['url'] = url('/admin/view-user');
			}
			$response['delayTime'] = 2000;
			return response($this->getSuccessResponse($response));
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function changeStatus(Request $request){
		try{
			$inputData = $request->all();
			Category::where('id',$request->cat_id)->update(array('status'=>$request->is_check));
			$response['message'] = 'Status change successfully';
			return response($this->getSuccessResponse($response));
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function viewCategory(){
		try{
			$category = Category::orderBy('id','desc')->get();
			$title = 'View Category';
			return view('admin/category/view')->with('title',$title)->with('categories',$category);
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function addProduct(Request $request){
		$title = 'Add Product';
		if($request->session()->has('product_file')){
			$request->session()->forget('product_file');
		}		
		$category = Category::where('status',1)->orderBy('id','desc')->get();
		$product_fields = array();
		$cat_id = '';
		if($request->cat_id){
			$cat_id = decryptId($request->cat_id);
			$product_fields = Category::where('id',$cat_id)->first()->field;
			if($product_fields){
				$product_fields = json_decode($product_fields->filed);
			}
		}
		$urlform = 'admin/add-product';
		return view('admin/product/add')->with('title',$title)->with('product_fields',$product_fields)->with('cat_id',$cat_id)->with('categories',$category)->with('urlform',$urlform);
	}
	
	public function addProductPost(Request $request){
		try{
			$cat_id = decryptId($request->cat_id);
			$product_fields = Category::where('id',$cat_id)->first()->field;
			$validation = $this->agentNewFeatureValidations($request,validation_name_of_filed($product_fields->filed));
			if($validation['status']==false){
				return response($this->getValidationsErrors($validation));
			}
			$input = $request->all();
			$input['cat_id'] = $cat_id;
			unset($input['_token']);
			$my_product = Product::insertGetId($input);
			if($request->session()->has('product_file')){
				ProductImage::where('image_id',$request->session()->get('product_file'))->update(array('product_id'=>$my_product));
			}
			// DB::table($product_fields->table_name)->insert($input);
			// if ($request->hasFile('image')) {
				   // $image = $request->file('image'); //get the file
				   // $namefile = 	rand(1,999999) .time() . '.' . $image->getClientOriginalExtension();
				   // $destinationPath = public_path('/products'); //public path folder dir
				   // $image->move($destinationPath, $namefile);  //mve to destination you mentioned
				   // $input['image'] = 'products/'.$namefile;
			// }
			// unset($input['_token']);
			// $input['cat_id'] = decryptId($request->cat_id);
			// Product::insert($input);
			$response['message'] = 'Product add successfully';
			$response['delayTime'] = 2000;
			$response['url'] = url('/admin/view-product');
			return response($this->getSuccessResponse($response));
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function updateProductId(Request $request,$id){
		try{
			$input = $request->all();
			if ($request->hasFile('image')) {
				   $image = $request->file('image'); //get the file
				   $namefile = 	rand(1,999999) .time() . '.' . $image->getClientOriginalExtension();
				   $destinationPath = public_path('/products'); //public path folder dir
				   $image->move($destinationPath, $namefile);  //mve to destination you mentioned
				   $input['image'] = 'products/'.$namefile;
			}
			unset($input['_token']);
			$input['cat_id'] = decryptId($request->cat_id);
			Product::where('id',$id)->update($input);
			$response['message'] = 'Product update successfully';
			$response['delayTime'] = 2000;
			$response['url'] = url('/admin/view-product');
			return response($this->getSuccessResponse($response));
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	
	public function uploadImage(Request $request){
		
		$input = array();
		$productFile = rand(11111111,99999999);
		// $input['image_id'] = 4444;
		if ($request->hasFile('file')) {
				   $image = $request->file('file'); //get the file
				   $namefile = 	rand(1,999999) .time() . '.' . $image->getClientOriginalExtension();
				   $destinationPath = public_path('/products'); //public path folder dir
				   $image->move($destinationPath, $namefile);  //mve to destination you mentioned
				   $input['file_path'] = 'products/'.$namefile;
			}
		if($request->session()->has('product_file')){
			 $productFile = $request->session()->get('product_file');
		}else{
			$request->session()->put('product_file',$productFile);
		}
		$input['image_id'] = $productFile;
		ProductImage::insert($input);
		return true;
	}
	
	public function viewProduct(Request $request){
		try{
			$cat_id = 0;
			$product = array();
			$category = Category::where('status',1)->orderBy('id','desc')->get();
			$name_of_fileds = array();
			$label_of_fileds = array();
			if($request->cat_id){
				$cat_id = decryptId($request->cat_id);
				$product_fields = Category::where('id',$cat_id)->first()->field;
				if($product_fields){
					$name_of_fileds = name_of_filed($product_fields->filed,'name');
					$label_of_fileds = name_of_filed($product_fields->filed,'label');
					$product = Product::where('cat_id',$cat_id)->get()->toArray();
				}
			}
			$title = 'View Product';
			return view('admin/product/view')->with('title',$title)->with('name_of_fileds',$name_of_fileds)->with('label_of_fileds',$label_of_fileds)->with('cat_id',$cat_id)->with('categories',$category)->with('products',$product);
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function addProductId($id){
		$title = 'Update Product';
		$category = Category::orderBy('id','desc')->get();
		$product = Product::find($id);
		$urlform = 'admin/add-product/'.$id;
		return view('admin/product/add')->with('title',$title)->with('categories',$category)->with('product',$product)->with('urlform',$urlform);
	}
	
	
	
	public function viewUser(){
		try{
			$all_user = User::where('roll_id',1)->get();
			$title = 'View User';
			return view('admin/user/view')->with('title',$title)->with('all_users',$all_user);
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	
	public function adminProfile(){
		$users = User::with(['user_detail'])->where('id',Auth::user()->id)->orderBy('id','DESC')->first();
		return view('adminProfile')->with('userAuth',$users);
	}

	
	
}
