@extends('admin.app')
@section('other-css')
    <link rel="stylesheet" href="/dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
@endsection
@section('content-header')
    <h1>
        角色管理
        <small>角色{{ $role->name }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="{{url('/admin/role')}}">角色管理</a></li>
        <li class="active">编辑角色信息</li>
    </ol>
@stop

@section('content')
    <h2 class="page-header">编辑角色信息</h2>
    <div class="box box-primary">
        <form method="post" action="{{ url('admin/role/update') }}">
           
            {!! csrf_field() !!}
            <div class="nav-tabs-custom">
                <div class="tab-content">

                    <div class="tab-pane active">
                        <div class="form-group">
                        {{ $errors->first() }}
						</div>
                        <div class="form-group">
                            <label>角色名
                                <small class="text-red">*</small>
                            </label>
                            <input required="required" type="text" class="form-control" name="role_name" autocomplete="off" placeholder="角色名" maxlength="80" value="{{$role->role_name}}">
                            <input  type="hidden"  name="id" value="{{$role->id}}">
                        </div>
                        <div class="form-group">
                            <label>付费等级
                                <small class="text-red">*</small>
                            </label>
                           
                            <select name="vip_level" >
                              <option value="0" <?= $role->vip_level == 0 ? 'selected' : '' ?> > 待定 </option>
                              <option value="1" <?= $role->vip_level == 1 ? 'selected' : '' ?> > 1 </option>
                              <option value="2" <?= $role->vip_level == 2 ? 'selected' : '' ?> > 2 </option>
                              <option value="3" <?= $role->vip_level == 3 ? 'selected' : '' ?> > 3 </option>
                            </select>
                        </div>
                        

                        <button type="submit" class="btn btn-primary">更新角色信息</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop


