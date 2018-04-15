@extends('home.user.layout')   


@section('more_css')

@endsection

@section('body2')
<div id="enroll">
	<!-- 机构资料 -->
	<form class="form-horizontal" role="form">
		<div class="userdetail">
			<ul class="nav nav-tabs" role="tablist">
            @if( count($organs) )
                @foreach($organs as $key => $v)
                    <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{$v->name}}</a></li>
                @endforeach
            @endif
			</ul>
			<div class="tab-content" style="background-color:#fff;">
				<div role="tabpanel" class="tab-pane active" id="profile">
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label class="col-sm-2 control-label">显示语言</label>
								<div class="col-sm-3">
									<select class="form-control">
										<option>中文</option>
										<option>英文</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">用户身份</label>
								<div class="col-sm-10">
									<label class="radio-inline">
										<input type="radio" value="option1" checked>专业摄影者
									</label>
									<label class="radio-inline">
										<input type="radio" value="option2">爱好者
									</label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">摄影类型</label>
								<div class="col-sm-3">
									<select class="form-control">
										<option>风景</option>
										<option>史记</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">生日</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" value="1991-9-10">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">国家</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" value="中国">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">个人网址</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" value="www.baidu.com">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">感兴趣课程</label>
								<div class="col-sm-10">
									<label class="checkbox-inline">
										<input type="checkbox" value="option1" checked> 名家摄影经历
									</label>
									<label class="checkbox-inline">
										<input type="checkbox" value="option2" checked> 专业摄影技巧教学
									</label>
									<label class="checkbox-inline">
										<input type="checkbox" value="option3"> 后期修图教学
									</label>
									<label class="checkbox-inline">
										<input type="checkbox" value="option2"> 其他
									</label>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<img src="{{ url('img/images/usersomimg.jpg')}}">
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</form>
</div>
@endsection

@section('other_js')

@endsection