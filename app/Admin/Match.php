<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Admin\User;

class Match extends Model
{
    /**
     * 展示赛事
     * @param  [type] $organ  机构id, null时返回所有机构,
     * @param  [array] $status 赛事状态数组
     * @param  string $kw     关键词搜索赛事,title type detail
     * @param  [array] $cat    赛事分类数组,默认空数组搜索0,1 (单项综合赛事)
     * @return [type]         搜索结果
     */
    public function show($organ, $status, $kw = '', $cat = [])
    {
        $res = $match
            ->when(isset($organ), function ($query) use ($organ) {
                return $query->where('organ_id', $organ);
            })
            ->whereIn('status', $status)
            ->when($cat, function ($query) use ($cat) {
                return $query->whereIn('cat', $cat);
            }, function ($query) use ($cat) {
                return $query->whereIn('cat', [0,1]);
            })
            ->when($kw, function ($query) use ($kw) {
                return $query->orWhere('title', 'like', '%'.$kw.'%')
                                ->orWhere('type', 'like', '%'.$kw.'%')
                                ->orWhere('detail', 'like', '%'.$kw.'%');
            })
            ->limit(20)->get();
        return $res;
    }
    /**
     * 添加赛事
     * @param  Request $request [description]
     * @param  [type]  $type    [description]
     * @return [type]           [description]
     */
    public function main(Request $request, $type)
    {
        if ($request->pic) {
            $pic = save_match_pic($request->pic);
        } else {
            $pic = 'img\images\match-img4.jpg';
        }
        $res = \DB::table('matches')->insertGetId([
                "cat" => $type,
                "type" => $request->type ? $request->type : '',
                "title" => json_encode($request->title,JSON_UNESCAPED_UNICODE),
                "detail" => $request->detail,
                "pic" =>$pic,
                "collect_start" => $request->collect_start ? strtotime($request->collect_start) :0,
                "collect_end" => $request->collect_end ? strtotime($request->collect_end) :0,
                "public_time" => $request->public_time ? strtotime($request->public_time) :0,
                "status" => 0,
        ]);
        return $res;
    }
    public function del_match($id)
    {
        $res = $this->where('id',$id)->get()->toArray();
        if(!count($res)) return false;
        $pic = $res[0]['pic'];
        $else_pic = $this->where('pic',$pic)->where('id','<>',$id)->get();
        if(!count($else_pic)) del_match_pic($pic);
        \DB::table('partners')->where('match_id', $id)->delete();
        \DB::table('connections')->where('match_id', $id)->delete();
        \DB::table('awards')->where('match_id', $id)->delete();
        \DB::table('require_personal')->where('match_id', $id)->delete();
        \DB::table('require_team')->where('match_id', $id)->delete();
        \DB::table('raters')->where('match_id', $id)->delete();
        \DB::table('guests')->where('match_id', $id)->delete();
        \DB::table('reviews')->where('match_id', $id)->delete();
        \DB::table('matches')->where('id', $id)->delete();

    }
    public function copy($id)
    {
        try{
            
            $info = $this->where('id',$id)->get()->toArray();
            if(!count($info)) return ['data'=>false,'msg'=>'服务器故障,加载赛事数据失败......'];
            $title = json_decode($info[0]['title']);
            $title[0] = '(复制) '.$title[0];
            $new_id = \DB::table('matches')->insertGetId([
                    "cat" => $info[0]['cat'],
                    "type" => $info[0]['type'],
                    "title" => json_encode($title,JSON_UNESCAPED_UNICODE),
                    "detail" => $info[0]['detail'],
                    "pic" =>$info[0]['pic'],
                    "collect_start" => $info[0]['collect_start'],
                    "collect_end" => $info[0]['collect_end'],
                    "public_time" => $info[0]['public_time'],
                    "status" => 0,
            ]);

            $this->copy_info('partners',$id,$new_id);
            $this->copy_info('connections',$id,$new_id);
            $this->copy_info('awards',$id,$new_id);
            $this->copy_info('require_personal',$id,$new_id);
            $this->copy_info('require_team',$id,$new_id);
            $this->copy_info('raters',$id,$new_id);
            $this->copy_info('guests',$id,$new_id);
            $this->copy_info('reviews',$id,$new_id);

            return ['data'=>$new_id,'msg'=>''];

        }catch (\Exception $e){
           return ['data'=>false,'msg'=>'复制失败'];

        }
    }
    public function copy_info($str,$old_id,$new_id)
    {
        $res = \DB::table($str)->where('match_id', $old_id)->get()->toArray();
        if(count($res)) {
            foreach (json_decode(json_encode($res,JSON_UNESCAPED_UNICODE),true) as $vv)
            {
                $temp = [];
                foreach ($vv as $k => $v)
                {
                    if($k == 'match_id') {
                        $temp[$k] = $new_id;
                    } elseif($k == 'id') {

                    } else {
                        $temp[$k] = $v;
                    }
                    
                }
                \DB::table($str)->insertGetId($temp);
            }
        }
    }
    /**
     * 修改赛事
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function mainedit(Request $request, $id)
    {
        $info = \DB::table('matches')->select('pic')->where('id', $id)->first();
        $opic = $info->pic;
        if ($request->pic) {
            $pic = save_match_pic($request->pic);
            del_match_pic($opic);
        } else {
            $pic = $opic;
        }
        $res = \DB::table('matches')->where('id', $id)->update([
                "type" => $request->type ? $request->type : '',
                "title" => json_encode($request->title,JSON_UNESCAPED_UNICODE),
                "detail" => $request->detail,
                "pic" =>$pic,
                "collect_start" => $request->collect_start ? strtotime($request->collect_start) :0,
                "collect_end" => $request->collect_end ? strtotime($request->collect_end) :0,
                "public_time" => $request->public_time ? strtotime($request->public_time) :0,
        ]);
        
        return $id;
    }
    /**
     * 添加/修改 合作伙伴
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function partner(Request $request, $id)
    {
        \DB::table('partners')->where('match_id', $id)->delete();
        if ($request->role) {
            if (count($request->role)) {
                foreach ($request->role as $k=>$v) {
                    if (is_null($v) || is_null(($request->name)[$k])) {
                        continue;
                    }
                    \DB::table('partners')->insertGetId([
                        'role'=>$v,
                        'name'=>($request->name)[$k],
                        'match_id'=>$id,
                        'organ_id'=>organ('id'),
                    ]);
                }
            }
        }
    }
    /**
     * 添加/修改 联系方式
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function connection(Request $request, $id)
    {
        \DB::table('connections')->where('match_id', $id)->delete();
        if ($request->type) {
            if (count($request->type)) {
                foreach ($request->type as $k=>$v) {
                    if (is_null($v) ||  is_null(($request->value)[$k])) {
                        continue;
                    }
                    \DB::table('connections')->insertGetId([
                        'type'=>$v,
                        'value'=>($request->value)[$k],
                        'match_id'=>$id,
                    ]);
                }
            }
        }
    }
    /**
     * 添加/修改 展示的奖项
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function award(Request $request, $id)
    {
        \DB::table('awards')->where('match_id', $id)->delete();
        if ($request->name) {
            if (count($request->name)) {
                foreach ($request->name as $k=>$v) {
                    if (is_null($v) || is_null(($request->num)[$k])) {
                        continue;
                    }
                    \DB::table('awards')->insertGetId([
                        'name'=>$v,
                        'num'=>($request->num)[$k] > 0 ?($request->num)[$k] : 1,
                        'detail'=>($request->detail)[$k],
                        'match_id'=>$id,
                    ]);
                }
            }
        }
    }
    /**
     * 添加/修改 个人投稿要求
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function require_personal(Request $request, $id)
    {
        \DB::table('require_personal')->where('match_id', $id)->delete();
        $info = [];
        $required = [];
        foreach ($request->info as $v) {
            $info[] = $v;
            if (in_array($v.'_r', $request->required)) {
                $required[] = 1;
            } else {
                $required[] = 0;
            }
        }
        $prodution_info[] = $info;
        $prodution_info[] = $required;
        \DB::table('require_personal')->insertGetId([
            'match_id'=>$id,
            'group_min'=>$request->group_min ? $request->group_min : 0,
            'group_max'=>$request->group_max ? $request->group_max : 0,
            'group_limit'=>$request->group_limit ? 1:0,
            'num_max'=>$request->num_max ? $request->num_max : 0,
            'num_min'=>$request->num_min ? $request->num_min :  0,
            'size_min'=>$request->size_min ? $request->size_min : 0,
            'size_max'=>$request->size_max ? $request->size_max : 0,
            'length'=>$request->length ? $request->length: 0,
            'pay'=>$request->pay ? $request->pay : 0,
            'price'=>$request->price ? $request->price : 0,
            'currency'=>$request->currency ? $request->currency : 'rmb',
            'notice'=>$request->notice ? $request->notice : '',
            'production_info'=>json_encode($prodution_info,JSON_UNESCAPED_UNICODE),
            'pay_title'=>$request->pay_title ? $request->pay_title : '',
            'pay_detail'=>$request->pay_detail ? $request->pay_detail : '',
            'introdution_title'=>$request->introdution_title ? $request->introdution_title : '',
            'introdution_detail'=>$request->introdution_detail ? $request->introdution_detail : '',
        ]);
    }
    /**
     * 添加/修改 团体投稿要求
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function require_team(Request $request, $id)
    {
        \DB::table('require_team')->where('match_id', $id)->delete();
        $info = [];
        $required = [];
        foreach ($request->info as $v) {
            $info[] = $v;
            if (in_array($v.'_r', $request->required)) {
                $required[] = 1;
            } else {
                $required[] = 0;
            }
        }
        $prodution_info[] = $info;
        $prodution_info[] = $required;
        \DB::table('require_team')->insertGetId([
            'match_id'=>$id,
            'group_min'=>$request->group_min ? $request->group_min : 0,
            'group_max'=>$request->group_max ? $request->group_max : 0,
            'group_limit'=>$request->group_limit ? 1:0,
            'num_max'=>$request->num_max ? $request->num_max : 0,
            'num_min'=>$request->num_min ? $request->num_min :  0,
            'size_min'=>$request->size_min ? $request->size_min : 0,
            'size_max'=>$request->size_max ? $request->size_max : 0,
            'length'=>$request->length ? $request->length: 0,
            'pay'=>$request->pay ? $request->pay : 0,
            'price'=>$request->price ? $request->price : 0,
            'currency'=>$request->currency ? $request->currency : 'rmb',
            'notice'=>$request->notice ? $request->notice : '',
            'production_info'=>json_encode($prodution_info,JSON_UNESCAPED_UNICODE),
            'pay_title'=>$request->pay_title ? $request->pay_title : '',
            'pay_detail'=>$request->pay_detail ? $request->pay_detail : '',
            'introdution_title'=>$request->introdution_title ? $request->introdution_title : '',
            'introdution_detail'=>$request->introdution_detail ? $request->introdution_detail : '',
        ]);
    }
    /**
     * 添加展示的评委
     * @param  [type] $arr [description]
     * @param  [type] $mid [description]
     * @return [type]      [description]
     */
    public function rater($arr, $mid)
    {
        $user = \DB::table('users')->whereIn('id', $arr)->get();
        foreach ($user as $v) {
            \DB::table('raters')->insertGetId([
                'match_id'=>$mid,
                'name'=>$v->name,
                'pic'=>$v->pic,
                'detail'=>$v->introdution,
            ]);
        }
    }
    /**
     * 新增展示的评委
     * @param  [type] $request [description]
     * @param  [type] $id      [description]
     * @return [type]          [description]
     */
    public function newrater($request, $id)
    {
        \DB::table('raters')->insertGetId([
                'match_id'=>$id,
                'name'=>$request->name,
                'pic'=>save_match_pic($request->pic),
                'detail'=>$request->detail,
            ]);
    }
    /**
     * 编辑展示的评委
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function editnewrater($request)
    {
        if(!$request->name) {
            return redirect()->back();
        }
        \DB::table('raters')->where('id', $request->id)->update([
            'name' => $request->name,
            'detail' => $request->detail ? $request->detail : '',
            'pic' => save_match_pic($request->pic)
            ]);
    }
    /**
     * 编辑展示的嘉宾
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function editnewguest($request)
    {
        if(!$request->name) {
            return redirect()->back();
        }
        \DB::table('guests')->where('id', $request->id)->update([
            'name' => $request->name,
            'detail' => $request->detail ? $request->detail : '',
            'pic' => save_match_pic($request->pic)
            ]);
    }
    /**
     * 添加展示的嘉宾
     * @param  [type] $arr [description]
     * @param  [type] $mid [description]
     * @return [type]      [description]
     */
    public function guest($arr, $mid)
    {
        $user = \DB::table('users')->whereIn('id', $arr)->get();
        foreach ($user as $v) {
            \DB::table('guests')->insertGetId([
                'match_id'=>$mid,
                'name'=>$v->name,
                'pic'=>$v->pic,
                'detail'=>$v->introdution,
            ]);
        }
    }
    /**
     * 新增展示的嘉宾
     * @param  [type] $request [description]
     * @param  [type] $id      [description]
     * @return [type]          [description]
     */
    public function newguest($request, $id)
    {
        \DB::table('guests')->insertGetId([
                'match_id'=>$id,
                'name'=>$request->name,
                'pic'=>save_match_pic($request->pic),
                'detail'=>$request->detail,
            ]);
    }
    // --------------------------------------------------------------------------------------------
    /**
    * 获取评审轮次信息
    * @author   K
    */
    public function get_review(Request $request, Match $match, $id)
    {
        $info = \DB::table('review')->where('match_id', $id)->get();
    
        if ($info) {
            foreach ($info as &$v) {
                //转换json
                if ($info->type == 2) {
                    $info->setting = (array)json_decode($info->setting);
                    //评委图片
                    $info->raters_pic = $this->get_raters_pic($info->raters);
                }
            }
        }
        return $info;
    }


