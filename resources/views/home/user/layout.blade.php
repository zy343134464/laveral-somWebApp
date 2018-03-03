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
	            <img src="{{url(user('pic'))}}" style="width: 100px;height: 100px;border-radius:50%;">
	        </h4>
	        <p>{{ user('name')}}</p>
	    </div>
	</header>
	<section id="personal">
    <div class="container">
        <div class="row">
            <div class="col-xs-2">
                <div class="personal-tabs">
                    <ul class="personalUl text-center">
                        <li>
                            <a href="{{ url('user/') }}">参赛作品</a>
                        </li>
                        <li>
                            <a href="{{ url('user/award') }}">获奖记录</a>
                        </li>
                        <li>
                            <a href="{{ url('user/info') }}">个人信息</a>
                        </li>
                        <li>
                            <a href="{{ url('user/organ') }}">机构资料</a>
                        </li>
                        <li>
                            <a href="{{ url('user/consumes') }}">消费记录</a>
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
<script>
    window.onload = function(){
        $('.personalUl li a').each(function(){
            if($($(this))[0].href==String(window.location)){
                $(this).parent().parent().find('li').removeClass('active')
                $(this).parent().addClass('active');
            }
        });  
    }
</script>

@endsection

@section('other_js')
    <script src="{{url('lib/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script src="{{url('lib/fastclick/lib/fastclick.js')}}"></script>
	<script src="{{url('js/adminlte.min.js')}}"></script>
	<script src="{{url('js/demo.js')}}"></script>
@endsection