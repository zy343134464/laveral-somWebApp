<?php

namespace App\Http\Middleware;

use Closure;

class Checkrater
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
        $res = \DB::table('rater_match')->select('id')->where(['user_id'=>$id])->whereIn('status', [0,1,2])->first();
        
        if (count($res)) {
            return $next($request);
        }
        return redirect('/');
    }
}
