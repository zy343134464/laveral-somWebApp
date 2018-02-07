<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\Match;

class MatchController extends Controller
{
    public function detail(Request $request, Match $match, $id)
    {
    	if(!count($match->find($id))) return back();
    	return redirect()->to('match/join/'.$id);
    }
    public function join(Request $request, $id)
    {
    	return redirect()->to('match/uploadimg/'.$id);
    }
    public function uploadimg(Request $request, $id)
    {
    	$require_personal = \DB::table('require_personal')->where('match_id',$id)->first();
    	return view('home.match.uploadimg',['id'=>$id, 'personal'=>$require_personal]);
    }
    public function douploadimg(Request $request, Match $match, $id)
    {
    	$pic_id = $match->uploadimg($request, $id);
    	if(!$pic_id) return back();
    	return redirect()->to('match/editimg/'.$pic_id);
    }
    public function editimg(Request $request, $id)
    {
    	$pic = \DB::table('productions')->where('id',$id)->first();
    	if(!count($pic)) return back();
    	return view('home.match.editimg',['id'=>$id, 'pic'=>$pic]);
    }
    public function doeditimg(Request $request, Match $match, $id)
    {
    	$match->editimg($request, $id);
    	return back();
    }

}
