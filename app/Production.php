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
    public function get_sum()
    {
        return $this->hasMany('App\Sum_score');
    }
    public function info($id)
    {
        try {
            $res = $this->find($id);
            if ($res->type == 1) {
                $res->pic = json_decode($res->pic);
            }
            return $res;
            $info = json_decode(json_encode($res));
            $res['pic'] = json_decode($res['pic']);

            $info = [];

            if ($res->cat == 0) {
                $require = \DB::table('require_personal')->where(['match_id'=>$res->match_id])->first();
            } else {
                $require = \DB::table('require_team')->where(['match_id'=>$res->match_id])->first();
            }
            $must = json_decode($require->production_info, true)[0];
            $diy = json_decode($require->diy_info, true)[0];

            $info['id'] = $res->id;
            $pic = json_decode($res->pic);
            $info['pic'] = $pic ? $pic : $res->pic;
            $field = production_info();
            $no = 0;
            foreach ($must as $mv) {
                $no += 1;
                $info['info'][$no]['key'] = $field[$mv];
                $info['info'][$no]['value'] = $res->$mv;
            }
            $diy = json_decode($res->diy_info, true);
            if (count($diy)) {
                foreach ($diy as $value) {
                    $no += 1;
                    $info['info'][$no] = $value;
                }
            }
            return $info;
        } catch (\Exception $e) {
            dd($e);
            return [];
        }
    }
    public function score($mid, $round, $id, $uid = '')
    {
        if (!$uid) {
            $uid = user('id');
        }
        $res = \DB::table('score')->where([
            'production_id'=>$id,
            'match_id'=>$mid,
            'round'=>$round,
            'rater_id'=>$uid,
            ])->get();

        if (count($res)) {
            return $res[0]->res;
        } else {
            return false;
        }
    }
    public function admin_score_sum($id, $round)
    {
        $res = \DB::table('sum_score')->where(['production_id'=>$id,'round'=>$round])->first();
        if (count($res)) {
            return $res->sum / ($res->sum_rater ? $res->sum_rater : 1) ;
        } else {
            return 0;
        }
    }

    public function rater_score_sum($mid, $round, $id, $uid = '')
    {
        if (!$uid) {
            $uid = user('id');
        }
        $res = \DB::table('score')->where([
            'production_id'=>$id,
            'match_id'=>$mid,
            'round'=>$round,
            'rater_id'=>$uid,
            ])->get();

        if (count($res)) {
            return $res[0]->sum;
        } else {
            return false;
        }
    }

    public function win($pid)
    {
        try {
            $result = \DB::table('result')->select('win_id')->where(['production_id'=>$pid])->get();
            $string ='';
            foreach ($result as $key => $value) {
                $res = \DB::table('win')->select('name')->where('id', $value->win_id)->first();
                if (count($res)) {
                    $string .= $res->name. ' ';
                }
            }
            return $string;
        } catch (\Exception $e) {
            return '';
        }
    }
    public function review($request, $type = 1)
    {
        try {
            \DB::beginTransaction();
            // 过滤
            if (!$request->id || !$request->match_id ||!$request->round) {
                if ($request->type == 1 && !$request->value) {
                    return ['data'=>false,'msg'=>'数据请求失败'];
                } else {
                    if (!$request->res) {
                        return ['data'=>false,'msg'=>'数据请求失败'];
                    }
                }
            }
            $num  = \DB::table('rater_match')->select('finish', 'total')->where([
                'match_id'=> $request->match_id,
                'user_id'=> user('id'),
                'round'=> $request->round
            ])->first();

            if (count($num)) {
                if ($num->finish >= $num->total && $request->value == 1) {
                    return ['data'=>false,'msg'=>'你已经全部评审完毕'];
                }
            }

            // 赛事轮次审核
            $match = \DB::table('matches')->find($request->match_id);

            if ($match->round < $request->round) {
                return ['data'=>false,'msg'=>'尚未开始第'.$request->round.'轮评审'];
            } elseif ($match->round > $request->round) {
                return ['data'=>false,'msg'=>'评审已结束'];
            }
            // 旧记录
            $old = \DB::table('score')->where([
                'match_id'=>$request->match_id,
                'production_id'=>$request->id,
                'round'=>$request->round,
                'rater_id'=>user('id'),
                ])->first();
            if (count($old)) {
                if ($old->res == $request->res) {
                    return ['data'=>true,'msg'=>'success without ed'];
                }
                
                $old_sum = $old->sum;

                $old = (array)$old;
            } else {
                $old = [];
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
            if ($request->type == 2) {
                //获取评审
                $reviews = \DB::table('reviews')->where(['match_id'=>$request->match_id, 'round'=>$request->round])->first();
                $percent = (json_decode($reviews->setting, true))['percent'];
                $count = count($percent);

                $temp = $score = [];
                $total = 0;
                $data = json_decode($request->res);
                foreach ($percent as $key => $value) {
                    $score[$key] = $value * $data[$key] ;
                    $total += $value * $data[$key] ;
                    $temp['p'.$key] = $data[$key];
                }
                $temp =array_merge($temp, [
                    'match_id'=>$request->match_id,
                    'production_id'=>$request->id,
                    'round'=>$request->round,
                    'rater_id'=>user(),
                    'res'=>json_encode($score),
                    'sum'=>$total
                    ]) ;
                $newId = \DB::table('score')->insertGetId($temp);
                unset($temp);

                // 总分表数据处理
                $res = \DB::table('sum_score')->where([
                        'match_id'=>$request->match_id,
                        'production_id'=>$request->id,
                        'round'=>$request->round
                    ])->first();

               
                if (count($res)) {
                    $res = json_decode(json_encode($res), true);
                    if (count($old)) {
                        $temp = ['sum'=> ($res['sum'] * $res['sum_rater'] - $old_sum + $total) / $res['sum_rater']];
                        foreach (json_decode($request->res) as $sk => $sv) {
                            $temp['p'.$sk] = $res['p'.$sk] + $sv - $old['p'.$sk];
                        }

                        \DB::table('sum_score')->where([
                            'match_id'=>$request->match_id,
                            'production_id'=>$request->id,
                            'round'=>$request->round,
                        ])->update($temp);
                    } else {
                        $temp = ['sum'=>($res['sum'] * $res['sum_rater']  + $total) / ($res['sum_rater'] + 1),'sum_rater'=> $res['sum_rater'] + 1];
                        foreach (json_decode($request->res) as $sk => $sv) {
                            $temp['p'.$sk] = $res['p'.$sk] + $sv;
                        }

                        \DB::table('sum_score')->where([
                            'match_id'=>$request->match_id,
                            'production_id'=>$request->id,
                            'round'=>$request->round,
                        ])->update($temp);
                    }
                } else {
                    $temp = [
                        'match_id'=>$request->match_id,
                        'production_id'=>$request->id,
                        'round'=>$request->round,
                        'sum'=>$total ,
                        'sum_rater'=> 1
                    ];

                    foreach (json_decode($request->res) as $sk => $sv) {
                        $temp['p'.$sk] =  $sv;
                    }

                    \DB::table('sum_score')->insert($temp);
                }

                //评委进度更新

                if (!count($old)) {
                    \DB::table('rater_match')->where([
                        'match_id'=>$request->match_id,
                        'user_id'=> user('id'),
                        'round'=> $request->round
                    ])->update(['finish'=> $num->finish + 1 ]);
                }
                \DB::commit();
                return ['data'=>true,'msg'=>'success with score'.$total];
            } else {
                // 投票
               
                \DB::table('score')->insert([
                    'match_id'=>$request->match_id,
                    'production_id'=>$request->id,
                    'round'=>$request->round,
                    'rater_id'=>user('id'),
                    'res'=>$request->value,
                    'sum'=>$request->value
                    ]);
                // 总分表数据处理
                //判断是否有记录
                if (count($old)) {
                    if ($request->value == 1) {
                        //旧记录非入围时加一
                        if ($old['res'] != 1) {
                            \DB::table('sum_score')->where([
                                'match_id'=>$request->match_id,
                                'production_id'=>$request->id,
                                'round'=>$request->round,
                            ])->increment('sum');
                        }
                    } elseif ($request->value == 2 || $request->value == 3) {
                        //旧记录入围时减一
                        if ($old['res'] == 1) {
                            \DB::table('sum_score')->where([
                                'match_id'=>$request->match_id,
                                'production_id'=>$request->id,
                                'round'=>$request->round,
                            ])->decrement('sum');
                        }
                    }
                    //其他不做处理
                } else {
                    $res = \DB::table('sum_score')->where([
                        'match_id'=>$request->match_id,
                        'production_id'=>$request->id,
                        'round'=>$request->round,
                    ])->get();

                    if ($request->value == 1) {
                        //没记录入围时,票数1
                        if (count($res)) {
                            \DB::table('sum_score')->where([
                                'match_id'=>$request->match_id,
                                'production_id'=>$request->id,
                                'round'=>$request->round
                            ])->update(['sum'=>$res[0]->sum  + 1,'sum_rater'=>$res[0]->sum_rater  + 1]);
                        } else {
                            \DB::table('sum_score')->insert([
                                'match_id'=>$request->match_id,
                                'production_id'=>$request->id,
                                'round'=>$request->round,
                                'sum'=>1,
                                'sum_rater'=>1,
                            ]);
                        }
                    }
                }
                // 更新评委已完成数
                $num  = \DB::table('rater_match')->select('finish')->where([
                    'match_id'=>$request->match_id,
                    'user_id'=> user('id'),
                    'round'=> $request->round
                ])->first();

                if ($request->value == 1) {
                    if (count($old)) {
                        if ($old['res'] == 1) {
                        } else {
                            \DB::table('rater_match')->where([
                                'match_id'=>$request->match_id,
                                'user_id'=> user('id'),
                                'round'=> $request->round
                            ])->increment('finish');
                        }
                    } else {
                        \DB::table('rater_match')->where([
                            'match_id'=>$request->match_id,
                            'user_id'=> user('id'),
                            'round'=> $request->round
                        ])->increment('finish');
                    }
                } elseif (count($old) && $old['res'] == 1) {
                    \DB::table('rater_match')->where([
                        'match_id'=>$request->match_id,
                        'user_id'=> user('id'),
                        'round'=> $request->round
                    ])->decrement('finish');
                }
                \DB::commit();
                return ['data'=>true,'msg'=>'success with vote'];
            }
        } catch (\Exception $e) {
            \DB::rollback();
            return ['data'=>false,'msg'=>'error : '.$e->getMessage()];
            ;
        }
    }
    public function review_score($request)
    {
        try {
            // 过滤
            if (!$request->id || !$request->match_id ||!$request->round ||!$request->value) {
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
            if (count($old)) {
                if ($old[0]->res == $request) {
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
            if (count($res)) {
                if ($request->value == 1) {
                    //旧记录非入围时加一
                    if ($old_value != 1) {
                        $sum = $res[0]->sum + 1;
                        \DB::table('sum_score')->where([
                            'match_id'=>$request->match_id,
                            'production_id'=>$request->id,
                            'round'=>$request->round,
                        ])->update(['sum'=>$sum]);
                    }
                } elseif ($request->value == 2 || $request->value == 3) {
                    //旧记录入围时减一
                    if ($old_value == 1) {
                        $sum = $res[0]->sum - 1;
                        \DB::table('sum_score')->where([
                            'match_id'=>$request->match_id,
                            'production_id'=>$request->id,
                            'round'=>$request->round,
                        ])->update(['sum'=>$sum]);
                    }
                } else {
                    //其他不做处理
                }
            } else {
                if ($request->value == 1) {
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
            if ($request->value == 1) {
                \DB::table('rater_match')->where([
                    'match_id'=>$request->match_id,
                    'user_id'=> user('id'),
                    'round'=> $request->round
                ])->update(['finish'=> $num->finish + 1 ]);
            } elseif ($old_value == 1) {
                \DB::table('rater_match')->where([
                    'match_id'=>$request->match_id,
                    'user_id'=> user('id'),
                    'round'=> $request->round
                ])->update(['finish'=> $num->finish - 1 ]);
            }
            return ['data'=>true,'msg'=>'success'];
        } catch (\Exception $e) {
            return ['data'=>false,'msg'=>$e];
            ;
        }
    }
}