    /**
     * 设置评审轮次信息___添加评委到user表
     */
    public function add_rater($request, $id)
    {
        if (empty($request->phone)) {
            return ['msg'=>'手机号不能为空','data'=>''];
        }
        if (empty($request->password)) {
            return ['msg'=>'密码不能为空','data'=>''];
        }

        //获取机构信息
        $orgin_id = organ('id');
        
        //检测是否存在该用户
        $user_info = \DB::table('users')->where('phone', $request->phone)->first();
        if (count($user_info)) {
            $uid = $user_info->id;
        } else {
            $uid = \DB::table('users')->insertGetId([
                    'phone'=>$request->phone,
                    'name'=>$request->name ? $request->name : $request->phone,
                    'password'=>$request->password,
                ]);
        }
        //检测该机构下是否有该评委角色，没有的话创建评委角色
        $rater = \DB::table('members')->where(['uid'=>$uid, 'role_type'=>'rater', 'organ_id'=>$orgin_id ])->first();
        if (count($rater)) {
            return ['msg'=>'','data'=>$uid];
        } else {
            $role = \DB::table('roles')->where(['organ_id'=>$orgin_id, 'role_type'=>'rater'])->first();
            $role_id = $role->id;
            \DB::table('members')->insertGetId([
                'uid'=>$uid,
                'organ_id'=>$orgin_id,
                'role_id'=>$role_id,
                'role_type'=>'rater',
            ]);
            return ['msg'=>'','data'=>$uid];
        }
           
        return $user_info;
    }
    
