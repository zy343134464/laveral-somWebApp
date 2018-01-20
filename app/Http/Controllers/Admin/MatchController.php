<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\Match;
use Illuminate\Support\Facades\DB;

class Matchcontroller extends Controller
{
    public function create($type)
    {
        return view('admin.match.create.main',['type'=>$type]);
    }
    public function store(Request $request,Match $match,$type)
    {

        $id = $match->main($request,$type);
        if($id) {
            return redirect('admin/match/partner/'.$id);
        }
        return redirect()->back()->with('msg','添加数据失败...');
    }
    public function edit(Match $match,$id)
    {
        $match = $match->find($id);
    	return view('admin.match.create.edit',['match'=>$match,'id'=>$id]);
    }
    
    public function mainedit(Request $request,Match $match,$id)
    {

    	$id = $match->mainedit($request,$id);
    	if($id) {
    		return redirect('admin/match/partner/'.$id);
    	}
    	return redirect()->back()->with('msg','修改数据失败...');
    }

    public function partner(Request $request,Match $match,$id)
    {
    	$partner = \DB::table('partners')->where('match_id',$id)->get();
    	$connection = \DB::table('connections')->where('match_id',$id)->get();
    	return view('admin.match.create.partner',['partner'=>$partner,'connection'=>$connection,'id'=>$id]);
    }

    public function storepartner(Request $request,Match $match,$id)
    {
    	$match->partner($request,$id);
    	$match->connection($request,$id);
    	return redirect('admin/match/rater/'.$id);
    	
    }

    public function rater(Request $request,Match $match,$id)
    {
        $rater = \DB::table('raters')->where('match_id',$id)->get();
        return view('admin.match.create.rater',['rater'=>$rater,'id'=>$id]);
    }

    public function addrater(Request $request,Match $match,$id)
    {
    	dd('新增rater');
    }


    public function findrater(Request $request,Match $match,$id)
    {
    	if($request->kw){
    		$kw = $request->kw;
	    	$user = \DB::table('users')->when($kw, function ($query) use ($kw) {
	                return $query->orWhere('name', 'like', '%'.$kw.'%')->orWhere('phone', 'like', '%'.$kw.'%')->orWhere('introdution', 'like', '%'.$kw.'%');})->get();
    	} else {
    		$user = [];
    	}
    	return view('admin.match.create.findrater',['rater'=>$user,'id'=>$id]);
    }

    public function storerater(Match $match,$id)
    {
    	//undefined
    	$match->rater($request,$id);
    	return redirect('admin/match/guest/'.$id);
    }

    public function guest(Request $request,Match $match,$id)
    {
    	$guest = \DB::table('guests')->where('match_id',$id)->get();
    	return view('admin.match.create.guest',['guest'=>$guest,'id'=>$id]);
    }

    public function findguest(Request $request,Match $match,$id)
    {
    	if($request->kw){
    		$kw = $request->kw;
	    	$user = \DB::table('users')->when($kw, function ($query) use ($kw) {
	                return $query->orWhere('name', 'like', '%'.$kw.'%')->orWhere('phone', 'like', '%'.$kw.'%')->orWhere('introdution', 'like', '%'.$kw.'%');})->get();
    	} else {
    		$user = [];
    	}
    	return view('admin.match.create.findguest',['guest'=>$user,'id'=>$id]);
    }

    public function storeguest(Match $match,$id)
    {
    	//undefined
    	$match->guest($request,$id);
    	return redirect('admin/match/award/'.$id);
    }


    public function award(Request $request,Match $match,$id)
    {
    	$award = \DB::table('awards')->where('match_id',$id)->get();
    	return view('admin.match.create.award',['award'=>$award,'id'=>$id]);
    }

    public function storeaward(Request $request,Match $match,$id)
    {
    	//undefined
    	$match->award($request,$id);
    	return redirect('admin/match/require_personal/'.$id);
    }
     
    public function require_personal(Request $request,$id)
    {
    	$require_personal = \DB::table('require_personal')->where('match_id',$id)->get();
    	return view('admin.match.create.require_personal',['require_personal'=>$require_personal,'id'=>$id]);
    }

    public function storerequire_personal(Match $match,$id)
    {
    	//undefined
    	$match->require_personal($request,$id);
    	return redirect('admin/match/require_team/'.$id);
    }

     public function require_team(Request $request,Match $match,$id)
    {
    	$require_team = \DB::table('require_team')->where('match_id',$id)->get();
    	return view('admin.match.create.require_team',['require_team'=>$require_team,'id'=>$id]);
    }

    public function storerequire_team(Match $match,$id)
    {
    	//undefined
    	$match->require_team($request,$id);
    	
    	return redirect('admin/match/matchson/'.$id);
    }
     



}

// 'admin.match.create.index'
// 'admin.match.create.partner'
// 'admin.match.create.rater'
// 'admin.match.create.guest'
// 'admin.match.create.award'
// 'admin.match.create.personal'
// 'admin.match.create.team'
// 'admin.match.create.team'