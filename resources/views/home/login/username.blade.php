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
                <h4 class="login-box-msg">设置用户名</h4>
                <form  method="post">
                    {!! csrf_field() !!}
                    <div class="text-left" style="color:red" id="msg">{{ $errors->first() }}{{ session('msg') }}</div>
                    <div class="form-group has-feedback">
                        <input type="text"  class="form-control" placeholder="为自己创建一个名字" name="name" id="phone"  onblur="checkname(this)" value="">
                    </div>
                    
                    <!-- <div class="input_hide" style="display:none;">
                        <div class="form-group has-feedback nickname">
                            <input type="text" class="form-control pull-left sryanzheng" placeholder="请输入验证码">
                            <button type="button" class="btn btn-default yanzheng" >发送验证码<tton>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text"  class="form-control" placeholder="用户账号" name="name" onblur="checkName(this)" value="">
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password"  class="form-control" placeholder="6-20位密码" name="password" id="password" onblur="validPwd(this)">
                            <ul class="pwd_intensity">
                                <li></li><li></li><li></li>
                            </ul>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password"  class="form-control" placeholder="再次输入密码" name="password2" onblur="validPwd(this)">
                        </div>
                    
                    </div> -->
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
    function checkname(e){
        return true;
        var reg=/^[\u3220-\uFA29]+$/;
        
        if(reg.test(e.value)){
            $('#msg').text('用户名中不能存在中文')
        }else{
            $('#msg').text('')
        }
    }
</script>
@endsection