    // --------------------------------------------------------------------------------------------
    /**
     * 根据$kw 搜索角色为rater的用户
     * @param  [type] $request [description]
     * @return [array]          [rater]
     */
    public function search_raters($request)
    {
        $kw = $request->kw ;
        $user = User::select('id', 'pic', 'name', 'first_name', 'second_name', 'introdution')->when($kw, function ($query) use ($kw) {
            return $query
            ->orWhere('name', 'like', '%'.$kw.'%')
            ->orWhere('first_name', 'like', '%'.$kw.'%')
            ->orWhere('second_name', 'like', '%'.$kw.'%')
            ->orWhere('phone', 'like', '%'.$kw.'%');
        })->get();
        $rater = [];
        $id = [];
        foreach ($user as  $v) {
            foreach ($v->member as $vv) {
                if ($vv->role_type == 'rater' and $vv->organ_id == organ('id')) {
                    //过滤相同的数据
                    if (in_array($v->id, $id)) {
                        continue;
                    }
                    $id[] = $v->id;
                    $temp  = $v->toArray();
                    unset($temp['member']);
                    $rater[] = $temp;
                }
            }
        }

        return $rater;
    }

    /**
     * 评审设置
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function review(Request $request, $id)
    {
        \DB::table('reviews')->where('match_id', $id)->delete();
        foreach ($request->type as $k => $v) 
        {
            if($v == 'vote') {
                \DB::table('reviews')->insert([ 
                    'match_id' => $id,
                    'round' => $k +1,
                    'type' => 1,
                    'end_time' => ($request->end_time1)[$k] ? strtotime(($request->end_time1)[$k]) : 0,
                    'promotion' => ($request->promotion1)[$k] ? ($request->promotion1)[$k] :0,
                    'setting' => ($request->setting1)['vote'][$k][0],
                    'rater' => json_encode(($request->rater1)[$k],JSON_UNESCAPED_UNICODE),
                ]);
            } else {
                $temp = [];
                $temp['min'] = ($request->min2)[$k];
                $temp['reference'] = ($request->reference2)[$k];
                $temp['dimension'] = ($request->setting2)['dimension'][$k];
                $temp['percent'] = ($request->setting2)['percent'][$k];
                \DB::table('reviews')->insert([ 
                    'match_id' => $id,
                    'round' => $k +1,
                    'type' => 2,
                    'end_time' => ($request->end_time2)[$k] ? strtotime(($request->end_time2)[$k]) : 0,
                    'promotion' => ($request->promotion2)[$k] ? ($request->promotion2)[$k] : 0,
                    'setting' => json_encode($temp,JSON_UNESCAPED_UNICODE),
                    'rater' => json_encode(($request->rater2)[$k],JSON_UNESCAPED_UNICODE),
                ]);
            }
        }
        $this->save_rater_info($id);

    }
    /**
     * 人气投票
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function popularity(Request $request, $id)
    {
        if($request->hot) {
            \DB::table('popularity')->where('match_id', $id)->delete();

            \DB::table('popularity')->insert([
                'match_id'=>$id,
                'start'=>$request->hot_start ? strtotime($request->hot_start) : 0,
                'end'=>$request->hot_end ? strtotime($request->hot_end) : 0
            ]);
        }
    }
    public function win(Request $request, $id)
    {
        \DB::table('win')->where('match_id', $id)->delete();
        if ($request->win_name) {
            $no = 0;
            foreach ($request->win_name as $k => $v) {
                if(($request->win_number)[$k] and ($request->win_number)[$k] > 0) {
                    $no += 1;
                     \DB::table('win')->insert([
                        'match_id'=>$id,
                        'no'=>$no,
                        'name'=>$request->win_name[$k],
                        'num'=>$request->win_number[$k]
                    ]);
                }
            }
        }
    }
  
    public function uploadimg(Request $request, $id)
    {
        try {
            $user_id = \Cookie::get('user_id');
            if(!isset($user_id) || !$request->pic) return false;
            $res = $this->find($id);
            if(!count($res)) return false;
            $match_id = $res->id;
            $pic_id = \DB::table('productions')->insertGetId([
                    'match_id'=>$match_id,
                    'user_id'=>$user_id,
                    'pic'=>uploadimg($request->pic),
                    'type'=>0,
                ]);
            return $pic_id;
        } catch (\Exception $e) {
            return false;
        }
        
    }
    public function editimg(Request $request, $id)
    {
        try {
            $pic = \DB::table('productions')->where('id',$id)->first();
            if(!$pic)  return false;
            $info = \DB::table('require_personal')->where('match_id',$pic->match_id)->first();
            $res = json_decode($info->production_info);
            $temp = [];
            foreach ($res[0] as $k => $v) {
                if($res[1][$k]) if(!isset($request->$v)) return false;
                $temp[$v] = $request->$v;
            }
            if(!$info)  return false;
            \DB::table('productions')->where('id',$id)->update($temp);
        } catch (\Exception $e) {
            return false;
        }
    }
    public function info($id)
    {
         try {
            $res = \DB::table('matches')->where('id', $id)->get()->toArray();
            if(!count($res)) return false;
            $info = $res[0];
            $res = \DB::table('partners')->where('match_id', $id)->get()->toArray();
            $info->partner = $res;
            $res = \DB::table('raters')->where('match_id', $id)->get()->toArray();
            $info->rater = $res;
            $res = \DB::table('require_personal')->where('match_id', $id)->get()->toArray();
            $info->personal = $res;
            $res = \DB::table('awards')->where('match_id', $id)->get()->toArray();
            $info->award = $res;
            //$data = json_decode(json_encode($info,JSON_UNESCAPED_UNICODE),true);
            return $info;
        } catch (\Exception $e) {
            dd(000,$e);
            return false;
        }
    }
    public function save_rater_info($mid)
    {
        $res = \DB::table('reviews')->where('match_id',$mid)->get();
    }
}
