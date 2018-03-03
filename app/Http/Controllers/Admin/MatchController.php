<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\Match;
use App\Review;
use PDF;
use App\Production;

use Illuminate\Support\Facades\DB;

class Matchcontroller extends Controller
{
    /**
     * 赛事展示页面
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $show    [description]
     * @return [type]           [description]
     */
    public function index(Request $request, Match $match, $show)
    {
        //dd(isset($request->cat));
        //0:未发布;1:赛事暂停;2:已发布;3:征稿中;4:征稿结束;5:评审中;6:结束
        // if ($request->status == 1) {
        //     $status = [0];
        // } elseif ($request->status == 2) {
        //     $status = [2,3,4,5];
        // } else {
        //     $status = [6];
        // }
        // if ($$request->cat) {
        //     $cat = [$cat];
        // } else {
        //     $cat = [0,1];
        // }
        // $res = $match->show($status);
        $res = $match->when(isset($request->status), function ($query) use ($request) {
            return $query->where('status', $request->status);
        }, function ($query) use ($request) {
            return $query->whereIn('status', [2,3,4,5]);
        })->when(isset($request->cat), function ($query) use ($request) {
            return $query->where('cat', $request->cat);
        }, function ($query) use ($request) {
            return $query->whereIn('cat', [0,1]);
        })->Paginate(12);
        if ($show == 'b') {
            return view('test2', ['matches'=>$res,'kw'=>'','status'=>$request->status,'cat'=>$request->cat]);
        }
        if ($show == 'list') {
            return view('admin.match.show.list', ['matches'=>$res,'kw'=>'','status'=>$request->status,'cat'=>$request->cat]);
        } elseif ($show == 'block') {
            return view('admin.match.show.block', ['matches'=>$res,'kw'=>'','status'=>$request->status,'cat'=>$request->cat]);
        } else {
            return redirect()->to('/');
        }
    }

