<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /**
     * 添加会员
     * @param unknown $data
     * @return boolean
     */
    public function add($data, $role)
    {
        $this->uid = $data['uid'];
        $this->organ_id = $data['organ_id'];
        $this->role_id = $data['role_id'];
        $this->role_type = $role->role_type;
        $this->start_time = time();

        if ($role->free == 0) {
            $this->vip_start = time();
        }
        //0为永久
        if ($role->cycle == 0) {
            $this->end_time = -1;
        } else {
            $this->end_time = $role->cycle * 86400 + time();
        }

        $res = $this->save();
        return $res;
    }
}
