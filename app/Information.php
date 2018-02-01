<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Information extends Model
{
    public function add(Request $request)
    {
        $this->title = $request->title;
        $this->sec_title = $request->sec_title ? $request->sec_title : '';
        $this->detail = save_ueditor($request->content);
        $this->save();
    }
    public function doedit(Request $request, $id)
    {
        $res = $this->find($id);
        if (count($res)) {
            $res->title = $request->title;
            $res->sec_title = $request->sec_title ? $request->sec_title : '';
            $res->detail = save_ueditor($request->content);
            $res->save();
        }
    }
}
