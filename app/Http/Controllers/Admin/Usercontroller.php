<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Admin\User;
use App\Http\Requests\StoreUser;
use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Organ;
use App\Role;
use App\Member;

class Usercontroller extends Controller
{
    protected $temp;
    /**
     * 用户列表首页
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user, Member $member)
    {
        $type = $request->type;
        //搜索关键词
        //$kw = $request->kw;
        //角色id筛选
        //$rid = '';
        //vip_level筛选
        $vip_level = $request->vip_level;
        //$vip_type = 'vip';
        // 'member'
        // 'guest'
        // 'admin'
        // 'rater'
        //机构id
        $oid = organ_info();
        
        $users = $member->select('members.*', 'users.*')
            ->where(['members.organ_id' => $oid])
            ->leftJoin('users', 'users.id', '=', 'members.uid')
            ->leftJoin('roles', 'roles.id', '=', 'members.role_id');
        
        //角色筛选
        if (($vip_type = $request->vip_type) != '') {
            $users = $users->when($vip_type, function ($query) use ($vip_type) {
                return $query->where([ 'members.role_type' => $vip_type]);
            });
        }

        //关键词筛选
        // if (($kw = $request->kw) != '') {
        //     $users = $users->when($kw, function ($query) use ($kw) {
        //         return $query->whereIn('members.uid', Controller::search_name_or_phone($kw));
        //     });
        // }
                
        $users = $users->orderBy('members.id')->Paginate(10);

        //临时代替
        $kw = $request->kw;
        $users = User::when($kw, function ($query) use ($kw) {
            return $query->orWhere('phone', 'like', '%'.$kw.'%')
                 ->orWhere('name', 'like', '%'.$kw.'%');
        })->orderBy('id', 'desc')->Paginate(10);
        return view('admin.user.user', ['users'=>$users,'kw'=>$kw,'type'=>$type]);
    }


    /**
     * 显示添加用户页
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    
    /**
     * 添加新用户
     *
     * @param  storeUser 表单认证
     * @return 返回用户列表
     */
    public function store(Request $request, User $user)
    {
        //$res = $user->reg($request);
        $check = $user->where('phone',$request->phone)->first();
        if(count($check)) {
            $request->flash();
            return back()->with('msg','该手机号已注册');
        }
        $uid = $user->insertGetId(
            ['name' => $request->name, 'phone' => $request->phone, 'password' => pw($request->password),'created_at' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'])]
        );
        return redirect()->route('user_index');
    }


    /**
     * 显示编辑用户页
     *
     * @param  用户id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, $id)
    {
        $user = $user->find($id);
        return view('admin.user.edit', ['user' => $user]);
    }


    /**
     * 修改用户信息
     *
     * @param  storeUser 表单认证
     * @return 返回用户列表
     */
    public function update(StoreUser $request, User $user)
    {
        try {
            $user = User::find($request->id);
            $user->name = $request->name;
            $pic = $request->file('pic')->storeAs('/', 'profile'.$request->id.'.'.$request->file('pic')->getClientOriginalExtension(), 'profile');
            $user->pic = 'profile/'.$pic;
            $user->email = $request->email;
            $user->account = $request->account;
            $user->save();
        } catch (Exception $e) {
            return redirect()->route('user_index');
        }
        return redirect()->route('user_index');
    }


    /**
     * 删除用户
     *
     * @param  用户id
     * @return 返回用户列表
     */
    public function destroy(User $user, $id)
    {
        $user->find($id)->delete();
        return redirect()->to('admin/user');
    }

    /**
     * ajax判断用户手机是否占用
     * @param  [string] $phone
     * @return [json字符串]
     */
    public function account(User $user, $phone)
    {
        $res = $user->where(['phone'=>$phone])->get();

        if (count($res)) {
            $msg['msg'] = '该手机已被注册';
        } else {
            $msg['msg'] ='手机号可注册';
        }
        return json_encode($msg);
    }
    /**
     * ajax 导出用户资料
     * @param string $value [description]
     */
    public function exc_info(Request $request)
    {
        $str = $request->id;
        $arr = json_decode($str, true);
    }
    /**
     * 导出单个用户信息
     * @param  User   $user [description]
     * @param  [type] $id   [description]
     * @return [type]       [description]
     */
    public function info(User $user, $id)
    {
        $res = $user->select('name', 'phone', 'sex', 'email')->find($id);
        $data = [];
        $data[] = ['用户名','手机号','性别','email'];

        $info = [];
        $info[] = $res->name;
        $info[] = $res->phone;
        $info[] = $res->sex ? '女': '男';
        $info[] = $res->email;

        $data[] = $info;
        $this->downloadExcel($data, '用户'.$res->name.'资料');
    }
    /**
     * 根据机构id 导出所有用户信息
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function infoall(User $user)
    {
        $data = [];
        $data[] = ['用户名','手机号','性别','email'];

        // $organ_id = organ_info();

        // $user_id = \DB::table('members')->select('uid')->where('organ_id',$organ_id)->get();
        // $user_id = [1,2];
        // if(count($user_id)) {
        //     $arr = [];
        //     foreach ($user_id as $uv) {
        //         if(in_array($uv->uid,$arr)) continue;
        //         $arr[] = $uv->uid;
        //     }

        //     $res = $user->select('name','phone','sex','email')->whereIn('id',$arr)->get();

        $res = $user->select('name', 'phone', 'sex', 'email')->get();
        foreach ($res as $value) {
            $info = [];
            $info[] = $value->name;
            $info[] = $value->phone;
            $info[] = $value->sex ? '女': '男';
            $info[] = $value->email;

            $data[] = $info;
        }
        // }
        $this->downloadExcel($data, '用户资料');
    }
    /**
     * 导入Excel模板下载
     * @return [type] [description]
     */
    public function get_excel()
    {
        //$data =  Schema::getColumnListing('users');
        $data = [];
        $data[] = ['用户名','手机号(必填)','性别(默认男)','密码(默认123456)','email'];

        $this->downloadExcel($data, 'Excel模板');
    }

    /**
     * Excel 导入用户
     * @param  Request $request [description]
     * @param  User    $user    [description]
     * @return [type]           [description]
     */
    public function addusers(Request $request, User $user)
    {
        try {
            if ($request->file('excel')->isValid()) {
                $path = $request->excel->path();
            } else {
                return redirect()->to('admin/user');
            }
            $this->uploadExcel($path);
            $data =  $this->temp;

            foreach ($data as $k=>$v) {
                
                //-------------------导入信息待定---------------------
            }
            //$data = json_encode([$data],256);

            return json_encode(['data'=>$data,'msg'=>'成功','status'=>true], 256);
        } catch (\Exception $e) {
            return json_encode(['data'=>$data,'msg'=>$e->getMessage(),'status'=>false], 256);
        }
    }


    


    public function uploadExcel($path)
    {
        \Excel::load($path, function ($reader) {
            $this->temp = $reader->all()->toArray();
        });
    }

    public function role_setting($value='')
    {
        $organId = organ_info();
        $organ = new Organ();
        $organInfo = $organ->find($organId);
        $role = new Role();
        $roles = $role->where('organ_id', '=', $organId)->first();
        return view('admin.user.role_setting', [ 'organ' => $organInfo, 'roles' => $roles]);
    }
    
    public function set_role(Request $request)
    {
        return back();
        dd($request);
        $organId = organ_info();
        $organ = new Organ();
        $organ_edit = [ 'member_title' => $request->member_title, 'id' => $organId, 'member_content' => $request->member_content];
        $organInfo = $organ->edit($organ_edit);
        $role = new Role();
        $roles = $role->setData($request);
        return view('admin.user.role_setting', [ 'organ' => $organInfo, 'roles' => $roles]);
    }
}
