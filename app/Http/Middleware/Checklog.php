<?php

namespace App\Http\Middleware;

use Closure;

class Checklog
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
        if (\Cookie::get('user_id')){
            return $next($request);
        } else {
            if($request->getRequestUri() == "/login") {
                return $next($request);
            }
             return $next($request);
            return redirect('login');
        }
        
    }
}
