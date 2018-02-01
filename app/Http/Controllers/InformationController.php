<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Information;

class InformationController extends Controller
{
    /**
     * 咨询首页
     * @return [type] [description]
     */
    public function index()
    {
        $information = \DB::table('information')->Paginate(100);
        dd($information);
    }
    /**
     * 创建咨询页
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function create(Request $request)
    {
        return view('admin.information.create');
    }
    /**
     * 处理创建咨询
     * @param  Request     $request     [description]
     * @param  Information $information [description]
     * @return [type]                   [description]
     */
    public function store(Request $request, Information $information)
    {
        $information->add($request);
        return redirect()->to('admin/information');
    }
    /**
     * 编辑咨询页
     * @param  Information $information [description]
     * @param  [type]      $id          [description]
     * @return [type]                   [description]
     */
    public function edit(Information $information, $id)
    {
        \App::setLocale('es');
        $information = $information->find($id);
        if (count($information)) {
            return view('admin.information.edit', ['information'=>$information]);
        }
        return redirect()->back();
    }
    /**
     * 处理编辑咨询
     * @param  Request     $request     [description]
     * @param  Information $information [description]
     * @param  [type]      $id          [description]
     * @return [type]                   [description]
     */
    public function doedit(Request $request, Information $information, $id)
    {
        $information = $information->doedit($request, $id);
        return redirect()->to('admin/information');
    }
    /**
     * 删除咨询
     * @param  Information $information [description]
     * @param  [type]      $id          [description]
     * @return [type]                   [description]
     */
    public function del(Information $information, $id)
    {
        $information = $information->find($id);
        if (count($information)) {
            $information->delete();
        }
    }

    /**
     * 首页ajax获取资讯
     * @return [type] [description]
     */
    public function get_information()
    {
        $info = \DB::table('informations')->where(['id_top'=>1,'organ_id'=>organ('id')])->limit(20)->get();
        return json_encode($info);
    }
    /**
     * 展示资讯页
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function show_information(Request $request, $id)
    {
        $info = \DB::where('id', $id)->get();
        if (count($info)) {
            return view('home.informations', ['info'=>$info]);
        } else {
            return redirect()->to('/');
        }
    }
}
