<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\User;
use App\User_match;
use App\Production;



class UserController extends Controller
{
    const PAGE_NUM = 10;
    
    public function product(Request $request,  Production $production, $page=1)
    {
        $uid = user('id');
        // $product = DB::table('productions')
        // ->leftJoin('matches', 'matches.id', '=', 'productions.match_id')
        // ->select('productions.*', 'matches.collect_end', 'matches.collect_start', 'matches.status as match_status', 'matches.title as match_title')
        // ->where(['productions.user_id' => $uid]);
        // if ( $request->search != '' ) {
        //     $product = $product->where('productions.title', 'like', '%'. $request->search . '%');
        // }
        // $product = $product->offset( ($page-1) * self::PAGE_NUM )
        // ->limit(self::PAGE_NUM)
        // ->get();
        $product = $production->select('id','pic','match_id','title')->where('user_id',$uid)->where('pid',0);
        if ( $request->search != '' ) {
            $product = $product->where('productions.title', 'like', '%'. $request->search . '%');
        }
        $product = $product->with('match')->orderBy('id','desc')->Paginate(12);

        
        return view('home.user.product', ['product' => $product]);
    }

    public function user_match(Request $request)
    {

        $user_id  = user('id');
        if(!$user_id) return back();
        $match = User_match::where('user_id',$user_id)->Paginate(12);
        return view('home.user.match',['match'=>$match]);
    }

    public function consumes(Request $request)
    {
        return view('home.user.consumes');
    }
    public function organ(Request $request)
    {
        $uid = user('id');
        $organ = DB::table('members')
        ->leftJoin('organs', 'organs.id', '=', 'members.organ_id')
        ->select('members.*', 'organs.name as organ_name', 'organs.logo', 'organs.detail')
        ->where(['members.uid' => $uid])
        ->get();
        return view('home.user.organ', [ 'organ' => $organ]);
    }
    public function info(Request $request)
    {
        $info = User::find(user('id'));
        return view('home.user.info',['info'=>$info]);
    }
    public function editInfo(Request $request, User $user, $uid)
    { 
        $result = $user->edit($request, $uid);
        if ( $result ) {
            return redirect()->to('user/info');
        } else {
            return back()->with('msg','编辑失败');
        }
        
    }
    /**
     * 修改密码
     * @param Request $request
     * @return Ambigous
     * */
    public function editPassword(Request $request, User $user, $uid)
    {
        $result = $user->editPassword($request, $uid);
        if ( $result['status'] ) {
            return redirect()->to('user/info');
        } else {
            return back()->with('msg', $result['msg']);
        }
        
    }
    
    public function award(Request $request)
    {
        /* $product = DB::table('productions')
        ->leftJoin('matches', 'matches.id', '=', 'productions.match_id')
        ->select('productions.*', 'matches.collect_end', 'matches.collect_start', 'matches.status as match_status', 'matches.title as match_title')
        ->where(['productions.user_id' => $uid]);
        if ( $request->search != '' ) {
            $product->where('productions.title', 'like', '%'. $request->search . '%');
        }
        $product->offset( ($page-1) * self::PAGE_NUM )
        ->limit(self::PAGE_NUM)
        ->get(); */
        
        return view('home.user.award');
    }
    
}
