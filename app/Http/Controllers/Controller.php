<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Excel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * get_uid_by_rid_oid 根据角色id和机构id获取用户id集合(一维索引数组)
     * @param  [int] 	$rid [角色id]
     * @param  [int] 	$oid [机构id]
     * @return [array]       [用户id数组]
     */
    public function get_uid_by_rid_oid($rid, $oid)
    {
        $res = DB::table('members')
                    ->select('uid')
                    ->where(['role_id'=>$rid,'organ_id'=>$oid])
                    ->get();
        $arr = [];
        foreach ($res as $v) {
            $arr[] = $v->uid;
        }
        return $arr;
    }
    /**
     * Excel导出
     * @param  [array] $cellData Excel数据
     * @param  string $filename 文件名
     * @return [file]           [下载]
     */
    public function downloadExcel($cellData, $filename = 'Excel')
    {
        Excel::create($filename, function ($excel) use ($cellData) {
            $excel->sheet('sheet', function ($sheet) use ($cellData) {
                $sheet->fromArray($cellData);
                $sheet->setWidth(array(
                    'A' => 10,
                    'B' => 10,
                    'C' => 10
                ));
            });
        })->export('xls');
    }
    /**
     * get_uid_by_vip  根据角色等级、类型和机构id获取用户id集合(一维索引数组)
     * @param  [int]    $lv   [角色等级]
     * @param  [string] $type [角色类型]
     * @param  [int] 	$oid  [机构id]
     * @return [array]        [用户id数组]
     */
    public function get_uid_by_vip($lv, $type, $oid)
    {
        $res = DB::table('roles')
                    ->select('id')
                    ->where(['role_type'=>$type,'role_level'=>$lv,'organ_id'=>$oid])
                    ->get();
        $arr = [];
        foreach ($res as $v) {
            $arr[] = $v->id;
        }
        $ures = DB::table('members')
                    ->select('uid')
                    ->whereIn('role_id', $arr)
                    ->get();
        $arr = [];
        foreach ($ures as $v) {
            $arr[] = $v->uid;
        }
        return $arr;
    }

    /**
     * 根据机构id获取获取所有等级的会员id、名字
     * @param  [int] $oid [机构id]
     * @param  [bool] $bool [默认true。搜索有效角色，false时搜索所有]
     * @return [array]    [机构会员(二维数组)]
     */
    public function organ_member($oid, $bool = true)
    {
        $res = DB::table('roles')
                    ->select('id as role_id', 'role_name')
                    ->where('organ_id', $oid)
                    ->when($bool, function ($query) {
                        return $query->where('role_level', '>', 0);
                    })
                    ->get()
                    ->toArray();
        return json_decode(json_encode($res), true);
    }
    /**
    * 根据机构id获取获取所有角色类型
    * @param  [int] $oid [机构id]
    * @param  [bool] $bool [默认true。搜索有效角色，false时搜索所有]
    * @return [array]    [机构角色类型]
    */
    public function organ_role_type($oid, $bool = true)
    {
        $res = DB::table('roles')
                    ->select('role_type')
                    ->where('organ_id', $oid)
                    ->when($bool, function ($query) {
                        return $query->where('role_level', '>', 0);
                    })
                    ->groupBy('role_type')
                    ->get()
                    ->toArray();
        return json_decode(json_encode($res), true);
    }
}
