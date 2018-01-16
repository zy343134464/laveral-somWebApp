<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>登录</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo e(url('webFront/bower_components/bootstrap/dist/css/bootstrap.min.css')); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(url('webFront/bower_components/font-awesome/css/font-awesome.min.css')); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo e(url('webFront/bower_components/Ionicons/css/ionicons.min.css')); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(url('webFront/dist/css/AdminLTE.min.css')); ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo e(url('webFront/plugins/iCheck/square/blue.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(url('webFront/dist/css/custom/login.css')); ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="wrapper">
    <header></header>
    <section class="login">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="login-box-body">
                <div class="organization-logo">
                    <img src="<?php echo e(url('webFront/dist/img/images/som-organization1.jpg')); ?>" alt="机构logo">
                </div>
                <form action="<?php echo e(url('/dologin')); ?>" method="post">
                    <?php echo csrf_field(); ?>

                    <div class="text-left " style="color:red" id="msg"><?php echo e(session('msg')); ?></div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="phone" required placeholder="手机号"  onblur="checkPhone(this)">
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" required placeholder="密码" onblur="validPwd(this)">
                    </div>
                    <!-- /.col -->
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="row">
                        <div class="col-xs-8 text-left">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox">下次自动登录
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4 siginin">
                            <a href="#">忘记密码</a> | <a href="<?php echo e(url('reg')); ?>">注册</a>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <div class="other-login">
                    <ul>
                        <li>
                            <i class="fa fa-mobile-phone"></i><br>
                            <a href="#">短信验证</a>
                        </li>
                        <li>
                            <i class="fa fa-weixin"></i><br>
                            <a href="#">微信</a>
                        </li>
                        <li>
                            <i class="fa fa-qq"></i><br>
                            <a href="#">QQ</a>
                        </li>
                        <li>
                            <i class="fa fa-weibo"></i><br>
                            <a href="#">微博</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.login-box-body -->
        </div>
    </section>
    <footer> </footer>
</div>

<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo e(url('webFront/bower_components/jquery/dist/jquery.min.js')); ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo e(url('webFront/bower_components/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
<!-- iCheck -->
<script src="<?php echo e(url('webFront/plugins/iCheck/icheck.min.js')); ?>"></script>
<!--login js-->
<script src="<?php echo e(url('webFront/dist/js/custom/login.js')); ?>"></script>
<script>
    function checkPhone(obj){ 
        var phone = obj.value;
        if(!(/^1(3|4|5|7|8)\d{9}$/.test(phone))){
            msg.innerHTML = "请输入正确的手机号码"
            return false; 
        }else{
            msg.innerHTML =""
        } 
    }

    function validPwd(obj){
      var pwd = obj.value;
      if (pwd.length > 20 || pwd.length < 6)
      {
        msg.innerHTML = "密码长度为6~20个字符";
        return false;
      }
        msg.innerHTML = ''
    }
</script>
</body>
</html>
