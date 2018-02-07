<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Admin\Match;
use App\Information;

class IndexController extends Controller
{
    public function index(Request $request, Match $match, Information $info)
    {
         $res = $match->when(isset($request->status),function($query) use ($request){
                return $query->where('status',$request->status);
            },function($query) use ($request){
                return $query->whereIn('status',[2,3,4,5]);
        })->Paginate(12);
         $news = $info->limit(15)->get();
        return view('home.index.index',['matches'=>$res,'news'=>$news,'status'=>$request->status]);
    }
    public function news(Request $request, Information $info, $id)
    {
    	$news = $info->limit(15)->get();
    }
    public function room()
    {
        $user_id = user('id');
        dd($user_id);
        return view('home.rater.room');
    }
}
