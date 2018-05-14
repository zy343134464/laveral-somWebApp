   
<?php $__env->startSection('title', '登录'); ?>
<?php $__env->startSection('other_css'); ?>
  <link rel="stylesheet" href="<?php echo e(url('css/home/login/login.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<div class="wrapper">
    <header></header>
    <section class="login">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="login-box-body">
                <div class="organization-logo">
                    <img src="<?php echo e(url('img/images/som-organization1.jpg')); ?>" alt="机构logo">
                </div>
                <form action="<?php echo e(url('/dologin')); ?>" method="post">
                    <?php echo e(csrf_field()); ?> 
                    <div class="text-left " style="color:red" id="msg"><?php echo e(session('msg')); ?></div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="phone" required placeholder="手机号"  onblur="checkPhone(this)" value="<?php echo e(old('phone')); ?>">
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
                                    <!-- <input type="checkbox">下次自动登录 -->
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4 siginin">
                            <a href="<?php echo e(url('forget')); ?>">忘记密码</a> | <a href="<?php echo e(url('reg')); ?>">注册</a>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <div class="other-login">
                    <ul>
                        <li>
                            <a href="<?php echo e(url('login/sms')); ?>"><i class="fa fa-mobile-phone"></i><br>
                            短信验证</a>
                        </li>
                        <li>
                            <a href="https://open.weixin.qq.com/connect/qrconnect?appid=wx598491fa37be6375&redirect_uri=http%3A%2F%2Fsystem.somonline.org%2Fweixin&response_type=code&scope=snsapi_login&state=<?php echo urlencode($_SERVER['HTTP_HOST'])?>">
                            <i class="fa fa-weixin" ></i><br>
                            微信</a>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('other_js'); ?>
<script src="<?php echo e(url('js/home/login/login.js')); ?>"></script>
<script>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.login.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>