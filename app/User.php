<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    public function member()
    {
        return $this->hasMany('App\Member', 'uid', 'id');
    }
    
    public function role($uid, $oid)
    {
        $rid = DB::table('members')
                    ->select('role_id')
                    ->where(['uid'=>$uid,'organ_id'=>$oid])
                    ->get();
        $str = '';
        foreach ($rid as $v) {
            $str .= ' ';
            $res = DB::table('roles')
                        ->select('role_name')
                        ->where('id', $v->role_id)
                        ->get();
            $str .= $res[0]->role_name;
        }
        return $str;
    }
    /**
     * [login 处理登录]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function login(Request $request)
    {
        $user = $this->where(['phone'=>$request->phone])->first();
        if (!count($user)) {
            return false;
        }
        if (checkpw($request->password, $user->password)) {
            $user->last_login_time = time();
            $user->last_login_ip = $request->getClientIp();
            $user->login = $user->login + 1;
            $user->save();
            set_user_id_cookie($user->id, env('COOKIETIME'));
            return true;
        } else {
            return false;
        }
    }
    /**
     * [reg 注册用户]
     * @param  Request $request [description]
     * @return [Boolean]        [注册结果]
     */
    public function reg(Request $request)
    {
        $this->phone = $request->phone;
        $this->password = pw($request->password);
        if ($request->name) {
            $this->name = $request->name;
        } else {
            $this->name = '未命名用户'.time();
        }
        $this->source_organ_id = organ('id');
        $res = $this->save();
        return $res;
    }


   
    public function is_admin($uid)
    {
        $res = DB::table('admins')->where(['user_id'=>$uid,'organ_id'=>$organ('id')])->first();
        if (count($res)) {
            return true;
        }
        return false;
    }
    
    /**
     * [edit 编辑资料]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function edit(Request $request, $uid)
    {
        $user = $this->find($uid);
        if ( $user ) {
            $user->name = $request->name;
            $user->country = $request->country;
            $user->sex = $request->sex;
            $user->city = $request->city;
            $user->birthday = $request->birthday;
            $user->introdution = $request->introdution;
            if ( $request->pic != '' ) {
                $path = save_match_pic($request->pic);
                $user->pic = $path;
            }
            $user->job = $request->job;
            $user->save();
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * [edit 修改密码]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function editPassword(Request $request, $uid)
    {
        $result = [ 'status' => false, 'msg' => ''];
        $user = $this->find($uid);
        if ( $user ) {
            if ( !checkpw($request->currentpassword, $user->password)) {
                $result['msg'] = '原有密码错误';
                return $result;
            }
            if ($request->surenewpassword == '' || $request->newpassword == '' ) {
                $result['msg'] = '新密码不能为空';
                return $result;
            }
            if ($request->surenewpassword != $request->newpassword ) {
                $result['msg'] = '新密码输入不一致';
                return $result;
            }
            $user->password = pw($request->surenewpassword);
            $user->save();
            $result['status'] = true;
            return $result;
        } else {
            $result['msg'] = '找不到该账号';
            return $result;
        }
    }
    
}
