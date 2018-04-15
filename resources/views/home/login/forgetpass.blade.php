@extends('home.login.layout')   
@section('title', '忘记密码')
@section('other_css')
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
                        <input  type="text" class="form-control phone-yx" name="phone" required placeholder="手机号"  onblur="validphone(this)">
                    </div>
                     <div class="form-group has-feedback nickname">
                          <div id="slider-forget" class="slider"></div>
                    </div>

                    <div class="form-group has-feedback yz-group hide">
                            <input type="text" class="form-control pull-left sryanzheng" placeholder="请输入验证码" name="check">
                            <button class="btn btn-default yanzheng">发送验证码</button>
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
$('.phone-yx').focus();

 function validphone(obj){
    var reg =  /^1[34578]\d{9}$/,
        yxreg=/\w+[@]{1}\w+[.]\w+/,
        obj =  $.trim($(obj).val()),
      //  flag = reg.test(obj)||yxreg.test(obj);
       flag = true;
        if(obj.length>1){
            if(flag){
                 msg.innerHTML = '';
                 $('.btn-primary').removeAttr('disabled');
                 
            }else{
                 msg.innerHTML = '格式错误,请重新输入';
                $(obj).val('');
                $('.btn-primary').attr('disabled','disabled');
            }
        }else{
         $('.btn-primary').attr('disabled','disabled');
        }
    }
</script> 
<script src="{{ url('js/home/login/forgetpass.js') }}"></script>
@endsection