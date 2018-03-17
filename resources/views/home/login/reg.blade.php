	@extends('home.login.layout')	
	@section('title', '注册')

	@section('other_css')
	<link rel="stylesheet" href="{{ url('css/home/login/sigin.css') }}">

	@endsection
	@section('body')
<div class="wrapper">
    <header></header>
    <section class="login">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="login-box-body">
                <div class="organization-logo">
                    <img src="{{ url('img/images/som-organization1.jpg') }}" alt="机构logo">
                </div>
                <h4 class="login-box-msg">用户注册</h4>
                <form action="{{ url('doreg') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="text-left " style="color:red" id="msg">{{ $errors->first() }}{{ session('msg') }}</div>
                    <div class="form-group has-feedback">
                        <input type="text"  class="form-control" placeholder="手机号" name="phone" id="phone"  onblur="checkPhone(this)" value="">
                    </div>
                    <div class="form-group has-feedback nickname">
                        <input type="text" class="form-control pull-left sryanzheng" placeholder="请输入验证码">
                        <button type="submit" class="btn btn-default yanzheng">发送验证码<tton>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text"  class="form-control" placeholder="用户账号" name="name" onblur="checkName(this)" value="">
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password"  class="form-control" placeholder="6-20位密码" name="password" id="password">
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password"  class="form-control" placeholder="再次输入密码" name="password2" onblur="validPwd(this)">
                    </div>
                    <!-- /.col -->
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">注册</button>
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
                <div class="other-login">
                    <br>
                </div>
            </div>
            <!-- /.login-box-body -->
        </div>
    </section>
    <footer> </footer>
</div>
@endsection
<!--login js-->
@section('other_js')
<script src="{{ url('js/home/login/sigin.js') }}"></script>
<!-- /.login-box -->
<script>
 function validPwd(obj){
      var pwd = obj.value;
      if (pwd.length > 20 || pwd.length < 6)
      {
        msg.innerHTML = "密码长度为6~20个字符";
        return false;
      }
      if(password.value != pwd){
        msg.innerHTML = '两次密码不一致,请重新输入';
        return false;
      }
        msg.innerHTML = ''
    }
</script>
@endsection