<?php

namespace App\Http\Middleware;

use App\CustomClass\UserLoginInfo;
use Closure;
use Illuminate\Http\Request;

class IsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $userData = UserLoginInfo::get();

//        dd($userData);
        if(!$userData){
            return redirect('/');
        }

        return $next($request);
    }
}
