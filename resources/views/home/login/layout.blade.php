<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('lib/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('lib/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('lib/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('lib/iCheck/square/blue.css') }}">

    @section('other_css')
            
    @show

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- jQuery 3 -->
<script src="{{ url('lib/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ url('lib/iCheck/icheck.min.js') }}"></script>
<body class="hold-transition login-page">

    @section('body')
            
    @show
   
<script>
    function checkPhone(obj){ 
        var phone = obj.value;
        if(!(/^1(3|4|5|7|8)\d{9}$/.test(phone))){
            msg.innerHTML = "请输入正确的手机号码"
            check()
            return false; 
        }else{
            msg.innerHTML =""
        } 
    }

   
    function checkName(obj)
    {
        var name = obj.value;
        if (name.length > 20 || name.length < 3)
        {
            msg.innerHTML = "用户名长度为6~20个字符";
        return false;
        }
        msg.innerHTML ='';
    }
    var check = function(){
    console.log(phone.value)
       // 创建XMLHttpRequest对象
       if (window.XMLHttpRequest){
            //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
            xhr=new XMLHttpRequest();
        } else {
            // IE6, IE5 浏览器执行代码
            xhr=new ActiveXObject("Microsoft.XMLHTTP");
        }
       // 增加onreadystatechange事件,以监听所属状态
       xhr.onreadystatechange = function(){
         // readyState等于4,加载完成并且状态码200加载成功或者状态码304未修改
         if(xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 304)){
          //将得到的JSON字符串转为JS能处理的数据
          var friends = JSON.parse(xhr.responseText)
            msg.innerHTML = friends.msg;
         }
       }
      // 设置get请求,请求路径及异步
      xhr.open('get', '{{ url('admin/user/find') }}' + '/' +phone.value)
      // 发送请求
      xhr.send()
    }
</script>
    @section('other_js')
            
    @show
</body>
</html>
