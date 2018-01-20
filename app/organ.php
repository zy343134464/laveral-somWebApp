<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organ extends Model
{
    public function oid($str)
    {
        $res = $this->where('ip', $str)->first()->toArray();
        if (count($res)) {
            return $res['name'];
        } else {
            return no404();
        }
    }
}
