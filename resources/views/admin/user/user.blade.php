<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> 会员管理 </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('webFront/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('webFront/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('webFront/bower_components/Ionicons/css/ionicons.min.css') }}">

    <!--pages css-->
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ url('webFront/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('webFront/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('webFront/dist/css/skins/_all-skins.min.css') }}">
    <!--custom css-->
    <link rel="stylesheet" href="{{ url('webFront/dist/css/custom/index2.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="container">
    <div class="row">

        <div class="wrapper">
            <!--头部导航-->
            <header class="main-header">
                <!-- Logo -->
                <a href="index2.html" class="logo">
                    <img src="{{ url('webFront/dist/img/images/som-logo.png') }}" alt="som图标">
                    <span>SOM赛事管理系统</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!--左导航-->
                    <div class="navbar-left">
                        <ul class="clearfix">
                            <li>
                                <a href="#"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>
                            </li>
                        </ul>
                    </div>
                    <!--右导航-->
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#"><span class="glyphicon glyphicon-subtitles" aria-hidden="true"></span></a>
                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-danger">37</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">您有37条待处理事项</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-warning text-yellow"></i> Very long description here that
                                                    may not fit into the
                                                    page and may cause design problems
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-red"></i> 5 new members joined
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-user text-red"></i> You changed your username
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="{{ url('webFront/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                                </a>
                                <div class="circle"></div>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="{{ url('webFront/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

                                        <p>
                                            Alexander Pierce - Web Developer
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Followers</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Sales</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Friends</a>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--侧边栏菜单-->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <div class="organization-logo">
                        <img src="{{ url('webFront/dist/img/images/som-somlogo.png') }}" alt="机构图标">
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu text-center" data-widget="tree">
                        <li class="treeview">
                            <a href="#">
                                <span>首页</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <span>比赛管理</span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/matchconducts/matchconducts.html">进行中比赛</a></li>
                                <li><a href="pages/UI/icons.html">筹备中比赛</a></li>
                                <li><a href="pages/UI/buttons.html">历史记录</a></li>
                            </ul>
                        </li>
                        <li class="treeview active">
                            <a href="#">
                                <span>会员管理</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <span>登录页管理</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
	<!--  **************************start************************   -->
            <!-- 主内容 -->
            <div class="content-wrapper">
                <!-- 头部 -->
                <section class="content-header">
                    <div class="row">
                        <div class="col-xs-3 timefiltrate">
                            <div class="dropdown">
                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    按用户角色筛选
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="#">评委</a></li>
                                    <li><a href="#">管理员</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-3 statefiltrate">
                            <div class="dropdown">
                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    按会员等级筛选
                                    <span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <li><a href="{{ url('admin/user?vip_level=1') }}">普通会员</a></li>
                                    <li><a href="{{ url('admin/user?vip_level=2')}}">钻石会员</a></li>
                                </ul>

                            </div>
                        </div>
                        <div class="col-xs-6 optionalfiltrate">
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    <span>自选显示信息</span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                                    <div class="form-group">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" class="toggle-vis" data-column="1" checked/>名称
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" class="toggle-vis" data-column="2" checked/>手机
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" class="toggle-vis" data-column="3" checked/>账号
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" class="toggle-vis" data-column="4" checked/>多角色
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" class="toggle-vis" data-column="5" checked/>会员等级
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" class="toggle-vis" data-column="6" checked/>编辑
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" class="toggle-vis" data-column="7" checked/>站内信
                                        </label>
                                    </div>
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
	                                <button class="btn btn-sm btn-default fa fa-search"></button>
	                                <input type="text" name="kw" placeholder="关键字搜索">
	                            </div>
							</form>


                            <!--批量导出-->
                            <div class="batch-export">
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle toggle-vis" type="button">
                                        导出
                                    </button>
                                </div>
                            </div>
                            <div class="batch-enter">
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle toggle-vis" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        导入
                                        <i class="fa fa-sort-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                                        <li><a href="{{ url('admin/user/getfeild') }}">下载模板</a></li>
                                        <li role="presentation" class="divider"></li>
                                        <li><a href="#">上传模板</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="hand-users">
                                <div class="dropdown">
                                    <a class="btn btn-success dropdown-toggle toggle-vis" href="{{ url('admin/user/create') }}" >
                                        手动添加用户
                                    </a>
                                </div>
                            </div>
                            <div class="tab-title">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="{{ $type ? 'active' : '' }}"><a href="{{ url('admin/user?type=1') }}">机构会员</li></a>
                                    <li role="presentation" class="{{ $type ?  '':'active'  }}"><a href="{{ url('admin/user?type=0') }}">普通用户</a></li>
                                </ul>
                            </div>
                            <div class="box">
                                <div class="box-body">
                                    <table id="example1" class="table text-center" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>名称</th>
                                            <th>手机</th>
                                            <th>账号</th>
                                            <th>多角色</th>
                                            <th>会员等级</th>
                                            <th>编辑</th>
                                            <th>站内信</th>
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
                                            <td>{{ $user->account }}</td>
                                            <td>{{ $user->role($user->id,0) }}</td>
                                            <td>卓越会员</td>
                                            <td>
                                                <a href="{{ url('admin/user/edit').'/'.$user->id }}"><i class="fa fa-edit"></i></a>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"><i class="fa fa-envelope-o"></i></a>
                                            </td>
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
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
	<!--  **************************end************************   -->
        </div>
        <!-- ./wrapper -->
    </div>
</div>

<!-- jQuery 3 -->
<script src="{{ url('webFront/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('webFront/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!--page js-->
<!-- DataTables -->
<script src="{{ url('webFront/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('webFront/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ url('webFront/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ url('webFront/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('webFront/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('webFront/dist/js/demo.js') }}"></script>
<!--custom js-->
<script src="{{ url('webFront/dist/js/custom/index2.js') }}"></script>
</body>
</html>
