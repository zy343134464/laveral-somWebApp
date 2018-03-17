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
    /**
     * 评委 评审中
     * @param  Request     $request     [description]
     * @param  Rater_match $rater_match [description]
     * @return [type]                   [description]
     */
    public function room(Request $request, Rater_match $rater_match)
    {
        $matches = $rater_match->where(['user_id'=> user('id'),'status'=>1])->Paginate(15);
        return view('home.rater.room', ['matches'=>$matches,'kw'=>'','status'=>'',]);
    }
    /**
     * 评委 历史
     * @param  Request     $request     [description]
     * @param  Rater_match $rater_match [description]
     * @return [type]                   [description]
     */
    public function history(Request $request, Rater_match $rater_match)
    {
        // ----------------------------评委评审室.获取评委赛事--------------------------------
        $matches = $rater_match->where(['user_id'=> user('id'),'status'=>2])->Paginate(15);
        return view('home.rater.room', ['matches'=>$matches,'kw'=>'','status'=>'',]);
    }

    /**
     * 评审 赛事
     * @param  Request    $request    [description]
     * @param  Production $production [description]
     * @param  [type]     $mid        [description]
     * @param  [type]     $round      [description]
     * @return [type]                 [description]
     */
    public function review(Request $request, Production $production, $mid, $round)
    {
        function simple_arr($arr)
        {
            foreach ($arr as &$arr_v) {
                $arr_v = $arr_v->production_id;
            }
            return $arr;
        }
        $match = Match::find($mid);
        $status = $request->status;

        if (!count($match)) {
            return back()->with('msg', '获取数据失败');
        }

        $secure = \DB::table('rater_match')->where(['match_id'=>$mid,'user_id'=>user('id'),'round'=>$round])->first();
        if (!count($secure)) {
            return back()->with('msg', '获取数据失败');
        }
        if ($secure->status == 2) {
            return back()->with('msg', '评审已结束');
        }
        if ($secure->status == 0) {
            return back()->with('msg', '评审未开始');
        }

        $arr = \DB::table('result')->select('production_id')->where(['match_id'=>$mid,'round'=>$round])->first();
        if (!count($arr)) {
            return back()->with('msg', '该阶段尚未开始');
        }
        $arr = json_decode($arr->production_id);

        $pic = $production->whereIn('id', $arr);
        $review = \DB::table('reviews')->select('type', 'setting', 'end_time')->where(['match_id'=>$mid,'round'=>$round])->first();
        if (!count($review)) {
            return back()->with('msg', '获取数据失败');
        }
        $type = $review->type;

        $sum = [];
        if ($type == 1) {
            $finish_pass = \DB::table('score')->select('production_id')->where(['match_id'=>$mid,'round'=>$round,'rater_id'=>user('id'),'res'=>1])->get()->toArray();
            $sum[1] = count($finish_pass);

            $finish_out = \DB::table('score')->select('production_id')->where(['match_id'=>$mid,'round'=>$round,'rater_id'=>user('id'),'res'=>2])->get()->toArray();
            $sum[2] = count($finish_out);
            
            $finish_standby = \DB::table('score')->select('production_id')->where(['match_id'=>$mid,'round'=>$round,'rater_id'=>user('id'),'res'=>3])->get()->toArray();
            $sum[3] = count($finish_standby);

            $sum[0] = count($arr) - $sum[1] - $sum[2] - $sum[3];

            if ($status == 1) {
                $pic = $pic->whereIn('id', simple_arr($finish_pass));
            } elseif ($status == 2) {
                $pic = $pic->whereIn('id', simple_arr($finish_out));
            } elseif ($status == 3) {
                $pic = $pic->whereIn('id', simple_arr($finish_standby));
            } elseif ($status == '0') {
                $pic = $pic->whereNotIn('id', simple_arr($finish_pass))->whereNotIn('id', simple_arr($finish_out))->whereNotIn('id', simple_arr($finish_standby));
            }
        } else {
            $finish_arr = \DB::table('score')->select('production_id')->where(['match_id'=>$mid,'round'=>$round,'rater_id'=>user('id')])->get()->toArray();
            $sum[1] = count($finish_arr);
            $sum[0] = count($arr) - count($finish_arr);

            if ($status === '0') {
                $pic = $pic->whereNotIn('id', simple_arr($finish_arr));
            } elseif ($status == 1) {
                $pic = $pic->whereIn('id', simple_arr($finish_arr));
            } else {
            }
        }
            
            
        $pic = $pic->Paginate(16);

        return view('home.rater.review', ['status'=>$status,'pic'=>$pic,'kw'=>'','match'=>$match,'round'=>$round,'sum'=>$sum,'secure'=>$secure,'type'=>$type, 'review'=>$review]);
    }
    /**
     * 评委评分
     * @param  Request    $request    [description]
     * @param  Production $production [description]
     * @return [type]                 [description]
     */
    public function pic(Request $request, Production $production)
    {
        $res = $production->review($request, $request->type);
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
