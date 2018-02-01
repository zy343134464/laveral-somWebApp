<?php

namespace App\Http\Controllers;

use App\Admin\User as Adminuser;
use App\User as Homeuser;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Schema;
use Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $temp;
    /**
     * 用户列表首页
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
    }


    /**
     * 显示reg用户页
     *
     * @return \Illuminate\Http\Response
     */
    public function reg()
    {
        return view('home.login.reg');
    }


    /**
     * 添加新用户
     *
     * @param  storeUser 表单认证
     * @return 重定向
     */
    public function doreg(StoreUser $request, Homeuser $user)
    {
        $res = $user->reg($request);
        if ($res) {
            return redirect()->to('/');
        } else {
            return redirect()->back()->with('msg', '服务器故障...请稍后再试...');
        }
    }

    /**
     * 登录页
     */
    public function login()
    {
        return view('home.login.login');
    }
    /**
     * [login 退出登录]
     * @return [type] [description]
     */
    public function logout()
    {
        logout();
        return view('home.login.login');
    }


    /**
     * 处理登录
     * @return 成功跳转到用户页，失败重新登录
     */
    public function dologin(Request $request, Homeuser $user)
    {
        $res = $user->login($request);
        if ($res) {
            //dd(\Cookie::get('user_id'));
            return redirect()->to('/');
        } else {
            return redirect()->to('login')->with('msg', '密码错误,请重新登录')->withInput();
        }
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
    public function edit(Adminuser $user, $id)
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
    public function update(StoreUser $request, Adminuser $user)
    {
        try {
            $user = User::find($request->id);
            $user->name = $request->name;
            $pic = $request->file('pic')->storeAs('/', 'profile'.$request->id.'.'.$request->file('pic')->getClientOriginalExtension(), 'profile');
            //$filename = 'profile'.$request->id.'.';
            // $realPath = $request->file('pic')->getRealPath();
            // $res =Storage::disk('profile')->put($filename,file_get_contents($realPath));
            // dd($res);
            $user->pic = 'profile/'.$pic;
            $user->email = $request->email;
            $user->account = $request->account;
            $user->save();
        } catch (Exception $e) {
            return redirect()->route('user_index');
        }
        return redirect()->route('user_index');
    }
}
