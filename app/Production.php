<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $table = 'productions';

    public function match()
    {
        return $this->belongsTo('App\Admin\Match');
    }
    public function sum_score($id, $round)
    {
        $res = \DB::table('sum_score')->where(['production_id'=>$id,'round'=>$round])->first();
        return @$res->sum;
    }
    public function score($mid, $round, $id, $uid = '')
    {
        if(!$uid)  $uid = user('id');
        $res = \DB::table('score')->where([
            'production_id'=>$id, 
            'match_id'=>$mid, 
            'round'=>$round, 
            'rater_id'=>$uid, 
            ])->get();

        if(count($res)) {
            return $res[0]->res;
        } else {
            return false;
        }
    }
    public function admin_score_sum($id, $round)
    {
        $res = \DB::table('sum_score')->where(['production_id'=>$id,'round'=>$round])->first();
        if(count($res)) {
            return $res->sum / ($res->sum_rater ? $res->sum_rater : 1) ;
        } else {
            return 0;
        }
        
    }

    public function rater_score_sum($mid, $round, $id, $uid = '')
    {
        if(!$uid)  $uid = user('id');
        $res = \DB::table('score')->where([
            'production_id'=>$id, 
            'match_id'=>$mid, 
            'round'=>$round, 
            'rater_id'=>$uid, 
            ])->get();

        if(count($res)) {
            return $res[0]->sum;
        } else {
            return false;
        }
    }
    public function review($request, $type = 1)
    {
        try {
            // 过滤
            if(!$request->id || !$request->match_id ||!$request->round  ) {
                if($request->type == 1 && !$request->value) {
                    return ['data'=>false,'msg'=>'数据请求失败'];
                } else {
                    if(!$request->res) return ['data'=>false,'msg'=>'数据请求失败'];
                }
                
            }
            // 赛事轮次审核
            $match = \DB::table('matches')->find($request->match_id);

            if ((int) (@$match->round) < $request->round) {

                return ['data'=>false,'msg'=>'尚未开始第'.$request->round.'轮评审'];

            } elseif ((int) (@$match->round) > $request->round) {

                return ['data'=>false,'msg'=>'评审已结束'];
            }
            // 旧记录
            $old = \DB::table('score')->where([
                'match_id'=>$request->match_id, 
                'production_id'=>$request->id, 
                'round'=>$request->round,
                'rater_id'=>user('id'),
                ])->get();
            if(count($old)) {
                if($old[0]->res == $request->res) {

                    return ['data'=>true,'msg'=>'success without ed'];
                }
                $old_value = $old[0]->res;
                $old_sum = $old[0]->sum;
            } else {
                $old_value = 0;
                $old_sum = 0;
            }
            //删除旧记录
            \DB::table('score')->where([
                'match_id'=>$request->match_id, 
                'production_id'=>$request->id, 
                'round'=>$request->round,
                'rater_id'=>user('id'),
                ])->delete();

            // 写入新记录
            if($request->type == 2) {
                $reviews = \DB::table('reviews')->where(['match_id'=>$request->match_id, 'round'=>$request->round])->first(); 
                $percent = (json_decode($reviews->setting,true))['percent'];
                $score = [];
                $total = 0;
                foreach ($percent as $key => $value) {
                    $score[$key] = $value * json_decode($request->res)[$key] ;
                    $total += $value * json_decode($request->res)[$key] ;
                }
                \DB::table('score')->insert([
                    'match_id'=>$request->match_id, 
                    'production_id'=>$request->id, 
                    'round'=>$request->round, 
                    'rater_id'=>user('id'), 
                    'res'=>json_encode($score),
                    'sum'=>$total
                    ]);
                // 总分表数据处理
                $res = \DB::table('sum_score')->where([
                        'match_id'=>$request->match_id, 
                        'production_id'=>$request->id, 
                        'round'=>$request->round,
                    ])->get();
                if(count($res)) {
                    if(count($old)) {
                        \DB::table('sum_score')->where([
                            'match_id'=>$request->match_id, 
                            'production_id'=>$request->id, 
                            'round'=>$request->round,
                        ])->update(['sum'=>$res[0]->sum - $old_sum + $total]);
                        
                    } else {
                        \DB::table('sum_score')->where([
                            'match_id'=>$request->match_id, 
                            'production_id'=>$request->id, 
                            'round'=>$request->round,
                        ])->update(['sum'=>$res[0]->sum + $total ,'sum_rater'=> $res[0]->sum_rater + 1]);
                        
                    }
                } else {
                    \DB::table('sum_score')->insert([
                        'match_id'=>$request->match_id, 
                        'production_id'=>$request->id, 
                        'round'=>$request->round,
                        'sum'=>$total ,
                        'sum_rater'=> 1
                    ]);
                }

                $num  = \DB::table('rater_match')->select('finish')->where([
                    'match_id'=>$request->match_id,
                    'user_id'=> user('id'),
                    'round'=> $request->round
                ])->first();

                if(!count($old)) {
                    \DB::table('rater_match')->where([
                        'match_id'=>$request->match_id,
                        'user_id'=> user('id'),
                        'round'=> $request->round
                    ])->update(['finish'=> $num->finish + 1 ]);
                }
                return ['data'=>true,'msg'=>'success with score'.$total];
            } else {
                // 投票
                \DB::table('score')->insert([
                    'match_id'=>$request->match_id, 
                    'production_id'=>$request->id, 
                    'round'=>$request->round, 
                    'rater_id'=>user('id'), 
                    'res'=>$request->value 
                    ]);
                // 总分表数据处理
                $res = \DB::table('sum_score')->where([
                        'match_id'=>$request->match_id, 
                        'production_id'=>$request->id, 
                        'round'=>$request->round,
                    ])->get();
                //判断是否有记录
                if(count($res)) {
                    if($request->value == 1) {
                            //旧记录非入围时加一
                        if($old_value != 1) {
                            $sum = $res[0]->sum + 1;
                            \DB::table('sum_score')->where([
                                'match_id'=>$request->match_id, 
                                'production_id'=>$request->id, 
                                'round'=>$request->round,
                            ])->update(['sum'=>$sum]);
                        }

                    } elseif ($request->value == 2 || $request->value == 3) {
                        //旧记录入围时减一
                        if($old_value == 1) {
                            $sum = $res[0]->sum - 1;
                            \DB::table('sum_score')->where([
                                'match_id'=>$request->match_id, 
                                'production_id'=>$request->id, 
                                'round'=>$request->round,
                            ])->update(['sum'=>$sum]);
                        }
                    } else{
                        //其他不做处理
                    }

                } else {
                    if($request->value == 1) {
                        //没记录入围时票数1
                        \DB::table('sum_score')->insert([
                            'match_id'=>$request->match_id, 
                            'production_id'=>$request->id, 
                            'round'=>$request->round, 
                            'sum'=>1
                        ]);
                    }
                }
                // 更新评委已完成数
                $num  = \DB::table('rater_match')->select('finish')->where([
                    'match_id'=>$request->match_id,
                    'user_id'=> user('id'),
                    'round'=> $request->round
                ])->first();
                if($request->value == 1) {
                    \DB::table('rater_match')->where([
                        'match_id'=>$request->match_id,
                        'user_id'=> user('id'),
                        'round'=> $request->round
                    ])->update(['finish'=> $num->finish + 1 ]);
                } elseif($old_value == 1) {
                    \DB::table('rater_match')->where([
                        'match_id'=>$request->match_id,
                        'user_id'=> user('id'),
                        'round'=> $request->round
                    ])->update(['finish'=> $num->finish - 1 ]);
                }
                return ['data'=>true,'msg'=>'success with vote'];
            }
        } catch (\Exception $e) {
            return ['data'=>false,'msg'=>$e];;
        }
    }
    public function review_score($request)
    {
         try {
            // 过滤
            if(!$request->id || !$request->match_id ||!$request->round ||!$request->value ) {
                return false;
            }
            // 赛事轮次审核
            $match = \DB::table('matches')->find($request->match_id);

            if ((int) (@$match->round) < $request->round) {

                return ['data'=>false,'msg'=>'尚未开始第'.$request->round.'轮评审'];

            } elseif ((int) (@$match->round) > $request->round) {

                return ['data'=>false,'msg'=>'评审已结束'];
            }
            // 旧记录
            $old = \DB::table('score')->where([
                'match_id'=>$request->match_id, 
                'production_id'=>$request->id, 
                'round'=>$request->round,
                'rater_id'=>user('id'),
                ])->get();
            if(count($old)) {
                if($old[0]->res == $request) {

                    return ['data'=>true,'msg'=>'success'];
                }
                $old_value = $old[0]->res;
            } else {
                $old_value = 0;
            }
            //删除旧记录
            \DB::table('score')->where([
                'match_id'=>$request->match_id, 
                'production_id'=>$request->id, 
                'round'=>$request->round,
                'rater_id'=>user('id'),
                ])->delete();
            $total = $request->total;
            dd($total);
            
            \DB::table('score')->insert([
                'match_id'=>$request->match_id, 
                'production_id'=>$request->id, 
                'round'=>$request->round, 
                'rater_id'=>user('id'), 
                'res'=>$request->value 
                ]);
            // 总分表数据处理
            $res = \DB::table('sum_score')->where([
                    'match_id'=>$request->match_id, 
                    'production_id'=>$request->id, 
                    'round'=>$request->round,
                ])->get();
            //判断是否有记录
            if(count($res)) {
                if($request->value == 1) {
                        //旧记录非入围时加一
                    if($old_value != 1) {
                        $sum = $res[0]->sum + 1;
                        \DB::table('sum_score')->where([
                            'match_id'=>$request->match_id, 
                            'production_id'=>$request->id, 
                            'round'=>$request->round,
                        ])->update(['sum'=>$sum]);
                    }

                } elseif ($request->value == 2 || $request->value == 3) {
                    //旧记录入围时减一
                    if($old_value == 1) {
                        $sum = $res[0]->sum - 1;
                        \DB::table('sum_score')->where([
                            'match_id'=>$request->match_id, 
                            'production_id'=>$request->id, 
                            'round'=>$request->round,
                        ])->update(['sum'=>$sum]);
                    }
                } else{
                    //其他不做处理
                }

            } else {
                if($request->value == 1) {
                    //没记录入围时票数1
                    \DB::table('sum_score')->insert([
                        'match_id'=>$request->match_id, 
                        'production_id'=>$request->id, 
                        'round'=>$request->round, 
                        'sum'=>1
                    ]);
                }
            }
            // 更新评委已完成数
            $num  = \DB::table('rater_match')->select('finish')->where([
                'match_id'=>$request->match_id,
                'user_id'=> user('id'),
                'round'=> $request->round
            ])->first();
            if($request->value == 1) {
                \DB::table('rater_match')->where([
                    'match_id'=>$request->match_id,
                    'user_id'=> user('id'),
                    'round'=> $request->round
                ])->update(['finish'=> $num->finish + 1 ]);
            } elseif($old_value == 1) {
                \DB::table('rater_match')->where([
                    'match_id'=>$request->match_id,
                    'user_id'=> user('id'),
                    'round'=> $request->round
                ])->update(['finish'=> $num->finish - 1 ]);
            }
            return ['data'=>true,'msg'=>'success'];
        } catch (\Exception $e) {
            return ['data'=>false,'msg'=>$e];;
        }
    }
}
