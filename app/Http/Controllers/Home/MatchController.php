<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\Match;
use Illuminate\Support\Facades\Storage;

class MatchController extends Controller
{
    public function detail(Request $request, Match $match, $id)
    {
        $res = $match->info($id);
        if (!$res) {
            return back();
        }
        return view('home.match.show', ['match'=>$res,'id'=>$id]);
    }
    
    public function join(Request $request, $id)
    {
        return redirect()->to('match/uploadimg/'.$id);
    }

    public function uploadimg(Request $request, $id)
    {
        $require_personal = \DB::table('require_personal')->where('match_id', $id)->first();

        if(!count($require_personal)) return back()->with('该赛事未设置投稿要求');

        $res = \DB::table('user_match')->where(['user_id'=>user(),'match_id'=>$id])->get();
        if(!count($res)) {
            \DB::table('user_match')->insert(['user_id'=>user(),'match_id'=>$id,'num'=>20,'status'=>1,'created_at'=>time()]);
        }
        return view('home.match.uploadimg', ['id'=>$id, 'personal'=>$require_personal]);
    }

    public function uploadimgs(Request $request, $id)
    {
        $require_personal = \DB::table('require_personal')->where('match_id', $id)->first();
        return view('home.match.uploadimgs', ['id'=>$id, 'personal'=>$require_personal]);
    }

    public function douploadimg(Request $request, Match $match, $id)
    {
        $user_id = user();

        $pic_id = $match->uploadimg($request, $id);

        if (!count($pic_id)) {
            return back();
        }
        Storage::disk('config')->put('pic_id_'.$user_id.'.json',json_encode($pic_id));

        return redirect()->to('match/editimg/'.$id);
    }
    public function editimg(Request $request,$id)
    {
        $user_id = user();

        $date = Storage::disk('config')->get('pic_id_'.$user_id.'.json');

        if(!$date) return back()->with('获取数据失败');

        $arr =  json_decode($date,true);

        $pic = \DB::table('productions')->whereIn('id', $arr)->get();

        if (!count($pic)) {
            return back();
        }
        return view('home.match.editimg', ['id'=>$id, 'pic'=>$pic]);
    }
    public function doeditimg(Request $request, Match $match, $id)
    {

        $res = $match->editimg($request, $id);
        

        return redirect()->to('/user/match/'.$id);
    }
    public function doeditimg_one()
    {
        
    }
}