    /**
     * 创建比赛页面
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function create($type)
    {
        $type = $type ? 1 : 0 ;
        return view('admin.match.create.main', ['type'=>$type]);
    }
    /**
     * 删除比赛
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function del(Match $match, $id)
    {
        $match->del_match($id);

        return back();
    }
    /**
     * copy比赛
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function copy(Match $match, $id)
    {
        $res = $match->copy($id);
        if ($res['data']) {
            return back();
        }
        return back()->with('msg', $res['msg']);
    }

    /**
     * 处理创建比赛
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $type    [description]
     * @return [type]           [description]
     */
    public function store(Request $request, Match $match, $type)
    {
        if (is_null($request->title[0]) || is_null($request->detail) || is_null($request->collect_start)  || is_null($request->collect_end)) {
            return redirect()->back()->with('msg', '*为必填项,不能为空');
        }
        $id = $match->main($request, $type);
        if ($id) {
            return redirect('admin/match/partner/'.$id);
        }
        return redirect()->back()->with('msg', '添加数据失败...');
    }
    /**
     * 编辑比赛页面
     * @param  Match  $match [description]
     * @param  [type] $id    [description]
     * @return [type]        [description]
     */
    public function edit(Match $match, $id)
    {
        $match = $match->find($id);
        if (count($match)) {
            return view('admin.match.create.edit', ['match'=>$match,'id'=>$id]);
        } else {
            return redirect()->back();
        }
    }
    /**
     * 处理编辑比赛
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function mainedit(Request $request, Match $match, $id)
    {
        $id = $match->mainedit($request, $id);
        if ($id) {
            return redirect('admin/match/partner/'.$id);
        }
        return redirect()->back()->with('msg', '修改数据失败...');
    }
    /**
     * 根据match_id显示合作伙伴和联系方式页面
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function partner(Request $request, Match $match, $id)
    {
        $partner = \DB::table('partners')->where('match_id', $id)->get();
        $connection = \DB::table('connections')->where('match_id', $id)->get();
        return view('admin.match.create.partner', ['partner'=>$partner,'connection'=>$connection,'id'=>$id]);
    }
    /**
     * 根据id修改或添加合作伙伴和联系方式
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function storepartner(Request $request, Match $match, $id)
    {
        $match->partner($request, $id);
        $match->connection($request, $id);
        return redirect('admin/match/rater/'.$id);
    }
    /**
     * 赛事评委页面
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function rater(Request $request, Match $match, $id)
    {
        $rater = \DB::table('raters')->where('match_id', $id)->get();
        return view('admin.match.create.rater', ['rater'=>$rater,'id'=>$id]);
    }
    /**
     * 搜索评委页面
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function findrater(Request $request, Match $match, $id)
    {
        //dd($request->kw);
        $user = null ;
        // if (isset($request->kw)) {
        //     $user = \DB::table('users')->orWhere('name', 'like', '%'.$request->kw.'%')->orWhere('phone', 'like', '%'.$request->kw.'%')->groupBy('id')->Paginate(12);
        // }

        if (isset($request->kw)) {
            $user = \DB::table('users')->orWhere('name', 'like', '%'.$request->kw.'%')->orWhere('phone', 'like', '%'.$request->kw.'%')->Paginate(12);
        }


        return view('admin.match.create.findrater', ['user'=>$user,'id'=>$id,'kw'=>$request->kw]);
    }

    /**
     * 新建评委
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function newrater(Request $request, Match $match, $id)
    {
        $match->newrater($request, $id);
        return redirect('admin/match/rater/'.$id);
    }
    /**
     * 编辑新增的评委
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @return [type]           [description]
     */
    public function editnewrater(Request $request, Match $match)
    {
        $match->editnewrater($request);
        return redirect()->back();
    }
    public function delrater(Request $request, $id)
    {
        \DB::table('raters')->where('id', $id)->delete();
        return redirect()->back();
    }
    /**
     * 添加评委
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function storerater(Request $request, Match $match, $id)
    {
        $match->rater($request->id, $id);
        return redirect('admin/match/rater/'.$id);
    }
    /**
     * 赛事嘉宾页面
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function guest(Request $request, Match $match, $id)
    {
        $guest = \DB::table('guests')->where('match_id', $id)->get();
        return view('admin.match.create.guest', ['guest'=>$guest,'id'=>$id]);
    }
    /**
     * 搜索嘉宾页面
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function findguest(Request $request, Match $match, $id)
    {
        if ($request->kw) {
            $user = \DB::table('users')->orWhere('name', 'like', '%'.$request->kw.'%')->orWhere('phone', 'like', '%'.$request->kw.'%')->Paginate(12);
        } else {
            $user = [];
        }
        return view('admin.match.create.findguest', ['user'=>$user,'id'=>$id,'kw'=>$request->kw]);
    }
    /**
     * 添加嘉宾
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function storeguest(Request $request, Match $match, $id)
    {
        $match->guest($request->id, $id);
        return redirect('admin/match/guest/'.$id);
    }

    /**
     * 新建评委
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function newguest(Request $request, Match $match, $id)
    {
        $match->newguest($request, $id);
        return redirect('admin/match/guest/'.$id);
    }
    /**
     * 编辑新增的嘉宾
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @return [type]           [description]
     */
    public function editnewguest(Request $request, Match $match)
    {
        $match->editnewguest($request);
        return redirect()->back();
    }
    public function delguest(Request $request, $id)
    {
        \DB::table('guests')->where('id', $id)->delete();
        return redirect()->back();
    }

