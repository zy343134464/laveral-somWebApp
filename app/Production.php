<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $table = 'Productions';

    public function match()
    {
        return $this->belongsTo('App\Admin\Match');
    }
    public function sum_score()
    {
        return $this->hasOne('App\Sum_score');
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
    public function review($request)
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

            // 写入新记录
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
            dd($e);
            return ['data'=>false,'msg'=>$e];;
        }
    }
}
