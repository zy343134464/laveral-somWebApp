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
use App\Http\Controllers\SendController as Send;

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
        if ($request->password == $request->password2 && $request->password != '' && $user_id) {
            Homeuser::where('id', $user_id)->update(['password'=>pw($request->password)]);
            return redirect()->to('login')->with('msg', '修改成功');
        } else {
            return back()->with('msg', '修改失败');
        }
    }
    public function setusername(Request $request)
    {
        $user_id = user();
        try {
            if ($request->name  != '' && $user_id) {
                Homeuser::where('id', $user_id)->update(['name'=>mb_substr($request->name, 0, 30, 'utf-8')]);

                return redirect()->to('/')->with('msg', '注册成功');
            } else {
                return back()->with('msg', '修改失败');
            }
        } catch (\Exception $e) {
            return back()->with('msg', '修改失败');
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
        if(isset($request->code) && isset($request->phone)) {
            $code = $request->code;
            $phone = $request->phone;

            $check = $request->session()->get($phone);
            if($code == $check) {
                $request->session()->forget($phone);

                $res = $user->reg($request);
                set_user_id_cookie($user->id);
                if ($res) {
                    return redirect()->to('/username');
                } else {
                    return redirect()->back()->with('msg', '服务器故障...请稍后再试...');
                }

            } else {
                $request->flash();
                return back()->with('msg','验证码错误');
            }
        }
        return back()->with('msg','注册失败');
        
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
        return redirect()->to('/login')->with('msg','成功退出登录');
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


    public function forget(Request $request)
    {
        
        return view('home.login.forgetpass');
    }


    public function set_password(Request $request)
    {
        try {
            if(isset($request->phone) && isset($request->check)) {
                $phone = $request->phone;

                $check = $request->check;

                $code = $request->session()->get($phone);

                if($code == $check) {
                    $request->session()->forget($phone);
                    $res = Homeuser::where('phone', $request->phone)->first();
                    set_user_id_cookie($res->id);
                    return view('home.login.password');
                    
                } else {
                    return back()->with('msg', '验证码错误'.$phone.'$code='.$code.'__'. $check);
                }
            }
            return back()->with('msg', '修改失败');
        } catch (\Exception $e) {
            return back()->with('msg', '修改失败');
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
    public function phone(Request $request)
    {
        $phone = $request->phone;

        $code = $request->session()->get($phone);

        if($code) {
            $request->session()->forget($phone);
        }

        $code = rand(100000,999999);

        $send = new Send;

        $res = [];
        $res = $send->send_message($phone,$code);
        if(isset($res['status']) && $res['status'] == 'success') {
            $request->session()->put($phone,$code);
            $res = $request->session()->get($phone);
            return json_encode(['status'=>true,'msg'=>'发送成功'.$res],256);
        }
        return json_encode(['status'=>false,'msg'=>'发送失败'],256);
    }
    /**
     * 微信登录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function wechat_login(Request $request)
    {
        try {
            $wechat = new \Wechat();

            $token = $wechat->access_token($_GET['code']);

            $info = $wechat->userinfo($token['access_token'],$token['openid']);
            $res = \DB::table('wechat')->where('openid',$info['openid'])->first();
            if(count($res)) {
                $user_id = $res->user_id;
                \DB::table('users')->where('id',$user_id)->update([
                    'last_login_time'=>time(),
                    'last_login_ip' => $request->getClientIp()
                    ]);
                \DB::table('wechat')->where('id',$user_id)->update([
                        'refresh_token' => $token['refresh_token'],
                        'access_token' => $token['access_token'],
                        'rtimeout' => time() + 2479200,
                        'timeout' => time() + 7000
                    ]);

                \DB::table('users')->where('id',$user_id)->increment('login');
                set_user_id_cookie($user_id);

                return redirect()->to('/');
            } else {
                $user_id = \DB::table('users')->insertGetId([
                        'name'=>$info['nickname'],
                        'last_login_time'=>time(),
                        'last_login_ip' => $request->getClientIp()
                    ]);
                \DB::table('wechat')->insert([
                        'user_id' => $user_id,
                        'openid' => $info['openid'],
                        'refresh_token' => $token['refresh_token'],
                        'access_token' => $token['access_token'],
                        'rtimeout' => time() + 2479200,
                        'timeout' => time() + 7000
                    ]);
                set_user_id_cookie($user_id);
                return redirect()->to('/');
            }
            
            
        } catch (\Exception $e) {
            return redirect()->to('/')->with('msg','微信授权失败');
        }
        
        
    }
    /**
     * 短信登录页面
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function sms(Request $request)
    {
        return view('home.login.sms');
    }
    /**
     * 处理短信登录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function sms_login(Request $request)
    {
        $phone = $request->phone;

        $check = $request->session()->get($phone);

        $code = $request->code;
        $res = \DB::table('users')->where('phone',$phone)->first();

        if(count($res) && $code && $check) {
            if($code == $check) {
                $request->session()->forget($phone);
                set_user_id_cookie($res->id);
                return redirect()->to('/');
            } else {
                return back()->with('msg','验证码错误');
            }
        } else {
            return back()->with('msg','登录失败');
        }
    }
}
