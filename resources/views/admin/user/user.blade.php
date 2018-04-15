
	<!--  **************************start************************   -->
@extends('admin.layout')   
@section('title', '会员管理')
@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/user/user.css') }}">
    <meta name="_token" content="{{ csrf_token() }}"/>
@endsection()
 


@section('body')
    <!-- 头部 -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-3 timefiltrate">
                <div class="dropdown">
                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        全部角色
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">查看所有</a></li>
                        <li><a href="#">管理员</a></li>
                        <li><a href="#">评委</a></li>
                        <li><a style="color:#ccc;">摄影人</a></li>
                        <li><a style="color:#ccc;">策展人</a></li>
                        <li><a href="#">注册用户</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-3 statefiltrate" style="margin-left:-190px;">
                <div class="dropdown">
                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        角色等级
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <li><a href="{{ url('admin/user') }}">查看所有</a></li>
                        <li><a href="{{ url('admin/user?vip_level=1') }}">超级管理员</a></li>
                        <li><a href="{{ url('admin/user?vip_level=2')}}">二级管理员</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </section>
    <!--内容-->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!--搜索框-->
                <form action="{{ url('/admin/user')}}" >
                    <div class="search-form">
                        <button class="btn btn-sm btn-default fa fa-search" style="margin-left:-10px;border:none;"></button>
                        <input type="text" name="kw" placeholder="请输入手机或用户名">
                    </div>
                </form>
                <!--批量导出-->
                <!-- <div class="batch-export">
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle toggle-vis" type="button">
                            导出
                        </button>
                    </div>
                </div> -->
                <div class="batch-export">
                    <div class="dropdown">
                        <a class="btn btn-success dropdown-toggle toggle-vis" type="button" href="{{ url('admin/user/infoall') }}">
                            导出
                        </a>
                    </div>
                </div>
                <div class="batch-enter">
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle toggle-vis" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            导入
                            <i class="fa fa-sort-down"></i>
                        </button>
                        <ul class="dropdown-menu" id="excal_ul" aria-labelledby="dropdownMenu3">
                            <li><a href="{{ url('admin/user/getfeild') }}">下载模板</a></li>
                            <li role="presentation" class="divider"></li>
                            <li id="excel_moban">
                                上传模板
                                <input type="file" name="excel" id="excel_input" accept=".doc,.docx,.xls,.xlsx" onchange ="uploadFile(this,1)"/>
                               
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="hand-users">
                    <div class="dropdown">
                        <a class="btn btn-success dropdown-toggle toggle-vis" href="{{url('admin/user/create')}}">
                            新建用户
                        </a>
                    </div>
                </div>
                <div class="tab-title">
                    <ul class="nav nav-tabs" role="tablist">
                        <!-- <li role="presentation" class="{{ $type ? 'active' : '' }} "><a href="{{ url('admin/user?type=1') }}">机构用户</li></a>
                        <li role="presentation" class="{{ $type ?  '':'active'  }}"><a href="{{ url('admin/user?type=0') }}">普通用户</a></li> -->
                        <li role="presentation" class="active"><a href="{{ url('admin/user?type=1') }}">我的会员</li></a>
                        <li role="presentation" class=""><a href="{{ url('admin/user?type=0') }}">普通用户</a></li>

                    </ul>
                </div>
                <div class="box">
                    <div class="box-body">
                        <table id="example1" class="table text-center" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>用户名</th>
                                <th>手机</th>
                                <th>角色</th>
                                <th>注册时间</th>
                                <th>编辑</th>
                                <!-- <th>站内信</th> -->
                            </tr>
                            </thead>
                            <tbody class="panel panel-default">
							<!--   foreach start -->
							@if( count($users) )
							@foreach($users as $user)
                            <tr>
                                <td>
                                    <input type="checkbox">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->role_type }}</td>
                                <td>{{date('Y-m-d', strtotime($user->created_at))}}</td>
                                <td>
                                    <a href="{{ url('admin/user/edit').'/'.$user->id }}"><i class="fa fa-edit"></i></a>
                                </td>
                                <!-- <td>
                                    <a href="#"><i class="fa fa-envelope-o"></i></a>
                                </td> -->
                            </tr>
							@endforeach
							@else
							<tr>
								<td style="color:red;">暂无数据</td>
							</tr>
                            @endif
                           <!--   foreach end -->
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="paging text-center">
                    {{ $users->appends(['kw' => $kw])->links() }}
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
             
        </div>
        <!-- /.row -->
    </section>
<!-- /.content-wrapper -->
@endsection
@section('other_js')
    <script src="{{ url('js/admin/user/user.js') }}"></script>
    <script>
    function getFileType(filePath){  //获取文件的后缀名
        var startIndex = filePath.lastIndexOf(".");  
        if(startIndex != -1)  
            return filePath.substring(startIndex+1, filePath.length);  
        else return "";  
    }
    function uploadFile(obj, type) {  
  var filePath = $("#excel_input").val(); 
  console.log(filePath); 

         if("" != filePath){  
             var fileType = getFileType(filePath);  
            //判断上传的附件是否为图片  
            console.log(fileType);
            if("doc"!=fileType && "docx"!=fileType && "xls"!=fileType && "xlsx"!=fileType ){
                    $("#excel_input").val("");  
                    alert("请上传表格文件");  
                }  
                else{  
                    //获取附件大小（单位：KB）  
                    var fileSize = document.getElementById("excel_input").files[0].size / 1024;  
                    if(fileSize > 500){  
                        alert("文件大小不能超过500KB");
                         $("#excel_input").val("");   
                    }  else{
                        var formData = new FormData();

                        var name = $("#excel_input").val();

                        formData.append("excel",$("#excel_input")[0].files[0]);

                        formData.append("name",name);

                        //formData.append('excel',excel_val);

                        console.log(formData);

                        $.ajax({ 
                           type: 'POST',
                            
                           processData : false, // 不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
                           contentType : false, // 不设置Content-type请求头
                           headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            url : "/admin/user/addusers", 
                            data:formData,
                            dataType : 'json',// 返回值类型 一般设置为json  
                            success : function(data) {// 服务器成功响应处理函数  
                                 alert("上传成功");  
                                    // window.location.reload();//上传成功后刷新页面
                                    },  
                            error : function(data){  
                                alert("服务器异常");  
                            }  
                        });  
                    }
                }  
        }  

   
    return false; 
}
    </script>
@endsection