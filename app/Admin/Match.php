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

    public function partner(Request $request,$id)
    {
    	foreach($request->role as $k=>$v)
    	{
			\DB::table('partners')->insertGetId([
				'role'=>$v,
				'name'=>($request->name)[$k],
				'match_id'=>$id,
				'organ_id'=>organ('id'),
			]);
    	}
    }

    public function connection(Request $request,$id)
    {
    	foreach($request->type as $k=>$v)
    	{
			\DB::table('connections')->insertGetId([
				'type'=>$v,
				'value'=>($request->value)[$k],
				'match_id'=>$id,
			]);
    	}
    }
    public function award(Request $request,$id)
    {
    	foreach($request->no as $k=>$v)
    	{
			\DB::table('awards')->insertGetId([
				'no'=>$v,
				'num'=>($request->num)[$k],
				'detail'=>($request->detail)[$k],
				'match_id'=>$id,
			]);
    	}
    }

    public function require_personal(Request $request,$id)
    {
    	\DB::table('require_personal')->insertGetId([
			'match_id'=>$id,
		]);
    }
    public function require_team(Request $request,$id)
    {
    	\DB::table('require_team')->insertGetId([
			'match_id'=>$id,
		]);
    }




}
