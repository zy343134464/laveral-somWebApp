@extends('home.login.layout')   
@section('title', '忘记密码')
@section('other_css')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="{{ url('css/home/login/jquery.slider.css') }}">
    <link rel="stylesheet" href="{{ url('css/home/login/forgetpass.css') }}">
@endsection
@section('body')
<div class="wrapper">
    <!-- 登陆页 -->
    <header></header>
    <section class="login">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="login-box-body">
                <div class="organization-logo">
                    <img src="{{ url('img/images/som-organization1.jpg') }}" alt="机构logo">
                </div>
                <h4 class="login-box-msg">忘记密码</h4>
                <form action="{{ url('/forget') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="text-left" style="color:red" id="msg">{{ $errors->first() }}{{ session('msg') }}</div>
                    <div class="form-group has-feedback">
                        <input  type="text" class="form-control phone-yx" name="phone" required placeholder="手机号"  onblur="validphone(this)"  autocomplete="off" >
                    </div>
                     <div class="form-group has-feedback nickname">
                          <div id="slider-forget" class="slider"></div>
                    </div>

                    <div class="form-group has-feedback yz-group hide">
                            <input type="text" class="form-control pull-left sryanzheng" placeholder="请输入验证码" name="check"  autocomplete="off" >
                            <button class="btn btn-default yanzheng" style="width:96px;height:34px;">发送验证码</button>
                    </div>
                     <div class="row">
                         <div class="col-xs-12">
                             <button type="submit" class="btn btn-primary btn-block btn-flat">下一步</button>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-12 siginin">
                            <a href="{{ url('login') }}">登录</a> | <a href="{{ url('reg') }}">返回首页</a>
                         </div>
                    </div>
                </form>
            <!-- /.login-box-body -->
        </div>
    </section>
    <footer> </footer>
</div>
@section('other_js')
<script src="{{ url('js/home/login/jquery.slider.min.js') }}"></script>

<script>


 function validphone(obj){
     
    
        var myreg=/^[1][3,4,5,7,8][0-9]{9}$/;  
    //    console.log(myreg.test(obj.value))
        if(myreg.test(obj.value)){
            msg.innerHTML = '';
            $('.btn-primary').removeAttr('disabled');
        }else{
            msg.innerHTML = '格式错误,请重新输入';
            $('.btn-primary').attr('disabled','disabled');
            return false;
        }
    }
</script> 
<script src="{{ url('js/home/login/forgetpass.js') }}"></script>
@endsection