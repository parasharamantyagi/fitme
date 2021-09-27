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
// Route::get('/check-version','HomeController@checkVersion');

// Route::get('/search-result','HomeController@searchResult');
// Route::get('/change-password','HomeController@changePassword');
// Route::post('/change-password','HomeController@changePasswordPost');
// Route::get('/reset-password/{id}','HomeController@resetPasswordPost');
// Route::post('/reset-password/{id}','HomeController@resetPasswordPost');
Route::get('/my-admin','HomeController@adminIndex');
// Route::get('/twilio-sand','HomeController@twilioSand');

Route::group(['prefix'=>'admin'], function () {
	Route::group(['middleware'=>['auth','roles']], function () {
		// Route::get('/profile','AdminController@adminProfile');
		Route::get('/dashboard','AdminController@dashboard');
		// Route::get('/providers','AdminController@index');
		// Route::get('/provider-add','AdminController@provideradd');
		// Route::get('/provider-add/{id}','AdminController@provideradd');
		// Route::post('/provider-add','AdminController@provideraddPost');
		// Route::post('/provider-add/{id}','AdminController@provideraddPost');
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
