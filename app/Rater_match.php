<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rater_match extends Model
{
    protected $table = 'rater_match';

    public function match()
    {
        return $this->belongsTo('App\Admin\Match');
    }
    public function rater_time($mid, $round)
    {
    	$res = \DB::table('reviews')->where(['match_id'=>$mid, 'round'=>$round])->get();
    	if (count($res)) {
    		return $res[0]->end_time;
    	}
    	return time();
    }
}
