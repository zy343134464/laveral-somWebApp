<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Admin\Match;
use App\Information;
use App\Rater_match;
use App\Production;

class IndexController extends Controller
{
    /**
     * 首页
     * @param  Request     $request [description]
     * @param  Match       $match   [description]
     * @param  Information $info    [description]
     * @return [type]               [description]
     */
    public function index(Request $request, Match $match, Information $info)
    {
        $res = $match->when(isset($request->status), function ($query) use ($request) {
            return $query->where('status', $request->status);
        }, function ($query) use ($request) {
            return $query->whereIn('status', [2,3,4,5]);
        })->orderBy('id', 'desc')->Paginate(12);
        $news = $info->limit(9)->orderBy('id', 'desc')->get();
        
        return view('home.index.index', ['matches'=>$res,'news'=>$news,'status'=>$request->status]);
    }
    

    
   
    

    public function review_score(Request $request, Production $production)
    {
        return  $production->review_score($request);
    }

   
    /**
     * 资讯详情页
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function news(Request $request, $id)
    {
        $new = \DB::table('information')->find($id);
        if (count($new)) {
            return view('home.index.new', ['news'=>$new]);
        }
        return back();
    }
}