    /**
     * 赛事展示奖项页面
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function award(Request $request, Match $match, $id)
    {
        $award = \DB::table('awards')->where('match_id', $id)->get();
        return view('admin.match.create.award', ['award'=>$award,'id'=>$id]);
    }
    /**
     * 处理奖项修改或添加
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function storeaward(Request $request, Match $match, $id)
    {
        $match->award($request, $id);
        $res = $match->find($id);
        if(count($res)) {
            if($res->cat == 0) {
                return redirect('admin/match/require_personal/'.$id);
            } else {
                return redirect('admin/match/son/'.$id);
            }
        }
        
    }
    /**
     * 子赛事列表
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function son(Request $request, Match $match, $id)
    {
        $res = $match->find($id);
        $son = $match->where(['cat'=> 2,'pid'=>$id])->get();
        return view('admin.match.create.son',['id'=>$id,'match'=>$res,'son'=>$son]);
    }
    /**
     * 个人投稿要求
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function require_personal(Request $request, $id)
    {
        $require_personal = \DB::table('require_personal')->where('match_id', $id)->get();
        return view('admin.match.create.require_personal', ['require_personal'=>$require_personal,'id'=>$id]);
    }
    /**
     * 修改个人投稿要求
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function storerequire_personal(Request $request, Match $match, $id)
    {
        $match->require_personal($request, $id);
        return redirect('admin/match/review/'.$id);
    }
    /**
     * 团队投稿要求
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function require_team(Request $request, Match $match, $id)
    {
        $require_team = \DB::table('require_team')->where('match_id', $id)->get();
        return view('admin.match.create.require_team', ['require_team'=>$require_team,'id'=>$id]);
    }
    /**
     * 修改团队投稿要求
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function storerequire_team(Request $request, Match $match, $id)
    {
        $match->require_team($request, $id);
        if (match($id, 'cat') == 0) {
            return redirect()->to('admin/match/review/'.$id);
        }
        echo '综合赛事子赛事view';
    }
    /**
     * 评审设置
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function review(Request $request, Match $match, $id)
    {
        $review = Review::where('match_id', $id)->orderBy('round')->get();
        $win = \DB::table('win')->where('match_id', $id)->orderBy('no')->get();
        $pop = \DB::table('popularity')->where('match_id', $id)->first();

        return view('admin.match.create.review', ['id'=>$id, 'review'=>$review, 'pop'=>$pop, 'win'=>$win]);
    }
    /**
     * 处理评审设置
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function storereview(Request $request, Match $match, $id)
    {

        //dd($request->type,$_POST);
        $msg = '';
        $result = $match->review($request, $id);
        //dd($result);
        $match->popularity($request, $id);
        $match->win($request, $id);
        return redirect()->to('admin/match/showedit/'.$id)->with('msg', $msg);
        
    }
    /**
     * 预览页
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function showedit(Request $request, Match $match, $id)
    {
        $res = $match->info($id);
        if (!$res) {
            return back();
        }
        return view('admin.match.create.show', ['match'=>$res,'id'=>$id]);
    }
    /**
     * 公布赛事
     * @param  [type] $mid [description]
     * @return [type]      [description]
     */
    public function push_match(Request $request, Match $match, $id)
    {
        $res = $match->push_match($id);
        if ($res['data']) {
            $msg = '发布成功';
        } else {
            $msg = $res['msg'];
        }
        return back()->with('msg', $msg);
    }

    /**
     * 征稿开始
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function start_collect(Request $request, Match $match, $id)
    {
        $res = $match->start_collect($id);
        return back()->with('msg',  $res['msg']);
    }
    /**
     * 征稿结束
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function end_collect(Request $request, Match $match, $id)
    {
        $res = $match->end_collect($id);
        // if ($res) {
        //     $msg = '结束征稿';
        // } else {
        //     $msg = '数据错误';
        // }
        return redirect()->to('admin/match/review_room/'.$id)->with('msg',$res['msg']);
    }
    /**
     * 结束本轮评审,计算结果
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function result(Request $request, Match $match, $id)
    {
        $result = $match->find($id);
        $round = $result->round;
        $num = Review::where(['match_id'=>$id])->get();

        
        if(count($num) == $result->round) {
            return redirect()->to('admin/match/get_end_result/'.$id);
        };

        $res = $match->result($id);
        if($res) {
            return back()->with('msg',$res);
        } else {
            return back()->with('msg','default');
        }
        
    }
    /**
     * 下一轮
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function next_round(Request $request, Match $match, $id)
    {
        $res = $match->next_round($id);
        //------------
        //dd('$res');
       
        return redirect()->to('admin/match/review_room/'.$id)->with('msg', $res['msg']);
    }

    /**
     * ajax返回添加评委搜索数据
     * @param  [string] $request->$kw 搜索内容 可以是名字或者手机
     * @return [json字符串]
     */
    public function ajax_search_rater(Request $request, Match $match)
    {
        $res = $match->search_raters($request);
        return json_encode($res);
    }
    
    /**
     * 添加新评委
     */
    public function add_rater(Request $request, Match $match, $id)
    {
        $res = $match->add_rater($request, $id);
        return json_encode($res);
    }

