<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use DB;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','email_verified_at', 'password', 'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	public function user_detail(){
    	return $this->hasOne('App\UserDetail', 'user_id', 'user_id');
    }
	
	public function user_otp($input){
		$checkOtp = DB::table('otps')->where('user_id',$input['user_id'])->first();
		if($checkOtp){
			DB::table('otps')->where('user_id',$input['user_id'])->update(array('otp'=>$input['otp']));
		}else{
			DB::table('otps')->insert($input);
		}
    	return true;
    }
	
	
	
	protected $validations = [
    'email' => 'sometimes|required|email|unique:users'
	];
	
}
