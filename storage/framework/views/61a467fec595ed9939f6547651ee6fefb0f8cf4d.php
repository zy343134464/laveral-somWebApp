<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <!-- Styles -->
    <link href="<?php echo e(url('/css/app.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldContent("header-css"); ?>
    <?php echo $__env->yieldSection(); ?>

<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
        Laravel.apiToken = "<?php echo e(Auth::check()?'Bearer '.Auth::user()->api_token:'Bearer '); ?>";
        <?php if(Auth::check()): ?>
            window.Zhihu = {
            name: "<?php echo e(Auth::user()->name); ?>",
            avatar: "<?php echo e(Auth::user()->avatar); ?>"
        }
        <?php endif; ?>
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Branding Image -->
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    <?php echo e(config('app.name', 'Laravel')); ?>

                </a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a class="nav-link-title" href="/">首页</a></li>
                </ul>


                <ul class="nav navbar-nav navbar-right">
                    <li class="ask-question"><a class="ui button blue" href="/questions/create"><i class="fa fa-paint-brush fa-icon-lg"></i>写问题</a></li>
                    <!-- Authentication Links -->
                    <?php if(Auth::guest()): ?>
                        <li><a class="nav-li-login" href="<?php echo e(url('/login')); ?>">登 录</a></li>
                        <li><a class="nav-li-login" href="<?php echo e(url('/register')); ?>">注 册</a></li>
                    <?php else: ?>
                        <li>
                            <a href="<?php echo e(url('/messages')); ?>" class="user-notify-bell">
                                <i class="fa fa-bell"></i>
                                <?php if(Auth::user()->unreadNotifications->count()!==0): ?>
                                    <span class="badge bell-badge"><?php echo e(\Auth::user()->unreadNotifications->count()); ?></span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <?php echo e(Auth::user()->name); ?>

                            </a>
                        </li>
                        <li>
                            <a class="nav-header-avatar dropdown-toggle nav-user-avatar" data-toggle="dropdown" role="button"
                               aria-expanded="false" style="padding: 6px 15px 6px 0px;">
                                <img src="<?php echo e(Auth::user()->avatar); ?>">
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="/people/<?php echo e(Auth::user()->name); ?>"><i class="fa fa-user fa-icon-lg"></i> 我的主页</a>
                                </li>
                                <li>
                                    <a href="/avatar"><i class="fa fa-cloud fa-icon-lg"></i>修改头像</a>
                                </li>
                                <li>
                                    <a href="/password"><i class="fa fa-cog fa-icon-lg"></i>修改密码</a>
                                </li>
                                <li>
                                    <a href="/setting"> <i class="fa fa-cogs fa-icon-lg"></i>个人设置</a>
                                </li>
                                <?php if(Auth::user()->canEnterBack()): ?>
                                <li>
                                    <a href="/dashboard"> <i class="fa fa-coffee fa-icon-lg"></i>后台管理</a>
                                </li>
                                <?php endif; ?>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="<?php echo e(url('/logout')); ?>"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out fa-icon-lg"></i>退出登录
                                    </a>

                                    <form id="logout-form" action="<?php echo e(url('/logout')); ?>" method="POST"
                                          style="display: none;">
                                        <?php echo e(csrf_field()); ?>

                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php if(session()->has('flash_notification.message')): ?>
            <div class="alert alert-<?php echo e(session('flash_notification.level')); ?>">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo session('flash_notification.message'); ?>

            </div>
        <?php endif; ?>
    </div>
    <?php echo $__env->yieldContent('content'); ?>
</div>

<!-- Scripts -->
<script src="<?php echo e(url('/js/app.js')); ?>"></script>

<script>
    $('#flash-overlay-modal').modal();
</script>
<!-- 配置文件 -->
<script type="text/javascript" src="<?php echo e(asset('vendor/ueditor/ueditor.config.js')); ?>"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="<?php echo e(asset('vendor/ueditor/ueditor.all.js')); ?>"></script>
<script>
    window.UEDITOR_CONFIG.serverUrl = '<?php echo e(config('ueditor.route.name')); ?>'
</script>

<?php echo $__env->yieldContent('js'); ?>

</body>
</html>
