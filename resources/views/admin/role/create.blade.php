@extends('admin.app')
@section('other-css')
    <link rel="stylesheet" href="/dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
@endsection
@section('content-header')
    <h1>
        角色管理
        <small>新增角色</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="{{url('/admin/users')}}">角色管理</a></li>
        <li class="active">角色信息</li>
    </ol>
@stop

@section('content')
    <h2 class="page-header">填写角色信息</h2>
    <div class="box box-primary">
        <form method="post" action="{{ url('admin/role/store') }}">
           
            {!! csrf_field() !!}
            <div class="nav-tabs-custom">
                <div class="tab-content">

                    <div class="tab-pane active">
                        <div class="form-group" id="msg">
                        {{ $errors->first() }}
						</div>
                        <div class="form-group">
                            <label>角色名
                                <small class="text-red">*</small>
                            </label>
                            <input required="required" type="text" class="form-control" name="role_name" autocomplete="off"
                                   placeholder="角色名" maxlength="80">
                        </div>
                        <div class="form-group">
                            <label>付费等级
                                <small class="text-red">*</small>
                            </label>
                           
                            <select name="vip_level" >
                              <option value="0"> 待定 </option>
                              <option value="1"> 1 </option>
                              <option value="2"> 2 </option>
                              <option value="3"> 3 </option>
                            </select>
                        </div>
                       <div class="form-group">
                            <label>角色类型
                                <small class="text-red">*</small>
                            </label>
                           
                            <select name="role_type" >
                              <option value="0"> 待定 </option>
                              <option value="1"> 1 </option>
                              <option value="2"> 2 </option>
                              <option value="3"> 3 </option>
                            </select>
                        </div>
                       
                        <button type="submit" class="btn btn-primary">新增角色</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
    
  
   var check = function(){
    console.log(account.value)
       // 创建XMLHttpRequest对象
       var xhr = new XMLHttpRequest()
       // 增加onreadystatechange事件,以监听所属状态
       xhr.onreadystatechange = function(){
         // readyState等于4,加载完成并且状态码200加载成功或者状态码304未修改
         if(xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 304)){
          //将得到的JSON字符串转为JS能处理的数据
          var friends = JSON.parse(xhr.responseText)
            msg.innerHTML = friends.msg;
         }
       }
      // 设置get请求,请求路径及异步
      xhr.open('get', 'find/' + account.value)
      // 发送请求
      xhr.send()
    }
  </script>
@stop

