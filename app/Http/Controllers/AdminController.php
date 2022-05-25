<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Validators\ProductValidator;
use Carbon\Carbon;
use Auth;
use Redirect;
use App\User;
use App\Model\Category;
use App\Model\Product;
use App\Model\ProductField;
use App\Model\ProductImage;
use App\Model\UserProduct;
use App\Model\Order;
use App\Model\Token;
use App\Model\Video;

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
		$count_data['order_count'] = Order::count();
		$count_data['user_count'] = User::count();
		$count_data['category_count'] = Category::count();
		$count_data['product_count'] = Product::count();
		$title = 'dashboard';
		return view('admin/dashboard')->with('title',$title)->with('count_data',$count_data);
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
				$product = Product::find($request->id);
				$product->delete();
				$response['message'] = 'Product delete successfully';
				$response['url'] = url('/admin/view-product?cat_id='.encryptID($product->cat_id));
			}else if($request->action == 'user_by_id'){
				User::where('id',$request->id)->delete();
				$response['message'] = 'User delete successfully';
				$response['url'] = url('/admin/view-user');
			}else if($request->action == 'token'){
				Token::where('id',$request->id)->delete();
				$response['message'] = 'Token delete successfully';
				$response['url'] = url('/admin/view-token');
			}else if($request->action == 'video'){
				Video::where('id',$request->id)->delete();
				$response['message'] = 'Configuration delete successfully';
				$response['url'] = url('/admin/view-configuration');
			}else if($request->action == 'product_image'){
				$productImage = ProductImage::find($request->id);
				$product_id = $productImage->product->id;
				$productImage->delete();
				$response['message'] = 'Product image delete successfully';
				$response['url'] = url('/admin/product-detail/'.encryptID($product_id));
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
			if($request->type == "category"){
				Category::where('id',$request->id)->update(array('status'=>$request->is_check));
			}else if($request->type == "product"){
				Product::where('id',$request->id)->update(array('status'=>$request->is_check));
			}else if($request->type == "product_images"){
				ProductImage::where('id',$request->id)->update(array('status'=>$request->is_check));
			}else if($request->type == "product_field_image"){
				ProductField::where('id',$request->id)->update(array('status'=>$request->is_check));
			}else if($request->type == "token"){
				Token::where('id',$request->id)->update(array('status'=>$request->is_check));
			}else if($request->type == "video"){
				Video::where('id',$request->id)->update(array('status'=>$request->is_check));
			}
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
	
	public function productEdit(Request $request,$id){
		try{
			$title = 'Update Product';
			if($request->session()->has('product_file')){
					$request->session()->forget('product_file');
				}
			$category = Category::where('status',1)->orderBy('id','desc')->get();
			$product_fields = array();
			$product_id = decryptId($id);
			$product = Product::find($product_id);
			$cat_id = $product->cat_id;
			$product_fields = Category::where('id',$cat_id)->first()->field;
			if($product_fields){
				$product_fields = json_decode($product_fields->filed);
			}
			// pr($product_fields);
			$urlform = 'admin/product-update/'.encryptID($product_id);
			return view('admin/product/edit')->with('title',$title)->with('my_product',$product)->with('product',$product->toArray())->with('product_fields',$product_fields)->with('cat_id',$cat_id)->with('categories',$category)->with('urlform',$urlform);
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function productUpdate(Request $request,$id){
		try{
			$id = decryptId($id);
			$product = Product::find($id);
			$cat_id = $product->cat_id;
			$product_fields = Category::where('id',$cat_id)->first()->field;
			$validation = $this->agentNewFeatureValidations($request,validation_name_of_filed($product_fields->filed));
			if($validation['status']==false){
				return response($this->getValidationsErrors($validation));
			}
			$input = $request->all();
			$input['product_image'] = array();
			$files = $request->file('image');
			if($files){
				foreach ($files as $image_key => $file) {
					$namefile = 	rand(1,999999) .time() . '.' . $file->getClientOriginalExtension();
					$destinationPath = public_path('/products'); //public path folder dir
					$file->move($destinationPath, $namefile);  //mve to destination you mentioned
					$input['product_image'][$image_key] = 'products/'.$namefile;
				}
			}
			$product_fields = array('product_field_id'=>$input['product_field_id'],'Band_size_ID'=>$input['Band_size_ID'],'Cup_size_ID'=>$input['Cup_size_ID'],
									'color'=>$input['color'],'quantity'=>$input['quantity']);
			if($input['product_image']){
				$product_fields['image'] = $input['product_image'];
			}
			$input['cat_id'] = $cat_id;
			unset($input['_token']);
			unset($input['Band_size_ID']);
			unset($input['Cup_size_ID']);
			unset($input['color']);
			unset($input['quantity']);
			unset($input['product_field_id']);
			unset($input['image']);
			unset($input['product_image']);
			Product::where('id',$id)->update($input);
			ProductField::where('product_id',$id)->whereNotIn('id',$product_fields['product_field_id'])->delete();
			if(array_key_exists('image',$product_fields)){
				for ($x = 0; $x < count($product_fields['product_field_id']); $x++) {
					if($product_fields['product_field_id'][$x]){
						ProductField::where('id',$product_fields['product_field_id'][$x])->update(array(
								'Band_size_ID'=>$product_fields['Band_size_ID'][$x],
								'Cup_size_ID'=>$product_fields['Cup_size_ID'][$x],'color'=>$product_fields['color'][$x],
								'quantity'=>$product_fields['quantity'][$x],'image'=>$product_fields['image'][$x]
								));
					}else{
						ProductField::insert(
								array(
								'product_id'=>$id,'Band_size_ID'=>$product_fields['Band_size_ID'][$x],
								'Cup_size_ID'=>$product_fields['Cup_size_ID'][$x],'color'=>$product_fields['color'][$x],
								'quantity'=>$product_fields['quantity'][$x],'image'=>$product_fields['image'][$x]
								)
						);
					}
				}
			}
			
			if($request->session()->has('product_file')){
				ProductImage::where('image_id',$request->session()->get('product_file'))->update(array('product_id'=>$id));
			}
			$response['message'] = 'Product update successfully';
			$response['delayTime'] = 2000;
			$response['url'] = url('/admin/view-product?cat_id='.encryptID($cat_id));
			return response($this->getSuccessResponse($response));
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function productMultiImages(Request $request){
		try{
			$input = $request->all();
			$files = $request->file('images');
			if($request->hasFile('images'))
			{
				$index = 0;
				foreach($_FILES['images']['tmp_name'] as $key => $error){
					if($_FILES['images']['tmp_name'][$index]){
					   $filename = file_get_contents($_FILES['images']['tmp_name'][$key]);
					   $pack_filename = preg_replace("/[^a-z0-9\.]/", "_", strtolower($_FILES['images']['name'][$key]));
					   $pack_filename = strtotime("now")."_".$pack_filename;
					   $file_name = $_FILES['images']['name'][$key];
					   move_uploaded_file($_FILES['images']['tmp_name'][$key],'products/'.$pack_filename);
					   $input['product_image'][$index] = 'products/'.$pack_filename;
					// if(!empty($files[$index]->hasFile('images'))){
						// $namefile = 	rand(1,999999) .time() . '.' . $file->getClientOriginalExtension();
						// $destinationPath = public_path('/products'); //public path folder dir
						// $file->move($destinationPath, $namefile);  //mve to destination you mentioned
						// $input['product_image'][$index] = 'products/'.$namefile;
					}else{
						$input['product_image'][$index] = '';
					}
					$index++;
				}
			}
			$insert_data = array();
			for ($x = 0; $x < count($input['productField_id']); $x++) {
				if($input['productField_id'][$x] && $input['product_image'][$x]){
					$insert_data[] = array(
								'file_path'=>$input['product_image'][$x],'product_id'=>$request->product_id,
								'product_field_id'=>$input['productField_id'][$x],'status'=>1,
								'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()
						);
				}
			}
			ProductImage::insert($insert_data);
			$response['message'] = 'Images update successfully';
			$response['delayTime'] = 2000;
			$response['url'] = url('/admin/product-detail/'.encryptID($request->product_id));
			return response($this->getSuccessResponse($response));
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
		
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
			$input['product_image'] = array();
			$files = $request->file('image');
			foreach ($files as $image_key => $file) {
				$namefile = 	rand(1,999999) .time() . '.' . $file->getClientOriginalExtension();
				$destinationPath = public_path('/products'); //public path folder dir
				$file->move($destinationPath, $namefile);  //mve to destination you mentioned
				$input['product_image'][$image_key] = 'products/'.$namefile;
			}
			$product_fields = array('Band_size_ID'=>$input['Band_size_ID'],'Cup_size_ID'=>$input['Cup_size_ID'],
									'color'=>$input['color'],'quantity'=>$input['quantity'],'image'=>$input['product_image']);
			$input['cat_id'] = $cat_id;
			unset($input['_token']);
			unset($input['Band_size_ID']);
			unset($input['Cup_size_ID']);
			unset($input['color']);
			unset($input['quantity']);
			unset($input['image']);
			unset($input['product_image']);
			unset($input['product_field_id']);
			// pr($input);
			$my_product = Product::insertGetId($input);
			for ($x = 0; $x < count($product_fields['Band_size_ID']); $x++) {
				ProductField::insert(
						array(
						'product_id'=>$my_product,'Band_size_ID'=>$product_fields['Band_size_ID'][$x],
						'Cup_size_ID'=>$product_fields['Cup_size_ID'][$x],'color'=>$product_fields['color'][$x],
						'quantity'=>$product_fields['quantity'][$x],'image'=>$product_fields['image'][$x]
						)
				);
			}
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
			$response['url'] = url('/admin/view-product?cat_id='.$request->cat_id);
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
	
	public function productDetail($id){
		try{
			$product_id = decryptId($id);
			$product = Product::with(['product_images','admin_product_field.product_field_images'])->find($product_id);
			// pr($product->toArray());
			$product_fields = Category::where('id',$product->cat_id)->first()->field;
			$p_filed = name_of_filed($product_fields->filed,'label');
			return view('admin/product/detail')->with('title','Product detail')->with('product',$product)->with('p_filed',$p_filed);
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
	
	public function viewOrder(){
		try{
			$allOrder = Order::select('orders.id','user_id','amount','orders.created_at','name','email','address','phone')->join('users','users.id','orders.user_id')->orderBy('id', 'DESC')->get();
			$title = 'View Order';
			return view('admin/order/view')->with('title',$title)->with('all_Orders',$allOrder);
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}
	
	public function orderDetail($id){
		try{
			$order = Order::find($id);
			$user_address = User::find($order->user_id);
			$user_products = UserProduct::with('product')->where('order_id',$id)->get();
			$title = 'Order detail';
			return view('admin/order/detail')->with('title',$title)->with('order',$order)->with('user_products',$user_products)->with('user_address',$user_address);
		}catch(\Exception $e){
            return response($this->getErrorResponse($e->getMessage()));
        }
	}

	
	
}
