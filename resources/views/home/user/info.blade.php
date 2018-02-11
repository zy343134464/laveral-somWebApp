@extends('home.user.layout')   


@section('more_css')

@endsection

@section('body2')
<div class="basic-information">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">基本信息</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
					class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="firstname" class="col-sm-1 control-label">用户名</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="firstname" placeholder="" value="Martin">
					</div>
					<label for="nationality" class="col-sm-1 control-label">国籍</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="nationality" placeholder="" value="中国">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">
						<label class="radio-inline col-sm-3" style="color: #9a9895;font-weight: bold;margin-left:5px;">性别</label>
						<label class="radio-inline">
							<input type="radio" name="sex" value="male" checked>男
						</label>
						<label class="radio-inline">
							<input type="radio" name="sex" value="female"> 女
						</label>
					</div>
					<label for="city" class="col-sm-1 control-label">城市</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="city" placeholder="" value="广州市">
					</div>
				</div>
				<div class="form-group">
					<label for="birthday" class="col-sm-1 control-label">生日</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="birthday" placeholder="" value="">
					</div>
					<label for="nationality" class="col-sm-1 control-label">职业</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="nationality"
						placeholder="" value="">
					</div>
				</div>
				<div class="form-group">
					<label for="firstname" class="col-sm-1 control-label">描述</label>
					<div class="col-sm-7">
						<textarea class="form-control" rows="5"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-warning">保存</button>
					</div>
				</div>
				<div class="img">
					<img src="{{url('img/images/infroimg.jpg')}}" alt="">
				</div>
			</form>
		</div>
	</div>
</div>
<div class="email">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">邮箱</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
					class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="replaceemail" class="col-sm-2 control-label" style="margin-left: -86px;">更换邮箱</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="replaceemail" placeholder="" value="22449499@qq.com">
					</div>
					<label for="securitycode" class="col-sm-1 control-label">验证码</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="securitycode"
						placeholder="" value="">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-warning">确定</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="phone">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">绑定手机</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
					class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="phone-number" class="col-sm-1 control-label">手机号</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="phone-number" placeholder="请输入要绑定的手机号" value="">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-warning">确定</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="password">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">密码</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
					class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="currentpassword" class="col-sm-2 control-label" style="margin-left: -85px">当前密码</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="currentpassword" placeholder="" value="22445566">
					</div>
				</div>
				<div class="form-group">
					<label for="newpassword" class="col-sm-1 control-label">新密码</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="newpassword" placeholder="" value="">
					</div>
				</div>
				<div class="form-group">
					<label for="surenewpassword" class="col-sm-2 control-label" style="margin-left: -85px">确认新密码</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="surenewpassword" placeholder="" value="">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-warning">确定</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="thirdparty">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">第三方绑定</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
					class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="weixin" class="col-sm-1 control-label">微信</label>
					<label for="weixin-icon" class="col-sm-1 control-label"><i class="fa fa-weixin"></label></i>
					<div class="col-sm-1">
						<button type="submit" class="btn btn-warning" style="left: 20px;">绑定</button>
					</div>
				</div>
				<div class="form-group">
					<label for="qq" class="col-sm-1 control-label">QQ</label>
					<label for="qq-icon" class="col-sm-1 control-label"><i class="fa fa-qq"></label></i>
					<div class="col-sm-1">
						<button type="submit" class="btn btn-warning" style="left: 20px;">绑定</button>
					</div>
				</div>
				<div class="form-group">
					<label for="weibo" class="col-sm-1 control-label">微博</label>
					<label for="weibo-icon" class="col-sm-1 control-label"><i class="fa fa-weibo"></label></i>
					<div class="col-sm-1">
						<button type="submit" class="btn btn-warning" style="left: 20px;">绑定</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('other_js')

@endsection