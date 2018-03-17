<?php

namespace App\Admin;

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
    
    public function getname($id)
    {
        $user = $this->find($id);
        return $user->name;
    }
    public function is_admin($uid)
    {
        $res = DB::table('admins')->where(['user_id'=>$uid,'organ_id'=>$organ('id')])->first();
        if (count($res)) {
            return true;
        }
        return false;
    }
    public function reg($request)
    {
        /* $this->name = $request->name;
        $this->phone = $request->phone;
        $this->password = pw($request->password);
        $this->save(); */
        $uid = DB::table('users')->insertGetId(
            ['name' => $request->name, 'phone' => $request->phone, 'password' => pw($request->password)]
        );
        
        //默认成为som会员
        $memberid = DB::table('members')->insertGetId(
            ['uid' => $uid, 'organ_id' => 1, 'role_type' => 'vip', 'start_time' => time(), 'role_id' => 11]
        );
        return true;
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
}
