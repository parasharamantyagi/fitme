<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Api\AuthController@login');
    Route::post('signup', 'Api\AuthController@signup');
    Route::post('verify-otp', 'Api\AuthController@verifyOtp');
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('user', 'Api\AuthController@user');
        Route::get('categories', 'Api\AuthController@getCategories');
		
        Route::post('products', 'Api\AuthController@getProducts');
        Route::post('product-detail', 'Api\AuthController@getProductDetail');
		
		Route::get('get-cart', 'Api\AuthController@getCart');
		Route::post('add-cart', 'Api\AuthController@addCart');
		Route::post('update-cart', 'Api\AuthController@updateCart');
		Route::post('remove-cart', 'Api\AuthController@removeCart');
		
		
		// garud file upload
		Route::get('file/user-thouthand', 'Api\FileController@userThouthand');
		Route::get('file/user-folder', 'Api\FileController@userFolderGet');
		Route::get('file/user-image-folder', 'Api\FileController@userImageFolderGet');
		
		Route::post('user', 'Api\AuthController@userProfileUpdate');
		Route::post('file/user-file-get', 'Api\FileController@userFileGet');
		Route::post('file/user-file', 'Api\FileController@userFilePost');
		Route::post('file/user-image-get', 'Api\FileController@userImageGet');
		Route::post('file/user-image', 'Api\FileController@userImagePost');
		
		
		

    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
