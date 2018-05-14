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
use App\Member;
use App\Admin\Match;

class UserController extends Controller
{
    const PAGE_NUM = 10;
    
    /**
     * 作品中心 暂时跟换为  match_pic()
     * @param  Request    $request    [description]
     * @param  Production $production [description]
     * @param  integer    $page       [description]
     * @return [type]                 [description]
     */
    public function product(Request $request, Production $production, $page=1)
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
        $product = $production->select('id', 'pic', 'match_id', 'title')->where('user_id', $uid)->where('pid', 0);
        if ($request->search != '') {
            $product = $product->where('productions.title', 'like', '%'. $request->search . '%');
        }
        $product = $product->with('match')->orderBy('id', 'desc')->Paginate(12);

        
        return view('home.user.product', ['product' => $product]);
    }

    public function user_match(Request $request)
    {
        $user_id  = user('id');
        if (!$user_id) {
            return back();
        }
        $kw = isset($request->kw) ? $request->kw : '';
        $match_id = User_match::select('match_id', 'id')->where('user_id', $user_id)->where('status', 0)->get();
        $arr = [];
        foreach ($match_id as $v) {
            $arr[] = $v->match_id;
        }
        $match = Match::whereIn('id', $arr)->when($kw,function ($query) use ($kw) {
            return $query->where('title','like','%'.$kw.'%');
        })->orderBy('id', 'desc')->Paginate(6);

        return view('home.user.match', ['match'=>$match]);
    }
    public function son(Request $request, $id)
    {
        try {
            $res = \DB::table('user_match')->where(['user_id'=>user(),'match_id'=>$id])->first();

            if (count($res)) {
                $res = Match::find($id);
                if ($res->cat == 1) {
                    $son = Match::where(['pid'=>$id])->get();

                    return view('home.user.son', ['match'=>$son]);
                }
            }

            return back();
        } catch (\Exception $e) {
            return back();
        }
    }
    public function del_match(Request $request, $id)
    {
        User_match::where(['user_id'=>user(),'match_id'=>$id])->update(['status'=>1,'updated_at'=>time()]);
        return back();
    }
    public function match_pic(Request $request, $id)
    {
        $user_id  = user('id');

        if (!$user_id) {
            return back();
        }
        $match = Match::where('id', $id)->first();
        if (!count($match)) {
            return back();
        }
        $product = Production::where('user_id', $user_id)->where(['match_id' => $id, 'status' => 2 ]);
        if ($request->search != '') {
            $product = $product->where('productions.title', 'like', '%'. $request->search . '%');
        }
        $product = $product->orderBy('id', 'desc')->Paginate(12);

       
        return view('home.user.product', ['product' => $product,'id' => $id,'match' => $match]);
    }

    public function consumes(Request $request)
    {
        return view('home.user.consumes');
    }
    /**
     * 机构信息
     * @param Request $request
     * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory, mixed, \Illuminate\Foundation\Application, \Illuminate\Container\static>
     */
    public function organ(Request $request)
    {
        //所有机构
        $organs = DB::table('organs')
        ->select('*')
        ->get();
        //已加入的机构会员信息，现在只是普通会员和评委
        $uid = user('id');
        $organMember = DB::table('members')
        ->select('*')
        ->where(['uid' => $uid])
        ->get();
        //组装数据
        $organArr = [];
        if ($organMember) {
            foreach ($organMember as $val) {
                $organArr[$val->organ_id] = 1;
            }
        }
        
        return view('home.user.organ', [ 'organs' => $organs, 'organMember' => $organMember, 'organArr' => $organArr]);
    }
    
    /**
     * 获取机构角色类型
     * @param Request $request
     */
    public function get_organ_roletype(Request $request)
    {
        $organId = $request->oid;
        $roles = DB::table('roles')->where([ 'organ_id' => $organId ])->get();
    }
    
    public function apply_organ(Request $request, Member $Member)
    {
        $this->validate($request, [
        'oid' => 'required',
        'roleId' => 'required',
        ]);
        
        $uid = user('id');
        $data = [ 'uid' => $request->uid, 'organ_id' => $request->oid, 'role_id' => $request->roleId];
        $role = DB::table('roles')->where([ 'id' => $request->roleId ])->first();
        if (!$role) {
            return back()->with('msg', '获取数据失败');
        }
        $res = $Member->add($data, $role);
        if ($res) {
            return redirect()->to('user/organ');
        } else {
            return redirect()->to('user/apply_organ');
        }
    }
    
    /**
     * 个人信息
     * @param Request $request
     * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory, mixed, \Illuminate\Foundation\Application, \Illuminate\Container\static>
     */
    public function info(Request $request)
    {
        $info = User::find(user('id'));
        return view('home.user.info', ['info'=>$info]);
    }

    public function editInfo(Request $request, User $user, $uid)
    {
        $result = $user->edit($request, $uid);
        if ($result) {
            return redirect()->to('user/info');
        } else {
            return back()->with('msg', '编辑失败');
        }
    }
    public function edit_img(Request $request)
    {
        $pic = $request->pic;

        $user_id = user();

        if ($pic && $user_id) {
            $path = save_user_pic($pic);
            if ($path) {
                $res = User::find($user_id);
                
                del_user_pic($res->pic);

                $res = User::where('id', $user_id)->update(['pic'=>$path]);
            }
        }


        return json_encode($path ? $path : '');
    }
    /**
     * 编辑作品
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function pic(Request $request, $id)
    {
        $product = Production::find($id);

        return view('home.user.product_one', ['product'=>$product]);
    }

    /**
     * 处理编辑作品
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function editpic(Request $request, $id)
    {
        if ($request->title == ''  ||  $request->author  == '' ||  $request->detail == '') {
            $status = 1;
        } else {
            $status = 2;
        }

        $res = \DB::table('productions')->where(['id'=>$id])->first();

        if ($res->status == 3) {
            return back()->with('msg', '已投稿,不可再修改');
        }

        $mid = $res->match_id;

        \DB::table('productions')->where('id', $id)->update([
                'title'=>$request->title,
                'author'=>$request->author,
                'detail'=>$request->detail,
                'status'=>$status,
            ]);
        return redirect()->to('user/match/'.$mid);
    }
    /**
     * 删除作品
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function del_pic(Request $request)
    {
        $id = $request->id;
        \DB::table('productions')->where('id', $id)->delete();
        $res = \DB::table('productions')->find($id);
        if (count($res)) {
            return json_encode([0]);
        }
        return json_encode([1]);
    }

    /**
     * 修改密码
     * @param Request $request
     * @return Ambigous
     * */
    public function editPassword(Request $request, User $user, $uid)
    {
        $result = $user->editPassword($request, $uid);
        if ($result['status']) {
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
