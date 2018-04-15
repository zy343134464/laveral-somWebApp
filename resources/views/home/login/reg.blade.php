	@extends('home.login.layout')	
	@section('title', '注册')

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
                <h4 class="login-box-msg">用户注册</h4>
                <form action="{{ url('doreg') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="text-left" style="color:red" id="msg">{{ $errors->first() }}{{ session('msg') }}</div>
                    <div class="form-group has-feedback">
                        <input type="text"  class="form-control" placeholder="手机号" name="phone" id="phone"  onblur="checkPhone(this)" value="">
                    </div>

                    <div id="slider1" class="slider" style="margin-bottom: 15px;"></div>
                    
                    <div class="input_hide" style="display:none;">
                        <div class="form-group has-feedback nickname">
                            <input type="text" class="form-control pull-left sryanzheng" placeholder="请输入验证码">
                            <button type="button" class="btn btn-default yanzheng" >发送验证码<tton>
                        </div>
                        <!-- <div class="form-group has-feedback">
                            <input type="text"  class="form-control" placeholder="用户账号" name="name" onblur="checkName(this)" value="">
                        </div> -->
                        <div class="form-group has-feedback">
                            <input type="password"  class="form-control" placeholder="6-20位密码" name="password" id="password" onblur="validPwd(this)">
                            <ul class="pwd_intensity">
                                <li></li><li></li><li></li>
                            </ul>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password"  class="form-control" placeholder="再次输入密码" name="password2" onblur="validPwd(this)">
                        </div>
                    <!-- /.col -->
                    </div>
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
                <div class="login_icon">
                   <div>
                    <i class="WeChat_icon"></i>
                    <i class="qq_icon"></i>
                    <i class="fa fa-weibo"></i>
                   </div>
                </div>
                <div class="other-login">
                    <br>
                </div>
            </div>
            <!-- /.login-box-body -->
        </div>
    </section>
    <!-- <footer id="footer">
        <div class="about">
            <ul class="aboutus text-center">
                <li class="footer-logo">
                    <a href="#"><img src="http://a.com/img/images/som-footerlogo.jpg" alt=""></a>
                </li>
                <li class="contactus">
                    <ul>
                        <li>
                            <h4>关于我们</h4>
                            <p>案例精选</p>
                            <p>团队介绍</p>
                        </li>
                        <li>
                            <h4>联系我们</h4>
                            <p>上海</p>
                            <p>北京</p>
                            <p>广州</p>
                            <p>杭州</p>
                        </li>
                        <li>
                            <h4>美学动态</h4>
                            <p>美学世界</p>
                            <p>新品鉴赏</p>
                            <p>大师灵感</p>
                        </li>
                        <li>
                            <h4>用户协议</h4>
                            <p>服务说明</p>
                            <p>用户行为</p>
                            <p>禁止事项</p>
                        </li>
                        <li>
                            <h4>企业服务</h4>
                            <p>文化推广</p>
                            <p>媒体友人</p>
                            <p>项目合作</p>
                        </li>
                    </ul>
                </li>
                <li class="blogroll">
                    <span><i class="fa fa-facebook"></i></span>
                    <span><i class="fa fa-twitter"></i></span>
                    <span><i class="fa fa-qq"></i></span>
                    <span><i class="fa fa-weibo"></i></span>
                </li>
            </ul>
        </div>
    </footer> -->
</div>
@endsection
<!--login js-->
@section('other_js')
<script src="{{ url('js/home/login/jquery.slider.min.js') }}"></script>
<script src="{{ url('js/home/login/sigin.js') }}"></script>
<!-- /.login-box -->
<script>
    	$("#slider1").slider({
            width: 360, 
		    height: 34,
            callback: function(result) {
                
               if(result){
                $(".input_hide").show();
               }
            }
        });
 function validPwd(obj){
      var pwd = obj.value;
      var pwd1 = document.getElementsByName('password')[0];
      var pwd2 = document.getElementsByName('password2')[0];
     
      if (pwd.length > 20 || pwd.length < 6)
      {
        msg.innerHTML = "密码长度为6~20个字符";
        return false;
      }
      if(pwd1.value != pwd2.value){
        msg.innerHTML = '两次密码不一致,请重新输入';
        return false;
      }
        msg.innerHTML = ''
}

</script>
@endsection