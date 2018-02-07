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
        $res = \DB::table('members')->where(['uid'=>$id, 'role_type'=>'rater', 'organ_id'=>1])->first();
        if (count($res)) {
            return $next($request);
        }
        return redirect('/');
    }
}
