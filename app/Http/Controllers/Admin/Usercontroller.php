<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Admin\User;
use App\Http\Requests\StoreUser;
use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Schema;
use Excel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Usercontroller extends Controller
{
    protected $temp;
    /**
     * 用户列表首页
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $type = $request->type;
        //搜索关键词
        $kw = $request->kw;
        //角色id筛选
        $rid = 0;
        //vip_level筛选
        $vip_level = $request->vip_level;
        $vip_type = 'member';
        // 'member'
        // 'guest'
        // 'admin'
        // 'rater'
        //机构id
        $oid = 0;
        //Controller::organ_role_type(0);
        $users = $user
            //角色筛选
            ->when($rid, function ($query) use ($rid,$oid) {
                return $query->whereIn('id', Controller::get_uid_by_rid_oid($rid, $oid));
            })
            //会员等级筛选
            ->when($vip_level, function ($query) use ($vip_level,$vip_type,$oid) {
                return $query->whereIn('id', Controller::get_uid_by_vip($vip_level, $vip_type, $oid));
            })
            //关键词筛选
            ->when($kw, function ($query) use ($kw) {
                return $query->orWhere('name', 'like', '%'.$kw.'%')->orWhere('phone', 'like', '%'.$kw.'%');
            })
            ->orderBy('created_at')->Paginate(10);
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
        $res = $user->reg($request);
        
        return redirect()->route('user_index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
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

   
    public function info(User $user, $id)
    {
        $date[] = $user->find($id)->toArray();
        $this->downloadExcel($date);
    }

    public function infoall(User $user)
    {
        $date = $user->get()->toArray();
        $this->downloadExcel($date);
    }

    public function getfeild()
    {
        $date =  Schema::getColumnListing('users');
        for ($i=0; $i < count($date) - 1; $i++) {
            if ($date[$i + 1] == 'created_at' || $date[$i + 1] == 'updated_at') {
                continue;
            }
            $res[0][] = $date[$i + 1];
        }
        $this->downloadExcel($res, '批量新建用户');
    }


    public function addusers(Request $request, User $user)
    {
        if ($request->file('excel')->isValid()) {
            $path = $request->excel->path();
        } else {
            return redirect()->to('admin/user');
        }
        $this->uploadExcel($path);
        $date =  $this->temp;

        foreach ($date as $k=>$v) {
            //$user->
            //-------------------导入信息待定---------------------
        }
    }


    public function downloadExcel($cellData, $filename = 'userinfo')
    {
        Excel::create($filename, function ($excel) use ($cellData) {
            $excel->sheet('sheet', function ($sheet) use ($cellData) {
                $sheet->fromArray($cellData);
            });
        })->export('xls');
    }


    public function uploadExcel($path)
    {
        Excel::load($path, function ($reader) {
            $this->temp = $reader->all()->toArray();
        });
    }

    public function role_setting($value='')
    {
        return view('admin.user.role_setting');
    }
}
