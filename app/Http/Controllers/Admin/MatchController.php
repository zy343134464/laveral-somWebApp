<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SendController as Send;
use App\Admin\Match;
use App\Review;
use PDF;
use App\Production;
use mPDF;

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
        $time = isset($request->time) ? $request->time : 0;

        if($time) {
            $intime = array(0.25 ,1,12);
            if(in_array($time,$intime)) {
                $time = time() - 3600 * 24 * 7 * 30 * $time;
            } elseif($time == 'out') {
                $time = 'out';
            } else {
                $time = 0;
            }
        }

        $res = $match->when(isset($request->kw), function ($query) use ($request) {
            return $query->where('title', 'like', '%'.$request->kw.'%');
        })->when(isset($request->status), function ($query) use ($request) {
            if ($request->status == 1) {
                return $query->where('status', $request->status);
            } else {
                return $query->where('status', $request->status);
            }
        }, function ($query) use ($request) {
            return $query->whereIn('status', [2,3,4,5]);
        })->when(isset($request->cat), function ($query) use ($request) {
            return $query->where('cat', (int) $request->cat);
        }, function ($query) use ($request) {
            return $query->whereIn('cat', [0,1]);
        })->when($time,function ($query) use ($time) {
            if($time == 'out') {
                return $query->where('public_time','<',time() - 3600 * 24 * 7 * 30 * 12);
            }
            return $query->where('public_time','>',$time);
        })->orderBy('id', 'desc')->Paginate(6);

        return view('admin.match.show.block', ['matches'=>$res,'kw'=>$request->kw,'status'=>$request->status,'cat'=>$request->cat]);
    }
   
    /**
     * 查看子赛事
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function show_son(Request $request, Match $match, $id)
    {
        $res = $match->find($id);
        if (!count($res) || $res->cat != 1) {
            return back();
        }

        $son = $match->where('pid', $id)->get();
        return view('admin.match.show.son', ['son'=>$son, 'match'=>$res]);
    }
    
    /**
     * 创建比赛页面
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function create(Request $request, $type)
    {
        if ($type == 1) {
            $type = 1;
        } elseif ($type == 2) {
            $type = 2;
        } else {
            $type = 0;
        }
        $pid = $request->pid ? $request->pid : 0;

        return view('admin.match.create.main', ['type'=>$type, 'pid'=>$pid, ]);
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
        if (is_null($request->title[0]) || is_null($request->detail)) {
            return redirect()->back()->with('msg', '*为必填项,不能为空')->withInput();
        }
        if ($request->pid == 0) {
            if (is_null($request->collect_start)  || is_null($request->collect_end)) {
                return redirect()->back()->with('msg', '*为必填项,不能为空');
            }
        }
        $id = $match->main($request, $type);
        if ($id) {
            if ($type == 2) {
                return redirect('admin/match/review/'.$id);
            } else {
                return redirect('admin/match/partner/'.$id);
            }
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
        $res = $match->mainedit($request, $id);
         
        if ($res == 2) {
            return redirect('admin/match/review/'.$id);
        } elseif ($res === false) {
            return redirect()->back()->with('msg', '修改数据失败...');
        } else {
            return redirect('admin/match/partner/'.$id);
        }
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
        $partner = \DB::table('partners')->where('match_id', $id)->orderBy('no')->get();
        $connection = \DB::table('connections')->where('match_id', $id)->orderBy('no')->get();
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
        if(isset($request->jump) && $request->jump == 1) {

            return redirect('admin/match/rater/'.$id);
        } else {
            return redirect('admin/match/edit/'.$id);
        }
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
        $user = null ;

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
        $award = \DB::table('awards')->where('match_id', $id)->orderBy('no')->get();
        if ($match->get_cat($id) == 2) {
            return back();
        }
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
        if (count($res)) {
            if ($res->cat != 2) {
                if(isset($request->jump) && $request->jump == 1) {

                    return redirect('admin/match/require_personal/'.$id);
                } else {
                    return redirect('admin/match/rater/'.$id);
                }
            }
        }
        return back();
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
        if (!count($res) || $res->cat != 1) {
            return back();
        }

        $son = $match->where(['cat'=> 2,'pid'=>$id])->where('status','!=',7)->orderBy('id')->get();
        return view('admin.match.create.son', ['id'=>$id,'match'=>$res,'son'=>$son]);
    }
    /**
     * copy赛事列表
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function copy_son(Request $request, Match $match, $id)
    {
        $res = $match->copy_son($id);
        return back()->with('msg', $res['msg']);
    }

    /**
     * 个人投稿要求
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function require_personal(Request $request, $id)
    {
        $res = Match::find($id);

        if (!count($res) || $res->cat == 2) {
            return back();
        }
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
        $res = Match::find($id);
        if (!count($res) || $res->cat == 2) {
            return back();
        }

        $match->require_personal($request, $id);
        
        if ($request->jump == 0) {
            return redirect('admin/match/award/'.$id);
        } elseif ($request->jump == 1) {
             if ($res->cat == 0) {
                return redirect('admin/match/review/'.$id);
            }
            return redirect('admin/match/son/'.$id);
        } elseif ($request->jump == 2) {
            return redirect('admin/match/require_team/'.$id);
        } elseif ($request->jump == 3) {
           return back();
        }
        return back();
    }
    
    public function del_personal(Request $request, $id)
    {
        \DB::table('require_personal')->where('match_id', $id)->delete();
        return back()->with('msg', '成功清除数据');
    }
    public function del_team(Request $request, $id)
    {
        \DB::table('require_team')->where('match_id', $id)->delete();
        return back()->with('msg', '成功清除数据');
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
        $res = Match::find($id);

        if (!count($res) || $res->cat == 2) {
            return back();
        }
        
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
        $res = Match::find($id);
        if (!count($res) || $res->cat == 2) {
            return back();
        }

        $match->require_team($request, $id);

        if ($res->cat == 0) {
            if($request->jump == 0) {
                return redirect('admin/match/award/'.$id);
            } elseif($request->jump == 2) {
                return back();
            } else {
                return redirect('admin/match/review/'.$id);
            }
        }
        if($request->jump == 0) return redirect('admin/match/award/'.$id);
        if($request->jump == 2) return back();
        return redirect('admin/match/son/'.$id);
    }
    /**
     * 评审设置
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function review(Request $request, $id)
    {
        $match = Match::find($id);
        $review = Review::where('match_id', $id)->orderBy('round')->get();

        $win = \DB::table('win')->where('match_id', $id)->orderBy('no')->get();

        $pop = \DB::table('popularity')->where('match_id', $id)->first();

        $entime = $match->collect_end;
        $pushtime = $match->public_time;

        if($match->cat == 2) {
            $pmatch = Match::find($match->pid);
            if(count($pmatch)) {
                $entime = $pmatch->collect_end;
                $pushtime = $pmatch->public_time;
                
            }
        }
        

        $end = $entime ? date('Y-m-d H:i', $entime) : '未设置';

        $push = $pushtime ? date('Y-m-d H:i', $pushtime) : '未设置';

        return view('admin.match.create.review', ['id'=>$id, 'review'=>$review,'match'=>$match, 'pop'=>$pop, 'win'=>$win,'end'=>$end, 'push'=>$push]);
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
        $res = $match->find($id);
        if (!count($res)) {
            return back()->with('msg', 'false');
        }
        $result = $match->review($request, $id);
        
        if ($result == 100) {
            return json_encode('维度占比设置不等于100',256);
            return back()->with('msg', '维度占比设置不等于100');
        }
        
        $match->popularity($request, $id);
        $match->win($request, $id);

        return json_encode($result,256);

        if ($request->jump == 0) {
            return back();
        } elseif ($request->jump == 1) {
            if ($res->cat == 2) {
                return redirect()->to('admin/match/son/'.$res->pid);
            } else {
                return redirect()->to('admin/match/showedit/'.$id);
            }
        }
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
        return back()->with('msg', $res['msg']);
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
        return back()->with('msg', $res['msg']);
        // if ($res) {
        //     $msg = '结束征稿';
        // } else {
        //     $msg = '数据错误';
        // }
        return redirect()->to('admin/match/review_room/'.$id)->with('msg', $res['msg']);
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

        
        if (count($num) == $result->round) {
            return redirect()->to('admin/match/get_end_result/'.$id);
        };

        $res = $match->result($id);
        
        if ($res) {
            return back()->with('msg', $res);
        } else {
            return back()->with('msg', 'default');
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

    /**
     * 清除投稿数据
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function back_all_pic(Request $request, $id)
    {
        try {
            $match = Match::find($id);
            if ($match->status == 3) {
                Production::where(['match_id'=>$id,'status'=>2])->update(['status'=>3]);
                return back()->with('msg', '已清除投稿数据');
            } else {
                return back()->with('msg', '非征稿中,不能清除投稿数据');
            }
        } catch (\Exception $e) {
            return back()->with('msg', '未知错误');
        }
    }

    /**
     * 管理员评审室
     * @param  Request    $request    [description]
     * @param  Production $production [description]
     * @param  Match      $mm         [description]
     * @param  [type]     $id         [description]
     * @return [type]                 [description]
     */
    public function review_room(Request $request, Match $mm, Production $production, $id)
    {
        $match = Match::find($id);
        if(!count($match)) return back();
        $man_sum = $match->author_sum($id);
        $pic_sum = $match->production_sum($id);
        $samesum = [];
        if (!count($match)) {
            return back()->with('msg', '获取数据失败');
        }
        // 当前进行中的轮次
        $rounding = $match->round ? $match->round : 1;

        if ($match->cat == 1) {
            return redirect()->to('admin/match/show_son/'.$match->id);
        }
        $sum_round = $match->sum_round($match->id);
        if ($rounding > $sum_round) {
            if($sum_round == 0) {
                return back()->with('msg','未设置评审设定');
            }
            return back();
        }
        // 查看的轮次
        $round = $request->round ? $request->round : $rounding;
        $round =($round > $sum_round) ? $sum_round : $round;

        //当前赛事状态
        $statusing = $match->status;
        if ($statusing == 0) {
            return back()->with('msg', '赛事未发布');
        }
            
        if ($statusing == 3 && !isset($request->status)) {
            return redirect()->to('admin/match/review_room/'.$id.'?status=1');
        }
        
        $status = $request->status;

        $review = \DB::table('reviews')->where(['match_id'=>$id,'round'=>$round])->first();

        $end = \DB::table('reviews')->where(['match_id'=>$id])->count();
        $end = $match->round == $end ? 1 : 0;

        $promotion = $review->promotion;
        $type = $review->type;

        if ($type == 2) {
            $temp = json_decode($review->setting, true);
            $dimension = $temp['dimension'];
        } else {
            $dimension = [];
        }
        if($status == 1) {
            $time = $match->collect_end - time();
            $time = $this->secsToStr($time);
        } else {
            \DB::table('reviews')->where(['match_id'=>$id])->get();
            $time = $review->end_time - time();
            $time = $this->secsToStr($time);
        }
        if ((int) $request->dimension) {
            $dimen = (int)$request->dimension - 1;
            if ($dimen > count($dimension)) {
                $select = 'sum';
            } else {
                $select = 'p'.$dimen;
            }
        } else {
            $select = 'sum';
        }
        if ($request->sort == 1) {
            $sort = 'asc';
        } else {
            $sort = 'desc';
        }
        if (isset($request->kw)) {
            $kw = $request->kw;
        } else {
            $kw = false;
        }

        $cat = 'all';
        if (isset($request->cat)) {
            if ($request->cat == 2) {
                $cat = 1;
            } elseif ($request->cat == 1) {
                $cat = 0;
            } else {
                $cat = 'all';
            }
        }
        //$time = 9999;
        if ($status == 1) {
            //征稿中
            $pic = $production->where(['match_id'=> $id,'status'=>2])->when($cat != 'all', function ($query) use ($cat) {
                return $query->where('cat', $cat);
            })->when($kw !== false, function ($query) use ($kw) {
                //关键词搜索未测试,未知
                return $query->where('title', 'like', '%'.$kw.'%');
            })->Paginate(16);
        } elseif ($status == 3) {
            $end = \DB::table('result')->where(['match_id'=>$id,'round'=>0])->get();
            if (count($end)) {
                return redirect()->to('admin/match/show_end/'.$id);
            } else {
                return back();
            }
        } else {
            if (($statusing == 2 || $statusing == 3 || $statusing == 4) && $match->collect_end < time()) {
                //征稿中
                $pic = $production->where(['match_id'=> $id,'status'=>2])->when($cat != 'all', function ($query) use ($cat) {
                return $query->where('cat', $cat);
            })->Paginate(16);
            } else {
                $result = \DB::table('result')->when($round, function ($query) use ($id, $round) {
                    return $query->where(['match_id'=>$id, 'status'=>1, 'round'=>$round]);
                }, function ($query) use ($id, $rounding) {
                    return $query->where(['match_id'=>$id, 'status'=>1, 'round'=>$rounding]);
                })->orderBy('round', 'desc')->first();

                if (count($result)) {
                    $arr = json_decode($result->production_id, true);
                } else {
                    $arr =[];
                }
                // $pic = Production::whereIn('id', $arr)->select(DB::raw('productions.*'))
                //     ->leftJoin(DB::raw('(select sum, production_id from sum_score) as sum'), 'sum.production_id', '=', 'productions.id', 'sum.round', '=', $round)
                //     ->orderByRaw('sum desc')->Paginate(16);

                // $pic_all = Production::where('match_id', $id)
                //     ->whereIn('id', $arr)->select(DB::raw('productions.*'))
                //     ->leftJoin(DB::raw('(select sum, production_id from sum_score) as sum'), 'sum.production_id', '=', 'productions.id', 'sum.round', '=', $round)
                //     ->orderByRaw('sum desc')->get();

                // $pic = Production::whereIn('id',$arr)->whereHas('get_sum', function ($query) use($round) {
                //         $query->where('round',$round)->orderBy('sum','desc');
                //         //$query->orderBy('sum','desc');
                //     })->Paginate(8);
                // $pic = Production::select('productions.*','sum_score.*')
                //                 ->where('productions.match_id',$id)
                //                 ->leftJoin('sum_score',[['sum_score.production_id','=','productions.id']])->orderBy('sum_score.sum','desc')->Paginate(16);
                

                $pic = Production::select('productions.id', 'productions.pic', 'productions.title', 'sum_score.sum', 'sum_score.p0', 'sum_score.p1', 'sum_score.p2', 'sum_score.p3', 'sum_score.p4', 'sum_score.p5', 'sum_score.p6', 'sum_score.p7', 'sum_score.p8', 'sum_score.p9')->whereIn('productions.id', $arr)->leftJoin('sum_score', function ($query) use ($round) {
                    $query->on('productions.id', 'sum_score.production_id')->where('sum_score.round', $round);
                })->orderBy('sum_score.'.$select, $sort)->when($cat != 'all', function ($query) use ($cat) {
                    return $query->where('productions.cat', $cat);
                })->Paginate(16);
                //dd($arr,$pic);
                // 获取同分
                if ($end) {
                    $num = 0;
                    $win = \DB::table('win')->where('match_id', $id)->orderBy('no')->get();

                    if (count($win)) {
                        foreach ($win as $wv) {
                            $num += $wv->num;
                            $md = Production::whereIn('productions.id', $arr)->leftJoin('sum_score', function ($query) {
                                $query->on('productions.id', 'sum_score.production_id')->where('sum_score.round', 1);
                            })->orderBy('sum_score.sum', 'desc')->skip($num - 1)->take(1)->get();

                            $md2 = Production::whereIn('productions.id', $arr)->leftJoin('sum_score', function ($query) use ($round) {
                                $query->on('productions.id', 'sum_score.production_id')->where('sum_score.round', $round);
                            })->orderBy('sum_score.sum', 'desc')->skip($num)->take(1)->get();
                            if (count($md) && count($md2)) {
                                if ($md[0]->sum == $md2[0]->sum) {
                                    $samesum[] = $md[0]->sum;
                                }
                            }
                        }
                    }
                } else {
                    $md = Production::whereIn('productions.id', $arr)->leftJoin('sum_score', function ($query) {
                        $query->on('productions.id', 'sum_score.production_id')->where('sum_score.round', 1);
                    })->orderBy('sum_score.sum', 'desc')->skip($promotion - 1)->take(1)->get();

                    $md2 = Production::whereIn('productions.id', $arr)->leftJoin('sum_score', function ($query) use ($round) {
                        $query->on('productions.id', 'sum_score.production_id')->where('sum_score.round', $round);
                    })->orderBy('sum_score.sum', 'desc')->skip($promotion)->take(1)->get();
                    if (count($md) && count($md2)) {
                        if ($md[0]->sum == $md2[0]->sum) {
                            $samesum[] = $md[0]->sum;
                        }
                    }
                }
            }
        }
        $rater = \DB::table('rater_match')->select('rater_match.total', 'rater_match.finish', 'users.name')->leftJoin('users', function ($query) {
            return $query->on('rater_match.user_id', 'users.id');
        })->where(['rater_match.match_id'=>$id,'rater_match.round'=>$round])->get();

        $same = json_encode($samesum);
        return view('admin.match.review.review', ['status'=>$statusing,'statusing'=>$status,'pic'=>$pic,'kw'=>'','match'=>$match,'rounding'=>$rounding,'round'=>$round,'type'=>$type,'id'=>$id,'time'=>$time,'same'=>$same,'rater'=>$rater,'dimension'=>$dimension,'wdselect'=>(int) $request->dimension,'cat'=>$cat,'man_sum'=>$man_sum,'pic_sum'=>$pic_sum]);
    }
    /**
     * 时间戳转时分秒
     * @param  [type] $times [description]
     * @return [type]        [description]
     */
    public function secsToStr($times)
    {
        $result = '00:00:00';
        if ($times>0) {
            $hour = floor($times/3600);
            $minute = floor(($times-3600 * $hour)/60);
            $second = floor((($times-3600 * $hour) - 60 * $minute) % 60);
            $result = $hour.'小时'.$minute.'分'.$second.'秒';
        }
        return $result;
    }
    /**
     * 编辑赛果
     * @param  Production $production [description]
     * @param  Match      $match      [description]
     * @param  [type]     $id         [description]
     * @return [type]                 [description]
     */
    public function edit_result(Request $request, Production $production, Match $match, $id)
    {
        $res = $match->find($id);
        $round = $res->round;

        $cat = 'all';
        if (isset($request->cat)) {
            if ($request->cat == 2) {
                $cat = 1;
            } elseif ($request->cat == 1) {
                $cat = 0;
            } else {
                $cat = 'all';
            }
        }
        $select = 0;
        if(isset($request->select)) {
            $select = (int)$request->select;  
        }

        $review = \DB::table('reviews')->where(['match_id'=>$id,'round'=>$round])->first();

        $type = $review->type;
        //入围名额
        $promotion = $review->promotion;

        $result = \DB::table('result')->where(['match_id'=>$id,'round'=>$round + 1])->first();
        $arr = json_decode($result->production_id, true);
        //入围人数
        
        $in = count($arr);

        $win = json_decode($result->production_id, true);

        $pic = Production::select('productions.id', 'productions.pic', 'productions.title', 'productions.author', 'sum_score.sum', 'sum_score.p0', 'sum_score.p1', 'sum_score.p2', 'sum_score.p3', 'sum_score.p4', 'sum_score.p5', 'sum_score.p6', 'sum_score.p7', 'sum_score.p8', 'sum_score.p9');
        $pic = $pic->when($cat != 'all',function($query) use ($cat) {
            return $query->where('productions.cat',$cat);
        });
        $pic = $pic->when($select,function($query) use ($select,$arr) {
            if($select == 1) {
                return $query->whereIn('productions.id',$arr);
            } else {
                return $query->whereNotIn('productions.id',$arr);
            }
        });

        $pic = $pic->where('productions.match_id', $id)->leftJoin('sum_score', function ($query) use ($round) {
            $query->on('productions.id', 'sum_score.production_id')->where('sum_score.round', $round);
        })->orderBy('sum_score.sum', 'desc')->orderBy('productions.id')->Paginate(16);

        $promotion1 = Production::select('productions.id', 'productions.pic', 'productions.title', 'sum_score.sum', 'sum_score.p0', 'sum_score.p1', 'sum_score.p2', 'sum_score.p3', 'sum_score.p4', 'sum_score.p5', 'sum_score.p6', 'sum_score.p7', 'sum_score.p8', 'sum_score.p9')->where('productions.match_id', $id)->leftJoin('sum_score', function ($query) use ($round) {
            $query->on('productions.id', 'sum_score.production_id')->where('sum_score.round', $round);
        })->orderBy('sum_score.sum', 'desc')->skip($promotion - 1)->take(1)->get();

        $promotion2 = Production::select('productions.id', 'productions.pic', 'productions.title', 'sum_score.sum', 'sum_score.p0', 'sum_score.p1', 'sum_score.p2', 'sum_score.p3', 'sum_score.p4', 'sum_score.p5', 'sum_score.p6', 'sum_score.p7', 'sum_score.p8', 'sum_score.p9')->where('productions.match_id', $id)->leftJoin('sum_score', function ($query) use ($round) {
            $query->on('productions.id', 'sum_score.production_id')->where('sum_score.round', $round);
        })->orderBy('sum_score.sum', 'desc')->skip($promotion)->take(1)->get();

        //同分
        $same = [];
        if(count($promotion1) && count($promotion2)) {
            if($promotion1[0]['sum'] == $promotion2[0]['sum']) {
                if($type == 1) {

                    $same[] = $promotion1[0]['sum'];
                } else {
                    $same[] = $promotion1[0]['sum'] / 100;
                }
            }
        }

        $same = json_encode($same);

        //剩余时间
        $time = $review->end_time - time();
        $time = $this->secsToStr($time);


        return view('admin.match.review.edit', ['pic'=>$pic,'kw'=>'','match'=>$res,'type'=>$type,'round'=>$round,'id'=>$id,'win'=>$win,'same'=>$same,'promotion'=>$promotion,'in'=>$in,'time'=>$time]);
    }
    /**
     * ajax修改赛果
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function badboy(Request $request)
    {
        try {
            $match_id = $request->match_id;
            $round = $request->round;
            $id = $request->id;

            $result = \DB::table('result')->where(['match_id' => $match_id, 'round' => $round +1])->first();
            if (!count($result)) {
                return json_encode(['data'=>'no result ']);
            }
            $arr = json_decode($result->production_id, true);

            if ($request->value == 1) {
                if (!in_array($id, $arr)) {
                    $arr[] = (int) $id;
                    \DB::table('result')->where(['match_id' => $match_id, 'round' => $round +1])->update(['production_id'=>json_encode($arr)]);
                }
            } elseif ($request->value == 2) {
                if (in_array($id, $arr)) {
                    $keys = array_keys($arr, $id);
                    if (!empty($keys)) {
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
   
    /**
     * 重置赛果
     * @param  Match  $match [description]
     * @param  [type] $id    [description]
     * @return [type]        [description]
     */
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
    /**
     * 套用胜出机制
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function get_end_result(Request $request, $id)
    {
        try {
            \DB::beginTransaction();
           
            \DB::table('result')->where([
                        'round' => 0,
                        'match_id' => $id
                        ])->delete();
            $win = \DB::table('win')->where(['match_id'=>$id])->orderBy('no', 'asc')->get();

            if (!count($win)) {
                return back()->with('msg', '未设置胜出机制');
            }

            $match = Match::find($id);
            \DB::table('result')->where(['match_id'=>$id,'round'=>0])->delete();
            $result = \DB::table('result')->where('match_id',$id)->get();
            foreach ($result as  $rv) {
                \DB::table('productions')->whereIn('id',json_decode($rv->production_id,true))->update(['round'=>$rv->round]);
            }
            
            if (!count($match)) {
                return back()->with('msg', '获取数据失败');
            }
            // 当前进行中的轮次
            $round = $match->round ? $match->round : 1;
            $pic = Production::select('productions.id','sum_score.sum')->where(['productions.match_id'=> $id,'productions.status'=>2,'productions.round'=>$round])->leftJoin('sum_score', function ($query) use ($round) {
                    $query->on('productions.id', 'sum_score.production_id')->where('sum_score.round', $round);
                })->orderBy('sum_score.sum', 'desc')->orderBy('productions.id')->get();
            $arr = [];
            foreach ($pic as $pv) {
                $arr[$pv->sum ? $pv->sum : 0][] = $pv->id;
            }
            krsort($arr);

            foreach ($win as $wv) {
                $temp = array_shift($arr);
                if(!count($temp)) break;
                for ($i=0; 1; $i) {
                    $num = count($temp);
                    if ($num == 0 || $num >= $wv->num) {
                        break;
                    }
                    $temp2 = array_shift($arr);
                    if (count($temp2) == 0) {
                        break;
                    }
                    foreach ($temp2 as $tv) {
                        $temp[] = $tv;
                    }
                }
                Production::whereIn('id', $temp)->update(['round'=>$round + 1,'no'=>$wv->no]);
                foreach ($temp as $value) {
                    DB::table('result')->insert([
                        'production_id' => $value,
                        'match_id' => $id,
                        'win_id'=>$wv->id,
                        ]);
                }
            }
            \DB::commit();
            return redirect()->to('admin/match/edit_win/'.$id);
        } catch (\Exception $e) {
            \DB::rollback();
            dd($e);
            return back()->with('msg', '未知错误');
        }
    }
    /**
     * 编辑赛果
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function edit_win(Request $request, $id)
    {
        $match = Match::find($id);
        if (!count($match)) {
            return back()->with('msg', '获取数据失败');
        }
        if(isset($request->no)) {
            $no = (int)$request->no;
        } else {
            $no = 0;
        }
        $review = \DB::table('reviews')->where(['match_id'=>$id,'round'=>$match->round])->first();

        $win = \DB::table('win')->where(['match_id'=>$id])->orderBy('no')->get();
        
        $type = $review->type;
        $round = Production::where(['match_id'=>$id,'status'=>2])->max('round') - 1;

        if($no) {
            $arr = \DB::table('result')->select('production_id')->where(['match_id'=>$id,'win_id'=>$no])->get();
            if(count($arr)) {
                $arr = $arr->toArray();
            }
            $temp = [];
            foreach ($arr as $av) {
                $temp[] = $av->production_id;
            }
            $pic = Production::whereIn('id', $temp)->orderBy('no')->orderBy('round', 'desc')->orderBy('id')->Paginate(16);

        } else {

            $pic = Production::where('match_id', $id)->orderBy('no')->orderBy('round', 'desc')->orderBy('id')->Paginate(16);
        }

        $same = [];
        if(count($win)) {
            foreach ($win as $wv) {
                $count = \DB::table('result')->where('match_id', $id)->where('win_id',$wv->id)->count();
                if($count > $wv->num) {
                    $same[] = $wv->name;
                }
            }
        }
        $same = json_encode($same,JSON_UNESCAPED_UNICODE);

        $time = $review->end_time - time();
        $time = $this->secsToStr($time);

        return view('admin.match.review.edit_end', ['pic'=>$pic,'kw'=>'','match'=>$match,'type'=>$type,'round'=>$round,'id'=>$id,'win'=>$win,'same'=>$same,'time'=>$time]);
    }
    /**
     * 展示赛果
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function show_end(Request $request, $id)
    {
        $match = Match::find($id);
        if (!count($match)) {
            return back()->with('msg', '获取数据失败');
        }

        $review = \DB::table('reviews')->where(['match_id'=>$id,'round'=>$match->round])->first();
        $type = $review->type;

        $win = \DB::table('win')->where(['match_id'=>$id])->orderBy('no', 'asc')->get();

        $pic = [];
        foreach ($win as $wv) {
            $pid = [];
            $res = \DB::table('result')->select('production_id')->where(['match_id'=>$id,'win_id'=>$wv->id])->get();
            if (count($res)) {
                foreach ($res as $value) {
                    $pid[] = $value->production_id;
                }
            }
            $pic[$wv->no] = Production::whereIn('id', $pid)->get();
        }

        return view('admin.match.review.end', ['pic'=>$pic,'win'=>$win,'kw'=>'','match'=>$match,'type'=>$type,'id'=>$id]);
    }
    /**
     * 结束赛事
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function end_match(Request $request, Match $match, $id)
    {
        $res = $match->end_match($id);
        return back()->with('msg', $res);
    }
    /**
     * 导出赛果pdf
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function end_result_pdf(Request $request, $id)
    {
        $mat = Match::find($id);
        $html ='';
        $win = \DB::table('win')->where(['match_id'=>$id])->orderBy('no', 'asc')->get();
        $pic_only = isset($request->pic);
        $mini = isset($request->mini) ? '300px' : '100%';

        foreach ($win as $wv) {
            $html .= '<h1>'.$wv->name.'</h1>';
            $pid = [];
            $res = \DB::table('result')->select('production_id')->where(['match_id'=>$id,'win_id'=>$wv->id])->get();
            if (count($res)) {
                foreach ($res as $value) {
                    $pid[] = $value->production_id;
                }
                $product = Production::whereIn('id', $pid)->get();
                if ($pic_only) {
                    //仅导出图片
                    foreach ($product as $pv) {
                        if ($pv->type == 1) {
                            $arr = json_decode($pv->pic, true);
                            if ($arr) {
                                foreach ($arr as $key => $value) {
                                    $html .= '<div style="width:'.$mini.';"><h3></h3><img src="'.public_path($value).'"></div>';
                                }
                            }
                        } else {
                            $html .= '<div style="width:'.$mini.';"><h3></h3><img src="'.public_path($pv->pic).'"></div>';
                        }
                    }
                } else {
                    //导出数据加图片
                    foreach ($product as $pv) {
                        if ($pv->type == 1) {
                            $arr = json_decode($pv->pic, true);
                            if ($arr) {
                                foreach ($arr as $key => $value) {
                                    $title = $pv->title != '' ? $pv->title.'(组图)__'.($key +1) : '未命名(组图)';
                                    $html .=  '<div style="width:'.$mini.';border:1px solid black;"><h3>'.$title.'</h3><img src="'.public_path($value).'"><br>作者:'.$pv->author.'<br>详情:'.$pv->detail.'<br><br></div><br><br>';
                                }
                            }
                        } else {
                            $title = $pv->title != '' ? $pv->title : '未命名';
                            $html .= '<div style="width:'.$mini.';border:1px solid black;"><h3>'.$title.'</h3><img src="'.public_path($pv->pic).'"><br>作者:'.$pv->author.'<br>详情:'.$pv->detail.'<br><br></div><br><br>';
                        }
                    }
                }
            } else {
                $html .= '<div ><h3>无</h3></div>';
            }
        }
        $mpdf=new mPDF('utf-8', 'A3');
        $mpdf->useAdobeCJK = true;
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->h2toc = array('H3'=>0,'H4'=>1,'H5'=>2);
        $mpdf->h2bookmarks = array('H3'=>0,'H4'=>1,'H5'=>2);
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($html);
        $mpdf->AddPage();
        $fileName = json_decode($mat->title)[0] .'赛果.pdf';
        $mpdf->Output($fileName, 'D'); //'I'表示在线展示 'D'则显示下载窗口
        exit;
    }
    /**
     * 导出赛事图片pdf
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function match_pic_pdf(Request $request, $id)
    {
        $mat = Match::find($id);
        $html ='<h1>'.json_decode($mat->title)[0].'</h1>';

        if (isset($request->round)) {
            $result = \DB::table('result')->where(['match_id'=>$id, 'round'=>(int) $request->round])->first();
            $product = Production::whereIn('id', json_decode($result->production_id, true))->get();
        } else {
            $product = Production::where(['match_id'=>$id, 'status'=>2])->get();
        }
        
        $pic_only = isset($request->pic);
        $mini = isset($request->mini) ? '300px' : '100%';
        
        if (count($product)) {
            if ($pic_only) {
                //仅导出图片
                foreach ($product as $pv) {
                    if ($pv->type == 1) {
                        $arr = json_decode($pv->pic, true);
                        if ($arr) {
                            foreach ($arr as $key => $value) {
                                $html .= '<div style="width:'.$mini.';"><h3></h3><img src="'.public_path($value).'"></div>';
                            }
                        }
                    } else {
                        $html .= '<div style="width:'.$mini.';"><h3></h3><img src="'.public_path($pv->pic).'"></div>';
                    }
                }
            } else {
                //导出图片加数据
                foreach ($product as $pv) {
                    if ($pv->type == 1) {
                        $arr = json_decode($pv->pic, true);
                        if ($arr) {
                            foreach ($arr as $key => $value) {
                                $title = $pv->title != '' ? $pv->title.'(组图)__'.($key +1)  : '未命名(组图)';
                                $html .= '<div style="width:'.$mini.';border:1px solid black;"><h3>'.$title.'</h3><img src="'.public_path($value).'"><br>作者:'.$pv->author.'<br>详情:'.$pv->detail.'<br><br></div><br><br>';
                            }
                        }
                    } else {
                        $title = $pv->title != '' ? $pv->title : '未命名';
                        $html .= '<div style="width:'.$mini.';border:1px solid black;"><h3>'.$title.'</h3><img src="'.public_path($pv->pic).'"><br>作者:'.$pv->author.'<br>详情:'.$pv->detail.'<br><br></div><br><br>';
                    }
                }
            }
        } else {
            $html .= '<div ><h3>无数据</h3></div>';
        }
        $mpdf=new mPDF('utf-8', 'A3');
        $mpdf->useAdobeCJK = true;
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->h2toc = array('H3'=>0,'H4'=>1,'H5'=>2);
        $mpdf->h2bookmarks = array('H3'=>0,'H4'=>1,'H5'=>2);
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($html);
        $mpdf->AddPage();
        $fileName = json_decode($mat->title)[0] .'.pdf';
        $mpdf->Output($fileName, 'D'); //'I'表示在线展示 'D'则显示下载窗口
        exit;
    }
    public function match_user_excel(Request $request, $id)
    {
        try {
            $match = Match::find($id);
            $title = json_decode($match->title)[0];
            $data = [['投稿作品标题','投稿用户名','电话','电子邮箱']];

            if (isset($request->round)) {
                $result = \DB::table('result')->where(['match_id'=>$id, 'round'=>(int) $request->round])->first();

                $product = Production::select('productions.title','productions.user_id','users.id','productions.pic','users.name','users.phone','users.email')->whereIn('productions.id', json_decode($result->production_id, true))->leftJoin('users',function ($query) {
                        $query->on('productions.user_id','users.id');
                    })->get();

            } else {
                if($match->round != 0) {
                    $result = \DB::table('result')->where(['match_id'=>$id, 'round'=>(int) $match->round])->first();

                    $product = Production::select('productions.title','productions.user_id','users.id','productions.pic','users.name','users.phone','users.email')->whereIn('productions.id', json_decode($result->production_id, true))->leftJoin('users',function ($query) {
                            $query->on('productions.user_id','users.id');
                        })->get();
                } else {
                    $product = Production::select('productions.title','productions.user_id','users.id','productions.pic','users.name','users.phone','users.email')->where('productions.stats', 2)->leftJoin('users',function ($query) {
                            $query->on('productions.user_id','users.id');
                        })->get();
                }
            }
            foreach ($product as $pv) {
                $temp = [];
                $temp[] = $pv->title;
                $temp[] = $pv->name;
                $temp[] = $pv->phone;
                $temp[] = $pv->email;
                $data[] = $temp;
            }

            $this->downloadExcel($data, $title); 
        } catch (\Exception $e) {
            return back()->with('msg','false');
        }
    }
    /**
     * 导出Excel
     * @param  [type] $request [description]
     * @param  [type] $id      [description]
     * @return [type]          [description]
     */
    public function end_result_excel(Request $request, $id)
    {
        try {
            $match = Match::find($id);
            $title = json_decode($match->title)[0];
            $data = [['奖项','作品标题','作品作者','组图/单张','作品详情','下载链接']];
            $win = \DB::table('win')->where(['match_id'=>$id])->orderBy('no', 'asc')->get();

            foreach ($win as $wv) {
                $res = \DB::table('result')->select('production_id')->where(['match_id'=>$id,'win_id'=>$wv->id])->get();
                if (count($res)) {
                    foreach ($res as $value) {
                        $pid[] = $value->production_id;
                    }
                    $product = Production::whereIn('id', $pid)->get();
                    foreach ($product as $pv) {
                        $temp = [];
                        if ($pv->type == 1) {
                            $arr = json_decode($pv->pic, true);
                            if ($arr) {
                                $temp[] = $wv->name;
                                $temp[] = $pv->title;
                                $temp[] = $pv->author;
                                $temp[] = '组图';
                                $temp[] = $pv->detail;
                                $url = '';

                                foreach ($arr as $urlv) {
                                    $url .= url($urlv) . '   ';
                                }
                                $temp[] = $url;
                            }
                        } else {
                            $temp[] = $wv->name;
                            $temp[] = $pv->title;
                            $temp[] = $pv->author;
                            $temp[] = '单张';
                            $temp[] = $pv->detail;
                            $temp[] = url($pv->pic);
                        }
                        $data[] = $temp;
                    }
                }
            }
            $this->downloadExcel($data, $title);
        } catch (\Exception $e) {
            return back()->with('msg','false');
        }
    }
    /**
     * 导出赛果参赛用户个人信息
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function end_user_excel(Request $request, $id)
    {
        try {
            $match = Match::find($id);
            $title = json_decode($match->title)[0];
            $data = [['奖项','作品标题','投稿用户名','电话','电子邮箱']];
            $win = \DB::table('win')->where(['match_id'=>$id])->orderBy('no', 'asc')->get();
            foreach ($win as $wv) {
                $res = \DB::table('result')->select('production_id')->where(['match_id'=>$id,'win_id'=>$wv->id])->get();
                if (count($res)) {
                    foreach ($res as $value) {
                        $pid[] = $value->production_id;
                    }
                    $product = Production::select('productions.title','productions.user_id','users.id','productions.pic','users.name','users.phone','users.email')->whereIn('productions.id', $pid)->leftJoin('users',function ($query) {
                        $query->on('productions.user_id','users.id');
                    })->get();
                    foreach ($product as $pv) {
                        $temp = [];
                        $temp[] = $wv->name;
                        $temp[] = $pv->title;
                        $temp[] = $pv->name;
                        $temp[] = $pv->phone;
                        $temp[] = $pv->email;
                        $data[] = $temp;
                    }
                }
            }
            $this->downloadExcel($data, $title);
        } catch (\Exception $e) {
            return back()->with('msg','false');
        }
    }
    /**
     * 导出Excel
     * @param  [type] $request [description]
     * @param  [type] $id      [description]
     * @return [type]          [description]
     */
    public function match_pic_excel(Request $request, $id)
    {
        try {
            $match = Match::find($id);
            $title = json_decode($match->title)[0];
            $data = [['作品标题','作品作者','组图/单张','作品详情','下载链接']];
            if (isset($request->round)) {
                $result = \DB::table('result')->where(['match_id'=>$id, 'round'=>(int) $request->round])->first();
                $product = Production::whereIn('id', json_decode($result->production_id, true))->get();
            } else {
                $product = Production::where(['match_id'=>$id, 'status'=>2])->get();
            }

           
            if (count($product)) {
                foreach ($product as $pv) {
                    $temp = [];
                    if ($pv->type == 1) {
                        $arr = json_decode($pv->pic, true);
                        if ($arr) {
                            $temp[] = $pv->title;
                            $temp[] = $pv->author;
                            $temp[] = '组图';
                            $temp[] = $pv->detail;
                            $url = '';

                            foreach ($arr as $urlv) {
                                $url .= url($urlv);
                            }
                            $temp[] = $url;
                        }
                    } else {
                        $temp[] = $pv->title;
                        $temp[] = $pv->author;
                        $temp[] = '单张';
                        $temp[] = $pv->detail;
                        $temp[] = url($pv->pic);
                    }
                    $data[] = $temp;
                }
            }

            $this->downloadExcel($data, $title);
        } catch (\Exception $e) {
            return back()->with('msg','false');
        }
    }
    
    /**
     * ajax修改最后一轮赛果
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function edit_win_ajax(Request $request)
    {
        try {
            $res  = \DB::table('productions')->where(['id'=>$request->production_id])->first();
            $match_id = $res->match_id;

            \DB::table('result')->where(['production_id'=>$request->production_id])->delete();
            if (is_array($request->win_id)) {
                
                $a = '';
                foreach ($request->win_id as $win_id) {
                    $a.= $win_id;
                    \DB::table('result')->insert(['production_id'=>$request->production_id, 'win_id'=>$win_id, 'match_id'=>$match_id]);
                }
                return json_encode([$a]);
            }

            return  json_encode([0]);
        } catch (\Exception $e) {
            return json_encode($win_id);
            return  json_encode([3]);
        }
    }
    /**
     * 恢复本轮评审
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function re_review(Request $request, Match $match, $id)
    {
        $res = $match->find($id);
        if (!count($res)) {
            return back()->with('msg', '恢复失败');
        }
        $bool = $match->re_review($id, $res->round);
        if ($bool) {
            return back()->with('msg', '成功恢复本轮评审');
        } else {
            return back()->with('msg', '恢复失败');
        }
    }
    /**
     * 清除评审数据
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function clear_result(Request $request, Match $match, $id)
    {
        $res = $match->find($id);
        if (!count($res)) {
            return back()->with('msg', '清除失败');
        }
        $bool = $match->clear_result($id, $res->round);
        if ($bool) {
            return back()->with('msg', '成功清除评审数据');
        } else {
            return back()->with('msg', '清除失败');
        }
    }
    /**
     * 获取图片
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function img(Request $request, $id)
    {
        $res = Production::find($id);
        if (count($res)) {
            return json_encode($res);
        }
        return false;
    }
    /**
     * 普通用户获取图片
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function img_user(Request $request, Production $production, $id)
    {
        $info = $production->info($id);
        return json_encode($info);
    }
    /**
     * 在赛果页ajax添加奖项
     * @param Request $request [description]
     */
    public function add_award(Request $request)
    {
        try {
            $mid = $request->match_id;
            $name = $request->name;
            $no = \DB::table('win')->where('match_id', $mid)->count();
            $win_id = \DB::table('win')->insertGetId(['match_id'=>$mid, 'name'=>$name, 'no'=>$no + 1,'num'=>1]);
            if ($win_id) {
                $data = ['data'=>$win_id, 'status'=>true];
                return json_encode($data, 256);
            }
            throw new \Exception("创建失败");
        } catch (\Exception $e) {
            return json_encode(['data'=>'', 'status'=>false], 256);
        }
    }
    public function push_result(Request $reuqest, $id)
    {
        try {
            \DB::table('information')->where('match_id',$id)->delete();
            $match = Match::find($id);
            $title = json_decode($match->title);
            $title = $title[0] . '赛果公布';

            \DB::table('information')->insert([
                                'title' => $title,
                                'type' => 1,
                                'match_id' => $id,
                                'detail' => '',
                                'created_at' => date('Y-m-d H:i:s',time())
                            ]);
            return back()->with('msg','赛果已公布');
        } catch (\Exception $e) {
            dd($e);
            return back()->with('msg','false');
        }
    }
}
