@extends('admin.layout')  
@section('title', '页面广告设置')
@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/advertisement/advertisement.css') }}">
@endsection


@section('body')

<section id="information">
	<div class="row">
		<div class="col-sm-12">
			<div class="title">
				<h4>登录页广告设置</h4>
			</div>
			<form class="form-horizontal" role="form">
				{{ csrf_field() }}
				<div class="login-set">
					<ul class="clearfix">
						<li>
							<div class="adviset-img">
								<img src="{{ url('img/images/som-adviset.jpg') }}">
							</div>
							<div class="adviset-content">
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="maintitle form-control" placeholder="输入海报标题" style="margin-top:14px;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="输入海报副标题">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写链接">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写尺寸" style="border:none;">
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="adviset-img">
								<img src="{{ url('img/images/som-adviset.jpg') }}">
							</div>
							<div class="adviset-content">
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="maintitle form-control" placeholder="输入海报标题" style="margin-top:14px;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="输入海报副标题">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写链接">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写尺寸" style="border:none;">
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</form>
		</div>
		<div class="col-sm-12">
			<div class="title" style="margin-top:40px;">
				<h4>首页banner设置</h4>
			</div>
			<form class="form-horizontal" role="form">
				{{ csrf_field() }}
				<div class="login-set">
					<ul class="clearfix">
						<li>
							<div class="adviset-img">
								<img src="{{ url('img/images/som-adviset.jpg') }}">
							</div>
							<div class="adviset-content">
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="maintitle form-control" placeholder="输入海报标题" style="margin-top:14px;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="输入海报副标题">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写链接">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写尺寸" style="border:none;">
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="adviset-img">
								<img src="{{ url('img/images/som-adviset.jpg') }}">
							</div>
							<div class="adviset-content">
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="maintitle form-control" placeholder="输入海报标题" style="margin-top:14px;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="输入海报副标题">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写链接">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写尺寸" style="border:none;">
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</form>
		</div>
		<div class="col-sm-12" style="margin-bottom:146px;">
			<div class="title" style="margin-top:40px;">
				<h4>机构宣传页设置</h4>
			</div>
			<form class="form-horizontal" role="form">
				{{ csrf_field() }}
				<div class="login-set">
					<ul class="clearfix">
						<li>
							<div class="adviset-img">
								<img src="{{ url('img/images/som-adviset.jpg') }}">
							</div>
							<div class="adviset-content">
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="maintitle form-control" placeholder="输入海报标题" style="margin-top:14px;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="输入海报副标题">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写链接">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写尺寸" style="border:none;">
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="adviset-img">
								<img src="{{ url('img/images/som-adviset.jpg') }}">
							</div>
							<div class="adviset-content">
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="maintitle form-control" placeholder="输入海报标题" style="margin-top:14px;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="输入海报副标题">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写链接">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写尺寸" style="border:none;">
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="adviset-img">
								<img src="{{ url('img/images/som-adviset.jpg') }}">
							</div>
							<div class="adviset-content">
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="maintitle form-control" placeholder="输入海报标题" style="margin-top:14px;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="输入海报副标题">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写链接">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="填写尺寸" style="border:none;">
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</form>
		</div>
	</div>
</section>

@endsection

@section('other_js')
   
@endsection