<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\Match;
use Illuminate\Support\Facades\Storage;
use App\Production;

class MatchController extends Controller
{
    /**
     * 赛事详情
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function detail(Request $request, Match $match, $id)
    {
        $res = $match->info($id);
        if (!$res) {
            return back();
        }
        $user_id = user();
        $join = Production::where(['match_id'=>$id,'status'=>2])->when($user_id,function($query) use($user_id){
                return $query->where('user_id',$user_id);
            })->count();
        return view('home.match.show', ['match'=>$res,'id'=>$id,'join'=>$join]);
    }
    /**
     * 赛事声明
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function statement(Request $request,Match $match, $id)
    {
        $res = $match->info($id);
        if (!$res) {
            return back();
        }
        return view('home.match.statement',['match'=>$res,'id'=>$id]);
    }
    /**
     * 报名表
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function form(Request $request,Match $match,$id)
    {
        $res = $match->info($id);
        if (!$res) {
            return back();
        }
        return view('home.match.form',['match'=>$res,'id'=>$id]);
    }
    /**
     * 参赛填写表单
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function join(Request $request, $id)
    {
        
        $user_id = user();
        if($user_id) {

            $res = \DB::table('user_match')->where(['user_id'=>user(),'match_id'=>$id])->first();
            if(!count($res)) {
                \DB::table('user_match')->insert(['user_id'=>user(),'match_id'=>$id,'created_at'=>time()]);

            }
            return redirect()->to('match/uploadimg/'.$id);
        } else {
            return back();
        }
    }
    /**
     * 上传作品页面
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function uploadimg(Request $request, $id)
    {
        $require_personal = \DB::table('require_personal')->where('match_id', $id)->first();

        if(!count($require_personal)) return back()->with('该赛事未设置投稿要求');

        // $res = \DB::table('user_match')->where(['user_id'=>user(),'match_id'=>$id])->get();
        // if(!count($res)) {
        //     \DB::table('user_match')->insert(['user_id'=>user(),'match_id'=>$id,'num'=>20,'status'=>1,'created_at'=>time()]);
        // }
        return view('home.match.uploadimg', ['id'=>$id, 'personal'=>$require_personal]);
    }
    
    /**
     * 参赛__上传组图__插件上传图片
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function upload(Request $request)
    {
        $typeArr = array("jpg","jpeg", "png");
        //允许上传文件格式
        //$path = public_path()."uploadtemp/temp";
        $path = "uploadtemp/temp/";
        //上传路径

        //if (!file_exists($path)) {
        //  mkdir($path);
        //}

        if (isset($_POST)) {
            $name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $name_tmp = $_FILES['file']['tmp_name'];
            if (empty($name)) {
                return json_encode(array("error" => "您还未选择图片"));
                exit ;
            }
            $type = strtolower(substr(strrchr($name, '.'), 1));
            //获取文件类型

            if (!in_array($type, $typeArr)) {
                return json_encode(array("error" => "请上传jpg,jpeg或png类型的图片！"));
                exit ;
            }
            if ($size > (5000 * 1024)) {
                return json_encode(array("error" => "图片大小已超过5000KB！"));
                exit ;
            }

            $pic_name = time() . rand(10000, 99999) . "." . $type;
            //图片名称
            $pic_url = $path . $pic_name;
            //上传后图片路径+名称
            if (move_uploaded_file($name_tmp, $pic_url)) {//临时文件转移到目标文件夹
                return json_encode(array("error" => "0", "pic" => $pic_url, "name" => $pic_name));
            } else {
                return json_encode(array("error" => "上传有误，清检查服务器配置！"));
            }
        }
    }

    
    /**
     * 组图上传图片
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function douploadimgs(Request $request, Match $match, $id)
    {
        
        try {
            \DB::beginTransaction();
            $user_id = user();
            Production::where(['user_id'=>$user_id,'match_id'=>$id])->whereIn('status',[0,1])->delete();
            $personal = \DB::table('require_personal')->where('match_id',$id)->first();

            $info = json_decode($personal->production_info);
            $diy = json_decode($personal->diy_info);
            $diy_able = count($diy) && count($diy[0]) ? count($diy[0]) : false;
            $db = [];
            
            //上传组图
            foreach (json_decode($request->data,true)[1] as $inputv) {
                $temp = [];
                if ($request->method == 1) {
                    $status = 2;
                } else {
                    $status = 1;
                }


                foreach ($info[0] as $infok => $infov) {

                    if(isset($inputv[$infov])) {
                        $temp[$infov] = $inputv[$infov];
                        if($inputv[$infov] == '' && $info[1][$infok]) $status = 0;
                    }

                    
                    
                }

                if($diy_able) {
                    $diy_info = [];

                    foreach ($diy[0] as $diyk => $diyv) {
                        if(isset($inputv['defined'.$diyk])) {
                            $diy_info[$diyk]['key'] = $diyv;
                            $diy_info[$diyk]['value'] = $inputv['defined'.$diyk];
                        
                            if($inputv['defined'.$diyk] == '' && $diy[1][$diyk]) $status = 0;
                        }
                    }

                    $temp['diy_info'] = json_encode($diy_info,JSON_UNESCAPED_UNICODE);

                }
                $img_temp = [];

                foreach ($inputv['pic'] as $img) {
                    $img_temp[] = save_match_pic($img);
                    //$img_temp[] = $img;
                }

                $temp['pic'] = json_encode($img_temp,JSON_UNESCAPED_UNICODE);
                $temp['type'] = 1;
                $temp['user_id'] = $user_id;
                $temp['status'] = $status;
                $temp['match_id'] = $id;
                Production::insertGetId($temp);
                $db[] = $temp;
                //\DB::commit();
                //return json_encode(['msg'=>'上传成功','data'=>true],JSON_UNESCAPED_UNICODE);
            }
            //上传单张
            foreach (json_decode($request->data,true)[0] as $inputv) {
                $temp = [];
                if ($request->method == 1) {
                    $status = 2;
                } else {
                    $status = 1;
                }
                foreach ($info[0] as $infok => $infov) {
                    if(isset($inputv[$infov])) {
                        $temp[$infov] = $inputv[$infov];
                    
                        if($inputv[$infov] == '' && $info[1][$infok]) $status = 0;
                    }
                }

                if($diy_able) {
                    $diy_info = [];

                    foreach ($diy[0] as $diyk => $diyv) {
                        if(isset($inputv['defined'.$diyk])) {
                            $diy_info[$diyk]['key'] = $diyv;
                            $diy_info[$diyk]['value'] = $inputv['defined'.$diyk];
                        
                            if($inputv['defined'.$diyk] == '' && $diy[1][$diyk]) $status = 0;
                        }
                    }


                    $temp['diy_info'] = json_encode($diy_info,JSON_UNESCAPED_UNICODE);
                }

                $temp['pic'] = save_match_pic($inputv['pic']);;
                $temp['type'] = 0;
                $temp['user_id'] = $user_id;
                $temp['status'] = $status;
                $temp['match_id'] = $id;

                Production::insertGetId($temp);
                $db[] = $temp;
            }
            unset($db);
            \DB::commit();

            return json_encode(['msg'=>'上传成功','data'=>true],JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            \DB::rollback();
            return json_encode(['msg'=>'上传失败','data'=>false],JSON_UNESCAPED_UNICODE);
        }
        
        $match->uploadimgs($request,$id);
    }


    /**
     * ajax获取用户在赛事中的作品
     * @param  Request $request [description]
     * @param  Match   $match   [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function ajax_match_pic(Request $request, Match $match, $id)
    {
        $data = [];
        $personal = \DB::table('require_personal')->select('diy_info','production_info')->where('match_id',$id)->first();
        $must = json_decode($personal->production_info);
        $diy = json_decode($personal->diy_info);

        $field = $must[0];
        $field[] = 'diy_info';
        $field[] = 'pic';
        $field[] = 'status';

        $input = production_info();

        $pic = Production::select($field)->where(['user_id'=>user(),'match_id'=>$id,'type'=>0])->whereIn('status',[0,1])->get();
        

        if(count($pic)) {
            $pic = $pic->toArray();

            foreach ($pic as &$v) {

                $diy_info = json_decode($v['diy_info'],true);
                if($must[0]) {
                    // foreach ($must[0] as $mk => $mv) {
                    //     // $temp = [];
                    //     // $temp['key'] = $input[$mv];
                    //     // $temp['name'] = $mv;
                    //     // $temp['value'] = $v[$mv];
                    //     // $temp['require'] = $must[1][$mk];
                    //     // $v[$mv] = $temp;

                    // }
                    
                }
                $temp = [];

                if($diy) {
                    $temp = [];
                    if($diy[0]) {
                        foreach ($diy[0] as $dk => $dv) {
                              // $temp[$dk]['key'] = $dv;
                            // $temp[$dk]['name'] = 'defined'.$dk;
                            
                            // $temp[$dk]['value'] = isset($diy_info[$dk]['value']) ? $diy_info[$dk]['value'] : '';
                            $v['defined'.$dk] = isset($diy_info[$dk]['value']) ? $diy_info[$dk]['value'] : '';
                            // $temp[$dk]['require'] = $diy[1][$dk];
                            
                            //$temp[$dk] = isset($diy_info[$dk]['value']) ? $diy_info[$dk]['value'] : '';
                        }
                    }
                        
                    $v['diy_info'] = [];
                }
                
            }
        } else {
            $pic = [];
        }

        $data[] = $pic;

        $pic = Production::select($field)->where(['user_id'=>user(),'match_id'=>$id,'type'=>1])->whereIn('status',[0,1])->get();
        

        if(count($pic)) {
            $pic = $pic->toArray();

            foreach ($pic as &$v) {

                $diy_info = json_decode($v['diy_info'],true);

                // foreach ($must[0] as $mk => $mv) {
                //     // $temp = [];
                //     // $temp['key'] = $input[$mv];
                //     // $temp['name'] = $mv;
                //     // $temp['value'] = $v[$mv];
                //     // $temp['require'] = $must[1][$mk];
                //     // $v[$mv] = $temp;
                // }
                $temp = [];

                if($diy) {
                    $temp = [];
                    if($diy[0]) {
                        foreach ($diy[0] as $dk => $dv) {
                            // $temp[$dk]['key'] = $dv;
                            // $temp[$dk]['name'] = 'defined'.$dk;

                            // $temp[$dk]['value'] = isset($diy_info[$dk]['value']) ? $diy_info[$dk]['value'] : '';
                            $v['defined'.$dk] = isset($diy_info[$dk]['value']) ? $diy_info[$dk]['value'] : '';
                            // $temp[$dk]['require'] = $diy[1][$dk];
                            
                            //$temp[$dk] = isset($diy_info[$dk]['value']) ? $diy_info[$dk]['value'] : '';
                        }
                        
                    }
                    $v['diy_info'] = [];
                }
                $v['pic'] = json_decode($v['pic']);
                
            }
        } else {
            $pic = [];
        }

        $data[] = $pic;


        return stripslashes(json_encode($data,JSON_UNESCAPED_UNICODE));
    }
    /**
     * 微博借口test
     * @return [type] [description]
     */
    public function weibo() {
        return \Socialite::with('weibo')->redirect();
        // return \Socialite::with('weibo')->scopes(array('email'))->redirect();
    }

    /**
     * 微博测试
     * @return function [description]
     */
    public function callback() {
        $oauthUser = \Socialite::with('weibo')->user();

        var_dump($oauthUser->getId());
        var_dump($oauthUser->getNickname());
        var_dump($oauthUser->getName());
        var_dump($oauthUser->getEmail());
        var_dump($oauthUser->getAvatar());
    }
    
}
