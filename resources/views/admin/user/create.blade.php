@extends('admin.layout')  
@section('title', '新建用户')
@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/user/user.css') }}">
@endsection


@section('body')

<section id="newuser">
	<div class="row">
		<div class="col-sm-12">
			<div class="title">
				<h5>新建用户</h5>
			</div>
			<form class="form-horizontal" role="form">
				<div class="userbasic">
					<div class="col-sm-12 user-infro">
						<div class="form-group">
							<label class="col-sm-1 control-label">ID</label>
							<label class="col-sm-2 control-label" style="color:#141414;">13539624211</label>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label">用户名</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" placeholder="zhangyang">
							</div>
							<label class="col-sm-1 control-label">手机号</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" placeholder="13539624211">
							</div>
							<label class="col-sm-1 control-label">角色</label>
							<div class="col-sm-2">
								<select class="form-control">
									<option>用户</option>
									<option>至尊会员</option>
									<option>卓越会员</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label">用户密码</label>
							<div class="col-sm-2">
								<input type="password" class="form-control" value="13539624211">
							</div>
							<div class="col-sm-9 text-right">
								<button type="button" class="btn btn-primary">确认创建</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-sm-12">
			<form class="form-horizontal" role="form">
				<div class="userdetail">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">个人档案</a></li>
						<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">SOM大师工坊会员资料</a></li>
					</ul>
					<div class="tab-content" style="background-color:#fff;">
						<div role="tabpanel" class="tab-pane active" id="home">
							<div class="row">
								<div class="col-sm-8">
									<div class="form-group">
										<label class="col-sm-2 control-label">姓名</label>
										<label class="col-sm-3 control-label">陈大明</label>
										<label class="col-sm-2 control-label">性别</label>
										<label class="col-sm-3 control-label">男性</label>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">生日</label>
										<label class="col-sm-3 control-label">1994年04月21日</label>
										<label class="col-sm-2 control-label">邮箱</label>
										<label class="col-sm-3 control-label">343134464@qq.com</label>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">国家</label>
										<label class="col-sm-3 control-label">中国</label>
										<label class="col-sm-2 control-label">常用地址</label>
										<label class="col-sm-3 control-label">广东省-汕头市-金平区</label>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">个人网址</label>
										<label class="col-sm-3 control-label">www.baidu.com</label>
										<label class="col-sm-2 control-label">兴趣</label>
										<label class="col-sm-3 control-label">摄影/音乐/乒乓球</label>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">个人简介</label>
										<label class="col-sm-8 control-label">勒布朗·詹姆斯（LeBron James），1984年12月30日出生在美国俄亥俄州阿克伦，美国职业篮球运动员，司职小前锋，绰号“小皇帝”，效力于NBA克利夫兰骑士队。</label>
									</div>
								</div>
								<div class="col-sm-4">
									<img src="{{ url('img/images/userimg.jpg')}}" alt="">
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="messages">
							<div class="row">
								<div class="col-sm-12">
									<div class="col-sm-8">
										<ul id="myTab" class="nav nav-tabs">
											<li class="active">
												<a href="#personal" data-toggle="tab">个人</a>
											</li>
											<li>
												<a href="#team" data-toggle="tab">团体</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="col-sm-6">
										<img src="{{ url('img/images/epaimg.jpg')}}">
									</div>
									<div class="col-sm-6">
										<div class="col-sm-10">
											<div class="form-group">
												<label class="col-sm-5 control-label">EPA机构会员编号</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" value="15645866">
												</div>
											</div>
										</div>
										<div class="col-sm-2">
											<button type="button" class="btn btn-primary">编辑</button>
										</div>
										<div class="col-sm-10">
											<div class="form-group">
												<label class="col-sm-5 control-label">EPA机构会员等级</label>
												<div class="col-sm-7">
													<select class="form-control">
														<option>用户</option>
														<option>至尊会员</option>
														<option>卓越会员</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-sm-2">
											<button type="button" class="btn btn-primary">编辑</button>
										</div>
									</div>
								</div>
								<div class="col-sm-12 text-center" style="padding-top:100px;">
									<button type="button" class="btn btn-primary">保存信息</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

@endsection

@section('other_js')
    <script src="{{ url('js/admin/user/user.js') }}"></script>
@endsection