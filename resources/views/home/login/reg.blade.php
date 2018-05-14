	@extends('home.login.layout')	
	@section('title', '注册')

    @section('other_css')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="{{ url('css/home/login/jquery.slider.css') }}">
	<link rel="stylesheet" href="{{ url('css/home/login/sigin.css') }}">
    <link rel="stylesheet" href="{{ url('css/home/layout.css') }}">
	@endsection
	@section('body')
    
<div class="wrapper">
    <header>
        <a href="" class="logo" style="text-decoration:none;color:#d0a45d;">
            <img src="{{ url('img/images/som-logo.png') }}" alt="som图标">
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
                <form action="{{ url('doreg') }}" method="post" onsubmit="viodForm()">
                
                    {!! csrf_field() !!}
                    <div class="text-left" style="color:red" id="msg">{{ $errors->first() }}{{ session('msg') }}</div>
                    <div class="form-group has-feedback">
                        <input type="number"  class="form-control" placeholder="手机号" name="phone" id="phone"  value="{{ old('phone') }}" autocomplete="off">  <!-- onblur="checkPhone(this)" -->
                    </div>

                    <div id="slider1" class="slider" style="margin-bottom: 15px;"></div>
                    
                    <div class="input_hide" style="display:none;">
                        <div class="form-group has-feedback nickname">
                            <input type="text" class="form-control pull-left sryanzheng" placeholder="请输入验证码" autocomplete="off" name="code" id="code">
                            <button type="button" class="btn btn-default regyanzheng yanzheng" >发送验证码<tton>
                        </div>
                        <!-- <div class="form-group has-feedback">
                            <input type="text"  class="form-control" placeholder="用户账号" name="name" onblur="checkName(this)" value="">
                        </div> -->
                        <div class="form-group has-feedback">
                            <input type="password"  class="form-control" placeholder="6-20位密码" name="password" id="password">
                           <!--  <ul class="pwd_intensity">
                                <li></li><li></li><li></li>
                            </ul> -->
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password"  class="form-control" placeholder="再次输入密码" name="password2" id="password2" > <!-- onblur="validPwd(this)" -->
                        </div>
                    <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" disabled>注册</button>
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
                    <i class="WeChat_icon fa fa-weixin"></i>
                    <i class="qq_icon fa fa-qq"></i>
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
        function viodForm (){
            var code = $('#code').val();
            var password1 =  $('#password').val();
            var password2 = $('#password2').val();
            if(code.length<4|| code.length>6){
                 msg.innerHTML = '验证码不正确';
                 return false;
            }
            if(password1.length<6|| password1.length>20){
                 msg.innerHTML = '密码格式6-20位的字符';
                 return false;
            }
            console.log(password1,password2)
            if(password1!== password2){
                 msg.innerHTML = '两次密码输入不一致';
                 return false;
            }
               // return true;6
               
        }
        $('.regyanzheng').on('click',function(){
            var phone = $('#phone').val();
            if(phone.length<11 ){
                 msg.innerHTML = '手机号码不正确，请重新输入';
                 $('#phone').val('')
            }else {
             
               $.ajax({
                    type: 'POST',
                    url: '/phone',
                    data: {phone:phone},
                    dataType: 'json',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        if(data.status){
                            $('.sryanzheng').focus();
                            console.log($('.btn-flat'))
                            $('.btn-flat').removeAttr('disabled')
                        }
                        
                    },
                    error: function(xhr, type){
                      console.log(xhr, type)
                    }
                });
            }
        })
        $('form').on('click','.btn-flat',function(e){
            e.preventDefault();
             var code = $('#code').val();
            var password1 =  $('#password').val();
            var password2 = $('#password2').val();
            if(code.length<4|| code.length>6){
                 msg.innerHTML = '验证码不正确';
                 return false;
            }
            if(password1.length<6|| password1.length>20){
                 msg.innerHTML = '密码格式6-20位的字符';
                 return false;
            }
            // console.log(password1,password2)
            if(password1!== password2){
                 msg.innerHTML = '两次密码输入不一致';
                 return false;
            }
            $('form').submit();
        })
</script>
@endsection