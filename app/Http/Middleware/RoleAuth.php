<?php

namespace App\Http\Middleware;

use Closure;

class RoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $prefix = $request->route()->getPrefix();
        $currentRoleID = \Auth::user()->roll_id;
        switch($currentRoleID){
            case 1:
                if(!($prefix=='/provider' && $currentRoleID==1)){
                    return redirect('/');
                }
            break;
            case 2:
                if(!($prefix=='/admin' && $currentRoleID==2)){
                    return redirect('admin/dashboard');        
                }
            break;
            case 3:
                if(!($prefix=='/admin' && $currentRoleID==3)){
                    return redirect('/');        
                }
			break;
			case 4:
                if(!($prefix=='/admin' && $currentRoleID==4)){
                    return redirect('/');        
                }
        }
        return $next($request);
    }
}
