@extends('home.layout')   


@section('other_css')
	<link rel="stylesheet" href="{{url('css/AdminLTE.min.css')}}">
	<link rel="stylesheet" href="{{url('css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{url('css/home/user/personalcenter.css')}}">
@section('more_css')

@show
@endsection

@section('body')
	<header id="users">
	    <div class="users-intro text-center">
	        <h4>
	            <img src="{{url('img/images/user-logo.jpg')}}" alt="">
	        </h4>
	        <p>@name()</p>
	        <div class="vip">
	            <a href="#">充值</a>
	            <a href="#">升级会员</a>
	        </div>
	        <div class="operate">
	            <span class="balance">账户余额:</span><span class="second-item">99999</span>
	            <span class="grade">下一级别:</span><span>优越会员</span>
	        </div>
	    </div>
	</header>
	<section id="personal">
    <div class="container">
        <div class="row">
            <div class="col-xs-2">
                <div class="personal-tabs">
                    <ul class="text-center">
                        <li class="active">
                            <a href="{{ url('user/prodution') }}">参赛作品</a>
                        </li>
                        <li>
                            <a href="{{ url('user/consumes') }}">消费明细</a>
                        </li>
                        <li>
                            <a href="{{ url('user/info') }}">个人信息</a>
                        </li>
                        <li>
                            <a href="{{ url('user/organ') }}">机构资料</a>
                        </li>
                        <li>
                            <a href="{{ url('logout') }}">退出登陆</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-xs-10">
				@section('body2')
			            
			    @show
            </div>
        </div>
    </div>
</section>

@endsection

@section('other_js')
    <script src="{{url('lib/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script src="{{url('lib/fastclick/lib/fastclick.js')}}"></script>
	<script src="{{url('js/adminlte.min.js')}}"></script>
	<script src="{{url('js/demo.js')}}"></script>
@endsection