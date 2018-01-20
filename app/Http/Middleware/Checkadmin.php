<?php

namespace App\Http\Middleware;

use Closure;

class Checkadmin
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
        $id = \Cookie::get('user_id');
        $res = \DB::table('admins')->where('user_id', $id)->first();
        if (count($res)) {
            if ($res->is_admin) {
                return $next($request);
            }
        }
        return redirect('/');
    }
}
