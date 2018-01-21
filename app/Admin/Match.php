<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Match extends Model
{
    public function main(Request $request,$type)
    {
		$res = \DB::table('matches')->insertGetId([
				"cat" => $type,
				"type" => $request->type ? $request->type : '',
		    	"show_title" => $request->show_title,
		    	"show_introdution" => $request->show_introdution,
		    	"detail_title" => json_encode($request->detail_title),
		    	"detail_introdution" => $request->detail_introdution,
		    	"collect_start" => $request->collect_start ? $request->collect_start :0,
		    	"collect_end" => $request->collect_end ? $request->collect_end :0,
		    	"review_start" => $request->review_start ? $request->review_start :0,
		    	"review_end" => $request->review_end ? $request->review_end :0,
		    	"public_time" => $request->public_time ? $request->public_time :0,
		    	"status" => 0,
		]);
    	return $res;
    }
    public function mainedit(Request $request,$id)
    {
		$res = \DB::table('matches')->where('id',$id)->update([
		    	"show_title" => $request->show_title,
		    	"show_introdution" => $request->show_introdution,
		    	"detail_title" => json_encode($request->detail_title),
		    	"detail_introdution" => $request->detail_introdution,
		    	"collect_start" => $request->collect_start ? $request->collect_start :0,
		    	"collect_end" => $request->collect_end ? $request->collect_end :0,
		    	"review_start" => $request->review_start ? $request->review_start :0,
		    	"review_end" => $request->review_end ? $request->review_end :0,
		    	"public_time" => $request->public_time ? $request->public_time :0,
		    	"status" => 0,
		]);
    	return $id;
    }

    public function partner(Request $request,$id)
    {
    	\DB::table('partners')->where('match_id',$id)->delete();
    	if($request->role) {
    		if(count($request->role)) {
				foreach($request->role as $k=>$v)
				{
					if(is_null($v) || is_null(($request->name)[$k])){
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

    public function connection(Request $request,$id)
    {
    	\DB::table('connections')->where('match_id',$id)->delete();
    	if($request->type) {
    		if(count($request->type)) {
		    	foreach($request->type as $k=>$v)
		    	{
		    		if(is_null($v) ||  is_null(($request->value)[$k])){
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
    public function award(Request $request,$id)
    {
    	\DB::table('awards')->where('match_id',$id)->delete();
    	if($request->no) {
    		if(count($request->no)) {
		    	foreach($request->no as $k=>$v)
		    	{
		    		if(is_null($v) || is_null(($request->num)[$k])){
						continue;
					}
					\DB::table('awards')->insertGetId([
						'no'=>$v,
						'num'=>($request->num)[$k],
						'detail'=>($request->detail)[$k],
						'match_id'=>$id,
					]);
		    	}
    		}
    	}
    }

    public function require_personal(Request $request,$id)
    {
    	\DB::table('require_personal')->where('match_id',$id)->delete();
    	\DB::table('require_personal')->insertGetId([
			'match_id'=>$id,
			'group_min'=>$request->group_min,
			'group_max'=>$request->group_max,
			'num_max'=>$request->num_max,
			'num_min'=>$request->num_min,
			'size_min'=>$request->size_min,
			'size_max'=>$request->size_max,
			'length'=>$request->length,
			'pay'=>$request->pay,
			'price'=>$request->price,
			'introdution_title'=>$request->introdution_title,
			'introdution_detail'=>$request->introdution_detail
		]);
    }
    public function require_team(Request $request,$id)
    {
    	\DB::table('require_team')->where('match_id',$id)->delete();
    	\DB::table('require_team')->insertGetId([
			'match_id'=>$id,
			'group_min'=>$request->group_min,
			'group_max'=>$request->group_max,
			'num_max'=>$request->num_max,
			'num_min'=>$request->num_min,
			'size_min'=>$request->size_min,
			'size_max'=>$request->size_max,
			'length'=>$request->length,
			'pay'=>$request->pay,
			'price'=>$request->price,
			'introdution_title'=>$request->introdution_title,
			'introdution_detail'=>$request->introdution_detail
		]);
    }




}
