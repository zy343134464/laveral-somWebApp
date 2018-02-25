@extends('admin.layout')  
@section('title', '页面广告设置')
@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/information/information.css') }}">
@endsection


@section('body')

<section id="information">
	<div class="row">
		<div class="col-sm-12">
			<div class="title">
				<h4>登录页广告设置</h4>
			</div>
		</div>
		<div class="col-sm-12">
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
										<input type="text" class="form-control" placeholder="输入海报标题">
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
										<input type="text" class="form-control" placeholder="填写尺寸">
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