@extends('admin.app')
@section('content-header')
    <h1>
        用户管理
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li>角色管理 </li>

        <li class="active"> <a href="{{ url('login') }}">登录</a></li>
    </ol>
@stop

@section('content')

    <h2 class="page-header">角色列表</h2>
    <a href="{{ url('admin/role/create') }}" class="btn btn-sm btn-success">添加角色</a>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">列表页</h3>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered">
                <tbody>
                <!--tr-th start-->
                <tr>
                    <th>ID</th>
                    <th>角色名</th>
                    <th>付费等级</th>
                    <th>机构id</th>
                    <th>操作</th>
                </tr>
                <!--tr-th end-->
                @if(count($roles))
                @foreach($roles as $role)
                    <tr>
                        <td class="text-muted">{{$role->id}}</td>
                        <td class="text-muted">{{$role->role_name}}</td>
                        <td class="text-muted">{{$role->vip_level}}</td>
                        <td class="text-navy">{{$role->organ_id}}</td>
                        <td>
                            <a style="font-size: 16px;padding: 4px;" href="{{ url('/admin/role/edit').'/'.$role->id}}" class="ui button"><i class="fa fa-fw fa-pencil" title="修改"></i></a>
                            <a style="font-size: 16px;padding: 4px;" href="{{ url('/admin/role/del').'/'.$role->id}}" class="ui button"><i class="fa fa-fw fa-trash-o" title="删除"></i></a>
                            
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="6" style="color:red;">暂无数据</td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

