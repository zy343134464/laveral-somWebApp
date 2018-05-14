<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.index.index');
    }
    public function clear()
    {
        $cache = \Storage::disk('storage')->allFiles('/framework/views/');
        unset($cache[array_search('framework/views/.gitignore', $cache)]);
        $res = \Storage::disk('storage')->delete($cache);
        if ($res) {
            echo '视图缓存清除成功';
        } else {
            echo '视图缓存清除失败';
        }
    }
    public function clear_pic()
    {
        echo '清除无效图片<br>';

        $cache = \Storage::disk('pic')->allFiles('/img/match/');

        unset($cache[array_search('img/match/.gitignore', $cache)]);

        foreach ($cache as $path) {
            if(strlen($path) == 48) continue;

            $str = $this->get_name($path);

            $res = \DB::table('matches')->where('pic','like','%'.$str.'%')->first();
            if(count($res)) continue;

            $res = \DB::table('raters')->where('pic','like','%'.$str.'%')->first();
            if(count($res)) continue;

            \Storage::disk('pic')->delete($path);
            $jpg =  strrchr($path, '.');

            $tag = strrpos($path, '.');

            $tag_pre = substr($path,0, $tag);

            $path2 = $tag_pre.'_s'.$jpg;

            \Storage::disk('pic')->delete($path2);
            echo '已删除__'.$path;
            echo '<br>';
        }

        $cache = \Storage::disk('pic')->allFiles('/img/user');
        unset($cache[array_search('img/user/.gitignore', $cache)]);

        foreach ($cache as $path) {
            $str = $this->get_name($path);
            $res = \DB::table('users')->where('pic','like','%'.$str.'%')->first();
            if(count($res)) continue;
            \Storage::disk('pic')->delete($path);
            echo '已删除__'.$path;
            echo '<br>';
        }

        $cache = \Storage::disk('pic')->allFiles('/img/produtions');
        unset($cache[array_search('img/produtions/.gitignore', $cache)]);
        foreach ($cache as $path) {
            $str = $this->get_name($path,15);
            $res = \DB::table('productions')->where('pic','like','%'.$str.'%')->first();
            if(count($res)) continue;
            \Storage::disk('pic')->delete($path);
            echo '已删除__'.$path;
            echo '<br>';
        }
        exit;
    }

    public function get_name($path,$length = 32)
    {
        $tag = strrpos($path, '.');

        $str = substr($path,$tag - $length, $length);
        return $str;
    }
}
