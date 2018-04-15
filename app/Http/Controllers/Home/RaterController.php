<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Admin\Match;
use App\Information;
use App\Rater_match;
use App\Production;

class RaterController extends Controller
{
    /**
     * 评委 评审中
     * @param  Request     $request     [description]
     * @param  Rater_match $rater_match [description]
     * @return [type]                   [description]
     */
    public function room(Request $request, Rater_match $rater_match)
    {
        $matches = $rater_match->where(['user_id'=> user(),'status'=>1])->Paginate(15);
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

            if(is_array($arr)) {

                foreach ($arr as &$arr_v) {
                    $arr_v = $arr_v->production_id;
                }
                return $arr;
            } else {
                $arr = json_decode($arr,true);
                foreach ($arr as &$arr_v) {
                    $arr_v = $arr_v->production_id;
                }
                return $arr;
            }
        }
        $match = Match::find($mid);
        $status = $request->status;

        if (!count($match)) {
            return back()->with('msg', '获取数据失败');
        }

        $secure = \DB::table('rater_match')->where(['match_id'=>$mid,'user_id'=>user(),'round'=>$round])->first();
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
        $arr = json_decode($arr->production_id,true);

        $pic = $production->whereIn('id', $arr);
        $review = \DB::table('reviews')->select('type', 'setting', 'end_time')->where(['match_id'=>$mid,'round'=>$round])->first();
        $time = $review->end_time - time();

        $time = $this->secsToStr($time);

        if (!count($review)) {
            return back()->with('msg', '获取数据失败');
        }
        $type = $review->type;
        $tip = json_decode($review->setting,true);
        if(isset($tip['reference'])) {
            $tip = $tip['reference'];
        } else {
            $tip = '';
        }
        $sum = [];
        if ($type == 1) {
            $finish_pass = \DB::table('score')->select('production_id')->where(['match_id'=>$mid,'round'=>$round,'rater_id'=>user(),'res'=>1])->get()->toArray();
            $sum[1] =  $secure->finish;

            $finish_out = \DB::table('score')->select('production_id')->where(['match_id'=>$mid,'round'=>$round,'rater_id'=>user(),'res'=>2])->get()->toArray();
            $sum[2] = count($finish_out);
            
            $finish_standby = \DB::table('score')->select('production_id')->where(['match_id'=>$mid,'round'=>$round,'rater_id'=>user(),'res'=>3])->get()->toArray();
            $sum[3] = count($finish_standby);

            $sum[0] = $secure->total - $sum[1] - $sum[2] - $sum[3];

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
            $finish_arr = \DB::table('score')->select('production_id')->where(['match_id'=>$mid,'round'=>$round,'rater_id'=>user()])->get()->toArray();
            $sum[1] = $secure->finish;
            $sum[0] = $secure->total - $secure->finish ;

            if ($status === '0') {
                $pic = $pic->whereNotIn('id', simple_arr($finish_arr));
            } elseif ($status == 1) {
                $pic = $pic->whereIn('id', simple_arr($finish_arr));
            } else {
            }
        }
            
            
        $pic = $pic->Paginate(16);

        return view('home.rater.review', ['status'=>$status,'pic'=>$pic,'kw'=>'','match'=>$match,'round'=>$round,'sum'=>$sum,'secure'=>$secure,'type'=>$type, 'review'=>$review,'round'=>$round,'time'=>$time,'tip'=>$tip]);
    }
    /**
     * 评审点击 获取图片详细信息
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
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
    /**
     * 时间戳转时间(在 review 中被调用)
     * @param  [type] $times [description]
     * @return [type]        [description]
     */
    public function secsToStr($times) {
        $result = '00:00:00';  
        if ($times>0) {  
                $hour = floor($times/3600);  
                $minute = floor(($times-3600 * $hour)/60);  
                $second = floor((($times-3600 * $hour) - 60 * $minute) % 60);  
                $result = $hour.'小时'.$minute.'分'.$second.'秒';  
        }  
        return $result;
    }
}
