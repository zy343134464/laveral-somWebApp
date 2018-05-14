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

/**
 * 机构信息
 * @param  string $host  机构域名
 * @param  string $field 字段
 * @return [type]        [description]
 */
function organ_info($host = '' , $field = 'id')
{
    $exists = Storage::disk('config')->exists('organ.json');
    if(!$exists) refresh_organ();
    $host = $host ? $host : $_SERVER['HTTP_HOST'];
    $date = Storage::disk('config')->get('organ.json');
    $res = json_decode($date,true);

    if (count($res)) {

        return isset($res[$host][$field]) ? $res[$host][$field] : null;
    } else {
        return 'null';
    }
    
}
/**
 * 更新数据库机构信息到文件缓存
 * @return [type] [description]
 */
function refresh_organ()
{
    $organ = DB::table('organs')->get();
    $organ = json_decode(json_encode($organ),true);

    $arr = [];
    foreach ($organ as  $ov) {
        $arr[$ov['host']] = $ov;
    }
    $str = json_encode($arr);
    Storage::disk('config')->put('organ.json',$str);
}

/**
 * 保存用户ID到cookie
 * @param [type] $uid [description]
 * @param [type] $min 保存时长
 */
function set_user_id_cookie($uid, $min = '')
{
    $min = $min ? $min : env('COOKIETIME') ;
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
function organ($str = 'id')
{
    //$res = \DB::table('organs')->where('host',$_SERVER['SERVER_NAME'])->first();
    $res = \DB::table('organs')->select($str)->where('id', 1)->first();

    if (count($res)) {
        return $res->$str;
    } else {
        return 'unknow';
    }
}
/**
 * 用户信息
 * @param  string $str 默认为空,获取id
 * @return [type]      [description]
 */
function user($str = 'id')
{
    // if($str == '') {
    //     $str = 'id';
    // }
    $id = \Cookie::get('user_id');
    if (isset($id)) {
        $res = \DB::table('users')->select($str)->find($id);
        if(!count($res)) { 
            logout();
            return '';
            return 'error';
        }
        return $res->$str;
    }
    logout();
    return '';
    return 'error';
}
/**
 * 判断管理员
 * @return boolean [description]
 */
function is_admin()
{
    $id = \Cookie::get('user_id');
    if(!isset($id)) return false;
    $res = \DB::table('admins')->select('is_admin')->where('user_id',$id)->first();
    if(!count($res) || !$res->is_admin) return false;
    return true;

}
/**
 * 判断评委
 * @return boolean [description]
 */
function is_rater()
{
    $res = \DB::table('rater_match')->select('status')->where(['user_id'=>user('id')])->whereIn('status',[0,1,2])->first();
    if(count($res)) return true;

    return false;

}
/**
 * 临时处理报名
 * @param  [type] $match_id  赛事id
 */
function is_join_match($match_id)
{
    $user_id = user();
    if($user_id) {
        $res = \DB::table('productions')->select('id')->where('user_id',$user_id)->where('match_id',$match_id)->first();
        if(count($res)) return true;
    }
    return false;
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
function save_match_pic($date)
{
    //过滤已经保存的图片
    try {
        
        //第一种上传:base64
        if($date[0] == 'd') {
            
            list($msec, $sec) = explode(' ', microtime());

            $url = explode(',', $date);

            if($date[11] == 'p') {
                //png格式保存
                $postfix = '.png';
            } elseif($date[11] == 'j') {
                //jpg格式保存
                $postfix = '.jpg';
            } else {
                return 'img/404.jpg';
            }
            //赛事海报、评委头像
            $name = 'img/match/'.md5($_SERVER["REQUEST_TIME"] .$msec.$sec).$postfix;

            file_put_contents($name, base64_decode($url[1]));//返回的是字节数
            
            //生成所列图
            save_pic_s($name);

            return $name;
        }

        //过滤已经保存的图片
        //第二种即时上传
        if($date[0] == 'f') {
            $date = 'uploadtemp/'.$date;
            $new = 'img/match/'.substr($date, strripos($date, '\\') + 1);
            if (!Storage::disk('pic')->exists($new)) {
                if (Storage::disk('pic')->exists($date)) {
                    Storage::disk('pic')->move($date, $new);
                }
            }
            return $new;
        }
        //组图上传_
        if($date[0] == 'u') {
            if($date[11] == 't') {
                //上传作品
                $new = 'img/produtions/'.substr($date, 16);
            } else {
                //上传赛事海报(应该报废)
                $new = 'img/match/'.substr($date, 11);
            }

            $new = 'img/produtions/'.substr($date, 16);
            if (!Storage::disk('pic')->exists($new)) {
                if (Storage::disk('pic')->exists($date)) {
                    Storage::disk('pic')->move($date, $new);
                }
            }
            return $new;
        }

        return $date;
    } catch (\Exception $e) {
        return false;
    }
    // 即时上传插件  1
    // //过滤已经保存的图片
    // $path = 'uploadtemp/'.$path;
    // $new = 'img/match/'.substr($path, strripos($path, '\\') + 1);
    // if (!Storage::disk('pic')->exists($new)) {
    //     if (Storage::disk('pic')->exists($path)) {
    //         Storage::disk('pic')->move($path, $new);
    //     }
    // }
    // return $new;
}
/**
 * 保存用户头像图片
 * @param  [type] $date [description]
 * @return [type]       [description]
 */
function save_user_pic($date)
{
    //过滤已经保存的图片
    //第一种上传:base64
    if($date[0] == 'd') {
        
        list($msec, $sec) = explode(' ', microtime());

        $url = explode(',', $date);

        $name = 'img/user/'.md5($_SERVER["REQUEST_TIME"] .$msec.$sec).'.jpg';

        file_put_contents($name, base64_decode($url[1]));//返回的是字节数

        return $name;
    }

    //过滤已经保存的图片
    //第二种即时上传
    if($date[0] == 'f') {
        $date = 'uploadtemp/'.$date;
        $new = 'img/user/'.substr($date, strripos($date, '\\') + 1);
        if (!Storage::disk('pic')->exists($new)) {
            if (Storage::disk('pic')->exists($date)) {
                Storage::disk('pic')->move($date, $new);
            }
        }
        return $new;
    }
    return $date;
    // 即时上传插件  1
    // //过滤已经保存的图片
    // $path = 'uploadtemp/'.$path;
    // $new = 'img/match/'.substr($path, strripos($path, '\\') + 1);
    // if (!Storage::disk('pic')->exists($new)) {
    //     if (Storage::disk('pic')->exists($path)) {
    //         Storage::disk('pic')->move($path, $new);
    //     }
    // }
    // return $new;
}
/**
 * 删除赛事海报图片
 * @param  [type] $path [description]
 * @return [type]       [description]
 */
function del_match_pic($path)
{
    
    if(!$path) return false;
    //过滤已经保存的图片
    if (Storage::disk('pic')->exists($path)) {
        $res = \DB::table('matches')->where('pic',$path)->limit(2)->get();
        if(count($res) == 2) return false;
        //删除大图
        Storage::disk('pic')->delete($path);

        $jpg =  strrchr($path, '.');

        $tag = strrpos($path, '.');

        $tag_pre = substr($path,0, $tag);

        $path2 = $tag_pre.'_s'.$jpg;
        //删除缩略图
        Storage::disk('pic')->delete($path2);

    }
    
}
/**
 * 前端图片展示优先级  缩略图 > 原图 > 404
 * @param  [type] $path [description]
 * @return [type]       [description]
 */
function show_pic($path)
{

    $jpg =  strrchr($path, '.');

    $tag = strrpos($path, '.');

    $tag_pre = substr($path,0, $tag);

    $path2 = $tag_pre.'_s'.$jpg;

    if (Storage::disk('pic')->exists($path2)) {
        return url($path2);
    }

    if (Storage::disk('pic')->exists($path)) {
        return url($path);
    }

    return url('img/404.jpg');

}
/**
 * 删除用户头像
 * @param  [type] $path [description]
 * @return [type]       [description]
 */
function del_user_pic($path)
{
    
    if(!$path) return false;
    //过滤已经保存的图片
    if (Storage::disk('pic')->exists($path)) {
        $res = \DB::table('users')->select('pic')->where('pic',$path)->limit(2)->get();
        if(count($res) == 2) return false;
        Storage::disk('pic')->delete($path);
    }
    
}
/**
 * 上传图片
 * @param  [type] $path [description]
 * @return [type]       [description]
 */
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
 * 临时方案  新建赛事--评选设定--参与评委
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
function check_pic($id)
{
    $pic = \DB::table('productions')->find($id);
    if(count($pic)) {
        return true;
    }
    return false;
}
/**
 * 等比例生成缩略图
 * @param  [type]  $imgSrc        原图路径
 * @param  integer $resize_width  修改后的宽
 * @param  integer $resize_height 修改后的高
 * @param  boolean $isCut         是否剪裁图片
 * @return [type]                 [description]
 */
function save_pic_s($imgSrc, $resize_width = 354, $resize_height = 230, $isCut = false) {
    $imgSrc =  public_path($imgSrc);
    //图片的类型
    $type = substr(strrchr($imgSrc, "."), 1);
    //初始化图象
    if ($type == "jpg") {
        $im = imagecreatefromjpeg($imgSrc);
    }
    if ($type == "gif") {
        $im = imagecreatefromgif($imgSrc);
    }
    if ($type == "png") {
        $im = imagecreatefrompng($imgSrc);
    }
    //目标图象地址
    $full_length = strlen($imgSrc);
    $type_length = strlen($type);
    $name_length = $full_length - $type_length;
    $name = substr($imgSrc, 0, $name_length - 1);
    $dstimg = $name . "_s." . $type;

    $width = imagesx($im);
    $height = imagesy($im);

    //生成图象
    //改变后的图象的比例
    $resize_ratio = ($resize_width) / ($resize_height);
    //实际图象的比例
    $ratio = ($width) / ($height);
    if (($isCut) == 1) { //裁图
        if ($ratio >= $resize_ratio) { //高度优先
            $newimg = imagecreatetruecolor($resize_width, $resize_height);
            imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_width, $resize_height, (($height) * $resize_ratio), $height);
            ImageJpeg($newimg, $dstimg);
        }
        if ($ratio < $resize_ratio) { //宽度优先
            $newimg = imagecreatetruecolor($resize_width, $resize_height);
            imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_width, $resize_height, $width, (($width) / $resize_ratio));
            ImageJpeg($newimg, $dstimg);
        }
    } else { //不裁图
        if ($ratio >= $resize_ratio) {
            $newimg = imagecreatetruecolor($resize_width, ($resize_width) / $ratio);
            imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_width, ($resize_width) / $ratio, $width, $height);
            ImageJpeg($newimg, $dstimg);
        }
        if ($ratio < $resize_ratio) {
            $newimg = imagecreatetruecolor(($resize_height) * $ratio, $resize_height);
            imagecopyresampled($newimg, $im, 0, 0, 0, 0, ($resize_height) * $ratio, $resize_height, $width, $height);
            ImageJpeg($newimg, $dstimg);
        }
    }
    ImageDestroy($im);
}
/**
 * 作品信息
 * @return [array] 
 */
function production_info()
{
    $arr = [];

    $arr['author'] = '作者姓名';
    $arr['title'] = '作品标题';
    $arr['detail'] = '文字描述';
    $arr['represent'] = '代表单位';
    $arr['year'] = '年份';
    $arr['country'] = '国籍';
    $arr['location'] = '拍摄地点';
    $arr['size'] = '作品尺寸';

    return $arr;
}