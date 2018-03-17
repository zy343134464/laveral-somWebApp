<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function edit($data)
    {
        $info = $this->find($data['id']);
        if ($info) {
            foreach ($data as $key => $val) {
                $info->$key = $val;
            }
            $info->save();
            return true;
        }
        return false;
    }
    
    public function add($data)
    {
        if ($data) {
            foreach ($data as $key => $val) {
                $this->$key = $val;
            }
            $this->save();
            return $this->id;
        }
        return false;
    }
    
    public function setData($request)
    {
        //获取原有角色信息
        $roles = $this->select('*')->where([ 'organ_id' => $request->oid, 'status' => 0 ])->get();
        //根据提交的内容更新，原有的更新，新加的进行添加
        foreach ($roles as $val) {
            $paramsId = 'role_id_' . $val->id;
            if (isset($request->$paramsId)) {
                foreach ($val as $key => $v) {
                    $param = 'role_' . $key . '_' . $val->id;
                    $val->$key = $request->$param;
                }
                $val->save();
            }
        }
    }
}
