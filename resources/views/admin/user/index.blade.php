@extends('admin.app')
@section('content-header')
    <h1>
        用户管理
        <small>用户列表</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li>用户管理 </li>

        <li class="active"> <a href="{{ url('login') }}">登录</a></li>
    </ol>
@stop

@section('content')

    <h2 class="page-header">用户列表</h2>
    <a href="{{ url('admin/user/create') }}" class="btn btn-sm btn-success">添加用户</a>
    <a href="{{ url('admin/user/infoall') }}" target="_blank" class="btn btn-sm btn-default">导出所有用户信息</a>
    <a href="{{ url('admin/user/getfeild') }}" target="_blank" class="btn btn-sm btn-default">下载批量新建用户.xls</a>
    <hr>
    <form action="{{ url('admin/user/addusers') }}"  enctype="multipart/form-data" method="post">
         {{ csrf_field() }}
        <input type="file" name="excel" >
        <input type="submit" value="批量新建用户" class="btn btn-sm btn-default">
    </form>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">列表页</h3>
            <div class="box-tools">
                <form action="{{ url('/admin/user')}}" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm pull-left" name="kw"
                               style="width: 250px;" placeholder="搜索会员">
                        <div class="input-group-btn" style="position:relative;font-size:0;left:-1350px;">
                            <button class="btn btn-sm" ><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered">
                <tbody>
                <!--tr-th start-->
                <tr>
                    <th>头像</th>
                    <th>昵称</th>
                    <th>账号</th>
                    <th>电话</th>
                    <th>角色</th>
                    <th>邮箱</th>
                    <th>密码</th>
                    <th>注册时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
                <!--tr-th end-->
                @if(count($users))
                @foreach($users as $k=>$user)
                    <tr>
                        <td class="text-muted"> <img src="{{ url($user->pic) }}" style="width:100px;"> </td>
                        <td class="text-muted">{{$user->name}}</td>
                        <td class="text-muted">{{$user->account}}</td>
                        <td class="text-muted">{{$user->phone}}</td>
                        <td class="text-muted">{{ $user->role($user->id,0) }}</td>
                        <td class="text-muted">{{$user->email}}</td>
                        <td class="text-navy">{{$user->password}}</td>
                        <td class="text-muted">{{$user->created_at}}</td>
                        <td class="text-navy">{{$user->updated_at}}</td>
                        <td>
                            <a style="font-size: 16px;padding: 4px;" href="{{ url('/admin/user/edit').'/'.$user->id}}" class="ui button"><i class="fa fa-fw fa-pencil" title="修改"></i></a>
                            <a style="font-size: 16px;padding: 4px;" href="{{ url('/admin/user/del').'/'.$user->id}}" class="ui button"><i class="fa fa-fw fa-trash-o" title="删除"></i></a>
                            <a style="font-size: 16px;padding: 4px;" href="{{ url('/admin/user/info').'/'.$user->id}}" class="ui button"><i class="glyphicon glyphicon-floppy-save" title="导出"></i></a>
                            
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="8" style="color:red;">暂无数据</td>
                </tr>
                @endif
                </tbody>
            </table>
               <div style="text-align:center"> {{ $users->appends(['kw' => $kw])->links() }}</div>
        </div>
    </div>
@stop

