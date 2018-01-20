<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('lib/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('lib/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('lib/Ionicons/css/ionicons.min.css') }}">

    <!--pages css-->
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ url('lib/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('css/skins/_all-skins.min.css') }}">
    <!--custom css-->
    <link rel="stylesheet" href="{{ url('css/admin/layout.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @section('other_css')
         
    @show
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
                    <img src="{{ url('img/images/som-logo.png') }}" alt="som图标">
                    <span>SOM赛事管理系统</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
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
                                    <img src="{{ url('img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                                </a>
                                <div class="circle"></div>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="{{ url('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

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
                        <img src="{{ url('img/images/som-organization.png') }}" alt="机构图标">
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu text-center" data-widget="tree">
                        <li class="treeview active">
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
                        <li>
                            <a href="pages/membermanage/membermanage.html">
                                <span>会员管理</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>登录页管理</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/match/create/0') }}">
                                <span>新建赛事(单项)</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/match/create/1') }}">
                                <span>新建赛事(综合)</span>
                            </a>
                        </li>

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- 主内容 -->
            <div class="content-wrapper">
                @section('body')
                    
                @show
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- ./wrapper -->
    </div>
</div>

<!-- jQuery 3 -->
<script src="{{ url('lib/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!--page js-->
<!-- DataTables -->
<script src="{{ url('lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('lib/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ url('lib/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ url('lib/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('js/demo.js') }}"></script>
@section('other_js')
    
@show
</body>
</html>
