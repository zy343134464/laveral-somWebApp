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
        if(!count($user)) {
            return false;
        }
        //$res = checkpw($request->password,$res->password);
        if ($user->password == $request->password) {
            $user->last_login_time = time();
            $user->last_login_ip = $request->getClientIp();
            $user->login = $user->login + 1;
            $user->save();
            set_user_id_cookie($user->id,env('COOKIETIME'));
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
        $this->password = pw($request->phone);
        $this->source_organ_id = organ_ip($_SERVER['REMOTE_ADDR']);
        $res = $this->save();
        return $res;
    }
}
