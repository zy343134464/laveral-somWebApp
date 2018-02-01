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
                "title" => json_encode($request->title),
                "detail" => $request->detail,
                "pic" =>$pic,
                "collect_start" => $request->collect_start ? strtotime($request->collect_start) :0,
                "collect_end" => $request->collect_end ? strtotime($request->collect_end) :0,
                "public_time" => $request->public_time ? strtotime($request->public_time) :0,
                "status" => 0,
        ]);
        return $res;
    }
    /**
     * 修改赛事
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function mainedit(Request $request, $id)
    {
        if ($request->pic) {
            $pic = save_match_pic($request->pic);
        } else {
            $pic = 'img\images\match-img4.jpg';
        }
        $res = \DB::table('matches')->where('id', $id)->update([
                "type" => $request->type ? $request->type : '',
                "title" => json_encode($request->title),
                "detail" => $request->detail,
                "collect_start" => $request->collect_start ? strtotime($request->collect_start) :0,
                "collect_end" => $request->collect_end ? strtotime($request->collect_end) :0,
                "public_time" => $request->public_time ? strtotime($request->public_time) :0,
                "status" => 0,
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
            'prodution_info'=>json_encode($prodution_info),
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
            'prodution_info'=>json_encode($prodution_info),
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
                    'round' => $k,
                    'type' => 1,
                    'end_time' => strtotime(($request->end_time1)[$k]),
                    'promotion' => ($request->promotion1)[$k],
                    'setting' => ($request->setting1)['vote'][$k][0],
                    'rater' => json_encode(($request->rater1)[$k]),
                ]);
            } else {
                $temp = [];
                $temp['min'] = ($request->min2)[$k];
                $temp['reference'] = ($request->reference2)[$k];
                $temp['dimension'] = ($request->setting2)['dimension'][$k];
                $temp['percent'] = ($request->setting2)['percent'][$k];
                \DB::table('reviews')->insert([ 
                    'match_id' => $id,
                    'round' => $k,
                    'type' => 2,
                    'end_time' => ($request->end_time2)[$k],
                    'promotion' => ($request->promotion2)[$k],
                    'setting' => json_encode($temp),
                    'rater' => json_encode(($request->rater2)[$k]),
                ]);
            }
        }
    }
}
