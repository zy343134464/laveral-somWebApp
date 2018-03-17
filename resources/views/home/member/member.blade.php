@extends('home.layout')   
@section('title', '个人会员申请页')


@section('other_css') 
    <link rel="stylesheet" href="{{ url('css/home/member/member.css') }}"/>
@endsection


@section('body')
<div class="choose-member">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>SOM个人申请表</h2>
				<h3>会员选择</h3>
				<p>请你选择想成为大师工坊的等级<span style="color:red;">*</span></p>
				<div class="grade">
					<ul>
						<li style="background:white;">
							<span>基础会员</span>
							<span>￥0.00</span>
							<input type="checkbox">
							<div class="content">
								<span>会员福利</span>
							</div>
						</li>
						<li style="background:white;">
							<span>基础会员</span>
							<span>￥0.00</span>
							<input type="checkbox">
							<div class="content">
								<span>会员福利</span>
							</div>
						</li>
						<li style="background:white;">
							<span>基础会员</span>
							<span>￥0.00</span>
							<input type="checkbox">
							<div class="content">
								<span>会员福利</span>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<a type="submit" class="btn btn-default">下一页</a>
		</div>
	</div>
</div>
@endsection


@section('other_js')
    
@endsection