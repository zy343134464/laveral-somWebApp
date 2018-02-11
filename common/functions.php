<?php

use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\Storage;

/**
 * 密码加密
 * @param  [type] $password 要加密的password
 * @return [type]           加密后的password
 */
function pw($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}
/**
 * 对比密码是否一样
 * @param  [type] $password 需要对比的密码
 * @param  [type] $hash     经加密的hash密码
 * @return 返回 true false
 */
function checkpw($password, $hash)
{
    return password_verify($password, $hash);
}


function organ_info($ip, $str)
{
    $res = DB::table('organs')->where('host', $ip)->first();
    if (count($res)) {
        return $res->$str;
    } else {
        return null;
    }
}

/**
 * 保存用户ID到cookie
 * @param [type] $uid [description]
 * @param [type] $min 保存时长
 */
function set_user_id_cookie($uid, $min)
{
    Cookie::queue('user_id', $uid, $min);
}

/**
 * 退出登录,删除cookie
 * @return [type] [description]
 */
function logout()
{
    Cookie::queue(Cookie::forget('user_id'));
}
/**
 * 查询机构信息
 * @param  [type] $str 需要查询的内容
 * @return [type]      返回结果
 */
function organ($str)
{
    //$res = \DB::table('organs')->where('host',$_SERVER['SERVER_NAME'])->first();
    $res = \DB::table('organs')->select($str)->where('id', 1)->first();

    if (count($res)) {
        return $res->$str;
    } else {
        return 'unknow';
    }
}
function user($str)
{
    $id = \Cookie::get('user_id');
    if (isset($id)) {
        $res = \DB::table('users')->find($id);
        if(!count($res)) { 
            logout();
            return 'error';
        }
        return $res->$str;
    }
    logout();
    return 'error';
}

/**
 * 查询比赛信息
 * @param  [type] $id  赛事id
 * @param  [type] $str 要查询的信息
 * @return [type]      查询结果
 */
function match($id, $str)
{
    $res = \DB::table('matches')->select($str)->where('id', $id)->first();

    if (count($res)) {
        return $res->$str;
    } else {
        return null;
    }
}
/**
 * 保存新建比赛上传的图片
 * @param  [type] $path 临时路径
 * @return [type]       保存路径
 */
function save_match_pic($path)
{
    //过滤已经保存的图片
    if($path[0] != 'f') {
        return $path;
    }
    $path = 'uploadtemp/'.$path;
    $new = 'img/match/'.substr($path, strripos($path, '\\') + 1);
    if (!Storage::disk('pic')->exists($new)) {
        if (Storage::disk('pic')->exists($path)) {
            Storage::disk('pic')->move($path, $new);
        }
    }
    return $new;
}
function uploadimg($path)
{
    //过滤已经保存的图片
    if($path[0] != 'f') {
        return $path;
    }
    $path = 'uploadtemp/'.$path;
    $new = 'img/produtions/'.substr($path, strripos($path, '\\') + 1);
    if (!Storage::disk('pic')->exists($new)) {
        if (Storage::disk('pic')->exists($path)) {
            Storage::disk('pic')->move($path, $new);
        }
    }
    return $new;
}

function del_match_pic($path)
{
    //过滤已经保存的图片
    if (Storage::disk('pic')->exists($path)) {
        Storage::disk('pic')->delete($path);
    }
    
}

/**
 * 处理富文本上传的图片路经
 * @param  [str] $str 富文本内容
 * @return [str]      处理后的富文本内容
 */
function save_ueditor($str)
{
    preg_match_all('#src="([^"]+?)"#', $str, $arr);
    foreach ($arr[1] as $v) {
        $new = 'img/ueditor/image/'.substr($v, strripos($v, '/') + 1);
        if (Storage::disk('pic')->exists($new)) {
            continue;
        }
        if (Storage::disk('pic')->exists($v)) {
            Storage::disk('pic')->move($v, $new);
        }
    }
    return preg_replace('#/uploadtemp/ueditor/image#', '/img/ueditor/image/', $str);
}

/**
 * 临时方案
 * @param  [type] $arr  [description]
 * @param  [type] $k    [description]
 * @param  [type] $type [description]
 * @return [type]       [description]
 */
function arrtorater($arr,$k,$type)
{
    //return '';
    if(is_array($arr)) {
        $str = '';
        foreach ($arr as  $v) {
            $res = \DB::table('users')->where('id',$v)->first();
            if(count($res)) {
                 $str .= '<li>
                <a href="#">
                    <input type="hidden" name="rater'.$type.'['.($k - 1).'][]" value="'.$res->id.'">
                    <img src="/'.$res->pic.'" alt="">
                    <p>'.$res->name.'</p>
                    <div class="close"><i class="fa fa-close"></i></div>
                </a>
            </li>';
            }
        }
        return $str;
    }
}