<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeController@index');
Route::post('/login','HomeController@loginPost');
Route::post('/admin-login','HomeController@adminLoginPost');
Route::post('/forget-password','HomeController@forgetPassword');
Route::get('/log-out','HomeController@loginOut');

Route::get('/my-admin','HomeController@adminIndex');
Route::get('/version','HomeController@phpInfoVersion');

Route::group(['prefix'=>'admin'], function () {
	Route::group(['middleware'=>['auth','roles']], function () {
		Route::get('/dashboard','AdminController@dashboard');
		
		Route::get('/add-category','AdminController@addCategory');
		Route::get('/view-category','AdminController@viewCategory');
		
		Route::get('/add-product','AdminController@addProduct');
		Route::get('/view-product','AdminController@viewProduct');
		Route::get('/product-detail/{id}','AdminController@productDetail');
		Route::get('/product-edit/{id}','AdminController@productEdit');
		Route::get('/add-product/{id}','AdminController@addProductId');
		
		Route::get('/view-user','AdminController@viewUser');
		
		
		Route::get('/view-order','AdminController@viewOrder');
		Route::get('/order-detail/{id}','AdminController@orderDetail');
		
		Route::post('/add-category','AdminController@addCategoryPost');
		Route::post('/add-product','AdminController@addProductPost');
		Route::post('/add-product/{id}','AdminController@updateProductId');
		Route::post('/product-update/{id}','AdminController@productUpdate');
		
		Route::post('/delete-data','AdminController@deleteData');
		
		Route::get('/add-token','TokenController@addToken');
		Route::get('/view-token','TokenController@viewToken');
		Route::post('/add-token','TokenController@addTokenPost');
		
		
		
		Route::post('/change-status','AdminController@changeStatus');
		Route::post('/upload','AdminController@uploadImage');
		
	});
});

// Route::group(['prefix'=>'provider'], function () {
	// Route::group(['middleware'=>['auth','roles']], function () {
		// Route::get('/','ProviderController@dashboard');
		// Route::get('/dashboard','ProviderController@dashboard');
		// Route::get('/client','ProviderController@client');
		// Route::get('/client-add','ProviderController@clientDetail');
		// Route::post('/client-add/{id}','ProviderController@clientAddPost');
		// Route::post('/client-add','ProviderController@clientAddPost');
		// Route::get('/client-detail/{id}','ProviderController@clientDetail');
		// Route::get('/profile','ProviderController@adminProfile');
		// Route::post('/admin-profile','ProviderController@adminProfilePost');
	// });
// });


Route::get('/updateimage','HomeController@updateimage');
Route::post('/updateimage','HomeController@updateimagePost');


Route::get('/web-open','HomeController@webOpen');
