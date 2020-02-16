<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
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
        Log::channel('slack')->info('Something happened!');
        Log::info('User failed to login.', ['id' => Auth::check()]);
        if($guard == "web" && Auth::guard($guard)->check()) {
            return redirect('/');
        }else if($guard == "agents" && Auth::guard($guard)->check()){
            return redirect('/');
        }else if($guard == "agents"){
            return redirect('/agents/login');
        }
        return $next($request);
    }
}
