<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Permission;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check() && Auth::user()->status == 1) {
             $per = Permission::find(Auth::user()->status);
            $av_per = explode("," , $per->departments);
            $class_name = explode("\\" , get_class($this));

            if (in_array($class_name[3] , $av_per)){
                return $next($request);
            } else {
                return "Error , Your Permission is not allow to you be here";
            }
        } else {
            return redirect("login");
        }

        
    }
}
