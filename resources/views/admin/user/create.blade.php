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
			<form class="form-horizontal" role="form"  action="{{ url('admin/user/store') }}"  method="post">
			{{ csrf_field() }}
				<div class="userbasic">
					<div class="col-sm-12 user-infro">
						<div class="form-group">
							<label class="col-sm-1 control-label">ID</label>
							<label class="col-sm-2 control-label" style="color:#141414;">自动添加</label>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label">用户名</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" value="" name="name" required>
							</div>
							<label class="col-sm-1 control-label">手机号</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" name="phone" value="" required>
							</div>

						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label">用户密码</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" value="" name="password" required>
							</div>
							<div class="col-sm-9 text-right">
								<button type="submit" class="btn btn-primary">确认创建</button>
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