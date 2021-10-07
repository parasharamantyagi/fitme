<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Model\UserFile;
use DB;
use App\Helpers\PlivoSms;

class FileController extends Controller
{
	use ResponseTrait;
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
		return response()->json(api_response(1,"User detail",array_remove_null($request->user()->toArray())));
    }
	
	
	public function userThouthand(Request $request)
    {
		$input = $request->user();
		try{
			$files = 'file';
			$user_file_s = UserFile::where('user_id',$input->id)->pluck('my_folder');
			$my_user_file_s = array_values(array_unique($user_file_s->toArray()));
			$result_data = array();
			foreach($my_user_file_s as $user_file_ss){
				if($user_file_ss){
					$result_data[] = array('user_thands/'.$user_file_ss.'/_withouthands001 2.txt','user_thands/'.$user_file_ss.'/_withouthands001 2.ply');
				}
			}
			// $user_file = array('user_thands/_withouthands001 2.txt','user_thands/_withouthands001 2.ply');
			$message = 'Thouthand file get successfully';
			return response()->json(api_response(1,$message,$result_data));
		}catch(\Exception $e){
            return response(api_response(0,$e->getMessage(),array()));
        }
    }
	
	
	public function userFileGet(Request $request)
    {
		$input = $request->user();
		try{
			$my_folder = $request->my_folder;
			$user_file = UserFile::where('user_id',$input->id)->where('type','file')->where('my_folder',$my_folder)->get();
			$message = 'File get successfully';
			return response()->json(api_response(1,$message,$user_file));
		}catch(\Exception $e){
            return response(api_response(0,$e->getMessage(),array()));
        }
    }
	
	public function userFolderGet(Request $request)
    {
		$input = $request->user();
		try{
			$files = 'file';
			$user_file = UserFile::where('user_id',$input->id)->where('type','file')->pluck('my_folder');
			$message = 'Folder get successfully';
			return response()->json(api_response(1,$message,array_values(array_unique($user_file->toArray()))));
		}catch(\Exception $e){
            return response(api_response(0,$e->getMessage(),array()));
        }
    }
	
	public function userImageFolderGet(Request $request)
    {
		$input = $request->user();
		try{
			$files = 'file';
			$user_file = UserFile::where('user_id',$input->id)->where('type','image')->pluck('my_folder');
			$message = 'Folder get successfully';
			return response()->json(api_response(1,$message,array_values(array_unique($user_file->toArray()))));
		}catch(\Exception $e){
            return response(api_response(0,$e->getMessage(),array()));
        }
    }
	
	public function userFilePost(Request $request){
		$input = $request->user();
		try{
			$input = array();
			$user = $request->user()->id;
			$input['user_id'] = $user;
			$my_folder_name = $request->folder_name.'_'.$user;
			$myFolderCheck = UserFile::where('user_id',$user)->where('my_folder',$my_folder_name)->first();
			$folder_name = 'user_image/'.$my_folder_name;
			if(!$myFolderCheck){
				mkdir($folder_name);
				mkdir("user_thands/".$my_folder_name);
				copy("user_thands/_withouthands001 2.ply","user_thands/".$my_folder_name."/_withouthands001 2.ply");
				copy("user_thands/_withouthands001 2.txt","user_thands/".$my_folder_name."/_withouthands001 2.txt");
			}
			// $input['file_name'] = $user;
			if(isset($request->my_file) && $request->my_file!=""){
				$image = $request->file('my_file');
				$fileName = $image->getClientOriginalName();
				$filePath = public_path($folder_name);
				$uploadStatus = $image->move($filePath,$fileName);
				$input['my_file'] = $folder_name.'/'.$fileName;
				$input['my_folder'] = $my_folder_name;
			}
			if($request->name){
				$input['name'] = $request->name;
			}
			$input['type'] = 'file';
			$input['created_at'] = Carbon::now();
			$input['updated_at'] = Carbon::now();
			$user_file = UserFile::insert($input);
			$message = 'File add successfully';
			return response()->json(api_response(1,$message,$input));
		}catch(\Exception $e){
            return response(api_response(0,$e->getMessage(),array()));
        }
	}
	
	public function userImageGet(Request $request)
    {
		$input = $request->user();
		try{
			$my_folder = $request->my_folder;
			$user_file = UserFile::where('user_id',$input->id)->where('type','image')->where('my_folder',$my_folder)->get();
			$message = 'Image get successfully';
			return response()->json(api_response(1,$message,$user_file));
		}catch(\Exception $e){
            return response(api_response(0,$e->getMessage(),array()));
        }
    }
	
	public function userImagePost(Request $request){
		$input = $request->user();
		try{
			$input = array();
			$user = $request->user()->id;
			$input['user_id'] = $user;
			$my_folder_name = $request->folder_name.'_'.$user;
			$myFolderCheck = UserFile::where('user_id',$user)->where('my_folder',$my_folder_name)->first();
			$folder_name = 'user_image/'.$my_folder_name;
			if(!$myFolderCheck){
				mkdir($folder_name);
				mkdir("user_thands/".$my_folder_name);
				copy("user_thands/_withouthands001 2.ply","user_thands/".$my_folder_name."/_withouthands001 2.ply");
				copy("user_thands/_withouthands001 2.txt","user_thands/".$my_folder_name."/_withouthands001 2.txt");
			}
			if(isset($request->my_file) && $request->my_file!=""){
				$image = $request->file('my_file');
				$fileName = $image->getClientOriginalName();
				$filePath = public_path($folder_name);
				$uploadStatus = $image->move($filePath,$fileName);
				$input['my_file'] = $folder_name.'/'.$fileName;
				$input['my_folder'] = $my_folder_name;
			}
			if($request->name){
				$input['name'] = $request->name;
			}
			$input['type'] = 'image';
			$input['created_at'] = Carbon::now();
			$input['updated_at'] = Carbon::now();
			$user_file = UserFile::insert($input);
			$message = 'Image add successfully';
			return response()->json(api_response(1,$message,$input));
		}catch(\Exception $e){
            return response(api_response(0,$e->getMessage(),array()));
        }
	}

	
	// public function profileUpdate(Request $request)
	// {
		// try{
			// $user = $request->user();
			// $input = $request->all();
			// if(isset($request->image) && $request->image!=""){
				// $image = $request->file('image');
				// $fileName = time().$image->getClientOriginalName();
				// $filePath = public_path('user_image');
				// $uploadStatus = $image->move($filePath,$fileName);
				// $input['image'] = '/user_image/'.$fileName;
			// }
			// User::find($user->id)->update(array_filter($input));
			// $user = User::find($user->id);
			// return response()->json(api_response(1,"User profile update successfully",$user));
		// }catch(\Exception $e){
            // return response(api_response(0,$e->getMessage(),array()));
        // }
	// }
	
	
}