<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return string
     */
    
    protected function redirectTo($request)
    {
        // if (in_array('agents', $exception->guards())) {
        //     return $request->expectsJson()
        //         ? response()->json([
        //               'message' => $exception->getMessage()
        //         ], 401)
        //         : redirect()->guest(route('agent.login'));
        // }
        Log::info('Authenticate.php: ',['data' => $request->expectsJson()] );
        
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
