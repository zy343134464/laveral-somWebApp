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
    public function index(Request $request, Match $match, Information $info)
    {
        $res = $match->when(isset($request->status), function ($query) use ($request) {
            return $query->where('status', $request->status);
        }, function ($query) use ($request) {
            return $query->whereIn('status', [2,3,4,5]);
        })->Paginate(12);
        $news = $info->limit(15)->get();
        return view('home.index.index', ['matches'=>$res,'news'=>$news,'status'=>$request->status]);
    }

    public function room(Request $request, Rater_match $rater_match)
    {
        // ----------------------------评委评审室.获取评委赛事--------------------------------
        $matches = $rater_match->where('user_id', user('id'))->Paginate(15);
        if(!count($matches)) return back()->with('msg','获取数据失败');
        //dd($matches);
        return view('home.rater.room', ['matches'=>$matches,'kw'=>'','status'=>'',]);
    }

    public function review(Request $request, Production $production, $mid, $round)
    {
        $secure = \DB::table('rater_match')->where(['match_id'=>$mid,'user_id'=>user('id'),'round'=>$round])->first();
        if(!count($secure)) return back()->with('msg','获取数据失败');

        $match = Match::find($mid);
        if(!count($match)) return back()->with('msg','获取数据失败');

        $arr = \DB::table('result')->select('production_id')->where(['match_id'=>$mid,'round'=>$round])->first();
        if(!count($arr)) return back()->with('msg','该阶段尚未开始');

        $review = \DB::table('reviews')->select('type','setting','end_time')->where(['match_id'=>$mid,'round'=>$round])->first();
        if(!count($review)) return back()->with('msg','获取数据失败');
        $type = $review->type;
        $pic = $production->whereIn('id',json_decode($arr->production_id))->Paginate(16);

        return view('home.rater.review',['status'=>'','pic'=>$pic,'kw'=>'','match'=>$match,'round'=>$round,'secure'=>$secure,'type'=>$type, 'review'=>$review]);
    }

    public function pic(Request $request, Production $production)
    {
        $res = $production->review($request,$request->type);
        return  json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function review_score(Request $request, Production $production)
    {
        return  $production->review_score($request);
    }

    public function rater_pic(Request $request, $id)
    {
        $data = \DB::table('productions')->find($id);
        if (count($data)) {
            return ['msg'=>'','data'=>$data];
        } else {
            return ['msg'=>'数据错误','data'=>false];
        }
    }
}
