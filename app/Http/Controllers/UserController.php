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

    public function username(Request $request)
    {
        return view('home.login.username');
    }
    public function password(Request $request)
    {
        $user_id = user();
        if($request->password == $request->password2 && $request->password != '' && $user_id) {
            Homeuser::where('id',$user_id)->update(['password'=>pw($request->password)]);
            return redirect()->to('login')->with('msg','修改成功');
        } else {
            return back()->with('msg','修改失败');
        }
    }
    public function setusername(Request $request)
    {
        $user_id = user();
        try {
            
            if($request->name  != '' && $user_id) {

                Homeuser::where('id',$user_id)->update(['name'=>mb_substr($request->name,0,30,'utf-8')]);

                return redirect()->to('/')->with('msg','注册成功');
            } else {
                return back()->with('msg','修改失败');
            }
        } catch (\Exception $e) {
            return back()->with('msg','修改失败');
        }
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
    public function doreg(storeUser $request, Homeuser $user)
    {
        $res = $user->reg($request);
        set_user_id_cookie($user->id);
        if ($res) {
            return redirect()->to('/username');
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
            
            return redirect()->to('/');
        } else {
            return redirect()->to('login')->with('msg', '密码错误,请重新登录')->withInput();
        }
    }


    public function forget()
    {
        return view('home.login.forgetpass');
    }


    public function set_password(Request $request)
    {
        try {
            
            if($request->phone != "" && $request->check != "" ) {
                $res = Homeuser::where('phone',$request->phone)->first();
                set_user_id_cookie($res->id);
                return view('home.login.password');
            }
            return back()->with('msg','修改失败');
        } catch (\Exception $e) {
            return back()->with('msg','修改失败');
        }
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