    /**
     * 首页ajax赛事(筛选 $kw $cat)
     */
    public function get_match(Request $request, Match $match)
    {
        $kw = $request->kw ? $request->kw : '';
        $cat = $request->cat ? $request->cat : '';
        $res = $match->where('organ_id', organ('id'))
        ->whereIn('status', [2,3,4,5,6])
        ->whereIn('cat', [0,1])
        ->when($kw, function ($query) use ($kw) {
            return $query->orWhere('title', 'like', '%'.$kw.'%')
                        ->orWhere('type', 'like', '%'.$kw.'%')
                        ->orWhere('detail', 'like', '%'.$kw.'%');
        })
        ->when($cat, function ($query) use ($cat) {
            return $query->where('cat', $cat);
        })
        ->limit(9)->get();
        return json_encode($res);
    }
    /**
     * ajax获取评审设置中的评委信息
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function get_rater_info(Request $request, $id)
    {
        $info = \DB::table('users')->select('name', 'id', 'pic')->where('id', $id)->first();
        return json_encode($info);
    }



    public function review_room(Request $request, Production $production, Match $mm, $id)
    {
        $match = Match::find($id);
        if(!count($match)) return back()->with('msg','获取数据失败');
        // 当前进行中的轮次
        $rounding = $match->round ? $match->round : 1;
        if($rounding > $match->sum_round($match->id)) return back();
        // 查看的轮次
        $round = $request->round ? $request->round : $rounding;
        $round =( $round > $match->sum_round($match->id) ) ? $match->sum_round($match->id) : $round;

        //当前赛事状态
        $statusing = $match->status;
        $status = $request->status;
        $review = \DB::table('reviews')->where(['match_id'=>$id,'round'=>$round])->first();
        $type = $review->type;
        if($status == 1) {
            $pic = $production->where('match_id', $id)->Paginate(16);
        } elseif($status == 3) {
            $end = \DB::table('result')->where(['match_id'=>$id,'round'=>0])->get();
            if(count($end)) {
                return redirect()->to('admin/match/show_end/'.$id);
            } else {
                return back();
            }
        } else {
            if(($statusing == 2 || $statusing == 3 || $statusing == 4) && $match->collect_end < time()){
                $pic = $production->where('match_id', $id)->Paginate(16);
            } else {

                $result = \DB::table('result')->when($round,function ($query) use ($id, $round) {
                    return $query->where(['match_id'=>$id, 'status'=>1, 'round'=>$round]);
                },function ($query) use ($id, $rounding) {
                    return $query->where(['match_id'=>$id, 'status'=>1, 'round'=>$rounding]);
                })->orderBy('round','desc')->first();

                //$pic = $production->whereIn('id',json_decode($result->production_id))->where('match_id', $id)->with('sum_score')->Paginate(16);
                if(count($result)) {
                    $arr = json_decode($result->production_id);
                } else {
                    $arr =[];
                }
                $pic = Production::where('match_id', $id)
                    ->whereIn('id',$arr)->select(DB::raw('productions.*'))
                    ->leftJoin(DB::raw('(select sum, production_id from sum_score) as sum'), 'sum.production_id', '=', 'productions.id','sum.round','=',$round)
                    ->orderBy('sum', 'desc')->Paginate(16);
            }
        }
        return view('admin.match.review.review',['status'=>$statusing,'pic'=>$pic,'kw'=>'','match'=>$match,'rounding'=>$rounding,'round'=>$round,'type'=>$type,'id'=>$id]);
    }

    public function edit_result(Production $production, Match $match, $id)
    {
        $res = $match->find($id);
        $round = $res->round;
        $review = \DB::table('reviews')->where(['match_id'=>$id,'round'=>$round])->first();
        $type = $review->type;
        $result = \DB::table('result')->where(['match_id'=>$id,'round'=>$round + 1])->first();
        $win = json_decode($result->production_id);
        $pic = Production::where(['match_id'=>$id,'status'=>1])->orderBy('round', 'desc')
                    ->select(DB::raw('productions.*'))
                    ->leftJoin(DB::raw('(select sum, production_id from sum_score) as sumTable'), 'sumTable.production_id', '=', 'productions.id','sumTable.round','=',$round)->orderBy('sum', 'desc')
                    ->Paginate(16);
        return view('admin.match.review.edit',['pic'=>$pic,'kw'=>'','match'=>$res,'type'=>$type,'round'=>$round,'id'=>$id,'win'=>$win]);

    }
    public function badboy(Request $request)
    {
        try {
            $match_id = $request->match_id;
            $round = $request->round;
            $id = $request->id;
            $result = \DB::table('result')->where(['match_id' => $match_id, 'round' => $round +1])->first();
            if(!count($result)) return json_encode(['data'=>'no result ']);
            $arr = json_decode($result->production_id);

            if($request->value == 1) {
                if(!in_array($id,$arr)) {
                    $arr[] = (int) $id;
                    \DB::table('result')->where(['match_id' => $match_id, 'round' => $round +1])->update(['production_id'=>json_encode($arr)]);
                }
            } elseif ($request->value == 2) {
                if(in_array($id,$arr)) {
                    $keys = array_keys($arr, $id); 
                    if(!empty($keys)){  
                        foreach ($keys as $key) {  
                            unset($arr[$key]);  
                        }  
                    }  
                    \DB::table('result')->where(['match_id' => $match_id, 'round' => $round +1])->update(['production_id'=>json_encode($arr)]);
                }
            } else {
                return json_encode(['data'=>'value is not right']);
            }

            return json_encode(['data'=>1]);
            
        } catch (\Exception $e) {
            return json_encode(['data'=>$e->message]);
        }
    }
    public function reset_result(Match $match, $id)
    {
        try {
            $res = $match->find($id);
            $round = $res->round;

            \DB::table('result')->where([
                        'match_id'=>$id,
                        'round'=> ($round + 1),
                        'status'=> 1,
                ])->delete();
            $match->result($id);
            return back();
        } catch (\Exception $e) {
            return back();
        }
    }
    public function get_end_result(Request $request,  $id)
    {
        \DB::table('result')->where([
                    'round' => 0,
                    'match_id' => $id
                    ])->delete();
        $win = \DB::table('win')->where(['match_id'=>$id])->orderBy('no','asc')->get();
        $total = count($win);
        if (!$total) return back()->with('msg','未设置胜出机制');
        $match = Match::find($id);
        if(!count($match)) return back()->with('msg','获取数据失败');
        // 当前进行中的轮次
        $round = $match->round ? $match->round : 1;
        //当前赛事状态
        $status = $match->status;
        
        $review = \DB::table('reviews')->where(['match_id'=>$id,'round'=>$round])->first();
        $type = $review->type;

        $pic = Production::where(['match_id'=>$id,'status'=>1])->orderBy('round', 'desc')
                    ->select(DB::raw('productions.*'))
                    ->leftJoin(DB::raw('(select sum, production_id from sum_score) as sumTable'), 'sumTable.production_id', '=', 'productions.id','sumTable.round','=',$round)->orderBy('sum', 'desc')
                    ->get();
        $arr = [];
        foreach ($pic as $k => $pv) {
            if(in_array($pv->id,$arr)) continue;
            $arr[] = $pv->id;
        }
        $i = 0;
        foreach ($win as $wk=>$wv) {
            $no = [];
            $num = $wv->num;
            if ($num + $i > count($arr) - 1)  continue;

            for ($tag=$i  ; $tag < $num + $i; $tag++) { 
                $no[] = $arr[$tag];
            }
            $res = Production::find($arr[$num + $i - 1]);
            $res2 = Production::find($arr[$num + $i]);

            $score =  (int) $res->admin_score_sum($arr[$num + $i - 1], $round);
            $score2 =  (int) $res->admin_score_sum($arr[$num + $i], $round);

            if($score == $score2) {
                $no[] = $arr[$num + $i];
                $time = 1;
                for ($n=0; $n < count($arr) ; $n++) {
                    if ($num + $i  + $time + 1 > count($arr))  break;
                    $res3 = Production::find($arr[$num + $i  + $time]);

                    $score3 =  (int) $res->admin_score_sum($arr[$num + $i + $time], $round);
                    if($score != $score3) break;
                    $no[] = $arr[$num + $i + $time];
                    $time += 1;
                }
                $i = $i + $num + $time;

            } else {
                $i += $num;
            }
            Production::whereIn('id',$no)->update(['no'=>$wv->no]);
            foreach ($no as $nov) {
                \DB::table('result')->insert([
                    'round' => 0,
                    'match_id' => $id,
                    'production_id' => $nov,
                    'win_id' => $wv->id,
                    'status' => 1,
                    ]);
            }
            
        }

        return redirect()->to('admin/match/edit_win/'.$id);
    }
    public function show_end(Request $request,  $id)
    {
        $match = Match::find($id);
        if(!count($match)) return back()->with('msg','获取数据失败');

        $review = \DB::table('reviews')->where(['match_id'=>$id,'round'=>$match->round])->first();
        $type = $review->type;

        $win = \DB::table('win')->where(['match_id'=>$id])->orderBy('no','asc')->get();
        $pic = [];
        foreach ($win as $wv) {
            $pid = [];
            $res = \DB::table('result')->select('production_id')->where(['match_id'=>$id,'win_id'=>$wv->id])->get();
            if(count($res)) {
                foreach ($res as $value) {
                    $pid[] = $value->production_id;
                }
            }
            $pic[$wv->no] = Production::whereIn('id',$pid)->get();

        }
        return view('admin.match.review.end',['pic'=>$pic,'win'=>$win,'kw'=>'','match'=>$match,'type'=>$type,'id'=>$id]);
    }
    public function end_match(Request $request, Match $match, $id)
    {
        $res = $match->end_match($id);
        return back()->with('msg',$res);
    }
    public function end_result_pdf(Request $request,  $id)
    {
        
        //$win = Production::where(['match_id'=>$id])->get();
        $win = \DB::table('win')->where(['match_id'=>$id])->orderBy('no','asc')->get();
        $pic = [];
        foreach ($win as $wv) {
            $pid = [];
            $res = \DB::table('result')->select('production_id')->where(['match_id'=>$id,'win_id'=>$wv->id])->get();
            if(count($res)) {
                foreach ($res as $value) {
                    $pid[] = $value->production_id;
                }
            }
            $pic[$wv->no] = Production::whereIn('id',$pid)->get();

        }
        foreach ($pic as $key => $value) {
            # code...
        }
        dd($pic);
        //$str = "<html><head><title>Laravel</title><meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\'/><style>body{  font-family: \'msyh\';  }  @font-face {  font-family: \'msyh\';  font-style: normal;  font-weight: normal;  src:url('http://39.108.168.33:7979/fonts/msyh.ttf') format(\'truetype\');  }</style></head><body><div class=\'container\'><div class=\'content\'><p style=\'font-family: msyh, DejaVu Sans,sans-serif;\'>献给母亲的爱</p><div style=\'font-family: msyh, DejaVu Sans,sans-serif;\' class=\'title\'>Laravel 5中文测试</div><div  class=\'title\'>测试三</div></div></div></body></html>";
        $str ='';
        foreach ($win as $wv) {
            $str .= '<div ><img src="'.url($wv->pic).'" style="width:100%;"></div>';
        }

        return PDF::loadHTML($str)->setPaper('a4', 'landscape')->download('赛果.pdf');
    }
    public function edit_win(Request $request,  $id)
    {
        $match = Match::find($id);
        if(!count($match)) return back()->with('msg','获取数据失败');

        $review = \DB::table('reviews')->where(['match_id'=>$id,'round'=>$match->round])->first();
        $type = $review->type;

        $pic = Production::where('match_id',$id)->orderBy('no')->orderBy('round','desc')->Paginate(16);
        //dd($pic);
        return view('admin.match.review.edit_end',['pic'=>$pic,'kw'=>'','match'=>$match,'type'=>$type,'id'=>$id]);
    }
    public function re_review(Request $request, Match $match, $id)
    {
        $res = $match->find($id);
        if(!count($res)) return back()->with('msg','恢复失败');
        $bool = $match->re_review($id,$res->round);
        if($bool) {
            return back()->with('msg','成功恢复本轮评审');
        } else {
            return back()->with('msg','恢复失败');
        }
    }
    public function clear_result(Request $request, Match $match, $id)
    {
        $res = $match->find($id);
        if(!count($res)) return back()->with('msg','清除失败');
        $bool = $match->clear_result($id,$res->round);
        if($bool) {
            return back()->with('msg','成功清除评审数据');
        } else {
            return back()->with('msg','清除失败');
        }
    }
}
