<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request,  Closure $next)
    {
        $url = url()->full();
        $ar_url = explode('/', $url);

        $role_name = '';

        if(Auth::check()){
            $current_time = Carbon::now();
            $time = $current_time->toDateTimeString();
            $user = User::find(Auth::user()->id);
            $user->check_status = $time;
            $user->save();
        }

        if(Auth::user()->role == 1){
            $role_name = 'rats-5768';
        }elseif(Auth::user()->role == 2){
            $role_name = 'client';
        }elseif(Auth::user()->role == 3){
            $role_name = 'staff';
        }elseif(Auth::user()->role == 4){
            $role_name = 'recruiter';
        }elseif(Auth::user()->role == 5){
            $role_name = 'candidate';
        }

        if(isset($role_name) && !empty($role_name)){
            $route_name = $role_name.'.dashboard';
            if(!in_array($role_name, $ar_url)) {
                return redirect()->route($route_name);
            }
        }else{
            return redirect()->route('home.index');
        }
        
        return $next($request);
    }
}
