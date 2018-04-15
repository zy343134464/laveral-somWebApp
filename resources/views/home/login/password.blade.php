	@extends('home.login.layout')	
	@section('title', '设置用户名')

    @section('other_css')
    <link rel="stylesheet" href="{{ url('css/home/login/jquery.slider.css') }}">
	<link rel="stylesheet" href="{{ url('css/home/login/sigin.css') }}">
    <link rel="stylesheet" href="{{ url('css/home/layout.css') }}">
	@endsection
	@section('body')
    
<div class="wrapper">
    <header>
        <a href="http://a.com" class="logo">
            <img src="http://a.com/img/images/som-logo.png" alt="som图标">
            <span>SOM赛事管理系统</span>
        </a>
    </header>
    <section class="login">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="login-box-body">
                <div class="organization-logo">
                    <img src="{{ url('img/images/som-organization1.jpg') }}" alt="机构logo">
                </div>
                <h4 class="login-box-msg">修改密码</h4>
                <form  method="post" action="{{ url('password') }}">
                    {!! csrf_field() !!}
                    <div class="text-left" style="color:red" id="msg">{{ $errors->first() }}{{ session('msg') }}</div>
                    <div class="form-group has-feedback">
                        <input type="password"  class="form-control" placeholder="输入新密码" name="password" id="pass1"  value="" required onblur="testPass1()">
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" required class="form-control" placeholder="再次确认新密码" name="password2" id="pass2"  value="" onblur="testPass2()">
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">确认</button>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-12 loginin">
                            <a href="{{ url('login') }}">登录</a> | <a href="#">返回首页</a>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <div class="login_icon">
                   <div>
                    <!-- <i class="WeChat_icon"></i>
                    <i class="qq_icon"></i>
                    <i class="fa fa-weibo"></i> -->
                   </div>
                </div>
                <div class="other-login">
                    <br>
                </div>
            </div>
            <!-- /.login-box-body -->
        </div>
    </section>
   
</div>
@endsection
<!--login js-->
@section('other_js')

<!-- <script src="{{ url('js/home/login/sigin.js') }}"></script> -->
<!-- /.login-box -->
<script>
$('#pass1').focus();
function testPass1(){ 
     var pass1 = $.trim($('#pass1').val());
     if(pass1.length<5){
                   msg.innerHTML = '密码不能小于六位数';
                 $('.btn-primary ').attr('disabled','disabled');
                 return false;
             }else {
                $('.btn-primary ').removeAttr('disabled');
            }
}

    function testPass2 (){
        var pass1 = $.trim($('#pass1').val()),
            pass2 = $.trim($('#pass2').val());
            if(pass1 == pass2){
                 msg.innerHTML = '';
                 $('.btn-primary ').removeAttr('disabled');
                   
                }else{
                  msg.innerHTML = '密码两次输入必须一致';
                  $('input[type=password]').val('');
                  $('.btn-primary ').attr('disabled','disabled');
                  return false;
                }
            }
   
</script>
@endsection