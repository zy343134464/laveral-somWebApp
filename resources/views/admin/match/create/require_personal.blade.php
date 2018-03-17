@extends('admin.match.create.layout')
@section('title', '投稿要求')

@section('body2')
<div class="match-theme">
	<form class="form-horizontal" role="form" action="{{ url('admin/match/storerequire_personal/'.$id) }}" method="post" >
	{{ csrf_field() }}
		<ul class="nav nav-tabs nav-otherjob" role="tablist">
			<li role="presentation" class="active"><a href="{{ url('admin/match/require_personal/'.$id) }}">个人</a></li>
			<li role="presentation"><a href="{{ url('admin/match/require_team/'.$id) }}" >团体</a></li>
		</ul>
		@if(count($require_personal))
		@foreach($require_personal as $v)
		<div class="match-require">
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">单张/组图</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname" placeholder="张/组" name="group_min" value="{{ $v->group_min }}">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname" placeholder="张/组"  name="group_max" value="{{ $v->group_max }}">
				</div>
				<div class="col-sm-1" style="padding-top:6px;">
					<input type="checkbox" name="group_limit"  value="1"> 不限
				</div>
				<div class="col-sm-2" style="padding-top:6px;">
					<input type="checkbox" id="only"> 仅限单张
				</div>
				<div>
					<a href="{{ url('admin/match/del_personal/'.$id)}}" class="btn  btn-danger "> 清空本页所有内容</a>
				</div>
			</div>
			<div class="form-group div1">
				<label for="firstname3" class="col-sm-2 control-label">每组张数</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="张"  name="num_min"   value="{{ $v->num_min }}">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control"  placeholder="张"  name="num_max" value="{{ $v->num_max }}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">图片大小</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="MB" name="size_min"  min="0" value="{{ $v->size_min }}">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname4" placeholder="MB" name="size_max"  min="0" value="{{ $v->size_max }}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">最小边长</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="像素"  name="length"  value="{{ $v->length }}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">补充说明</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题"  name="introdution_title" value="{{ $v->introdution_title }}">
					<textarea class="form-control" rows="6" placeholder="400字内" name="introdution_detail" >{{ $v->introdution_detail }}</textarea>
				</div>
			</div>
			<div class="form-group">
                <label for="firstname3" class="col-sm-2 control-label">收费类型</label>
				<div class="col-sm-6">
					<label class="radio-inline">
						<input type="radio" name="pay"  value="1" id="only1" {{ $v->pay == 1 ? 'checked' : ''}} >每张/组收费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="pay"  value="2" id="only3" {{ $v->pay == 2 ? 'checked' : ''}} >报名费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="pay"  value="0" id="only2" {{ $v->pay == 0 ? 'checked' : ''}} >免费
					</label>
				</div>
            </div>
            <div class="form-group div2">
				<label for="firstname5" class="col-sm-2 control-label">单价</label>
				<div class="col-sm-2">
					<input type="number"  min="0" step="0.01" class="form-control" id="firstname5" placeholder="" name="price"  value="{{ $v->price }}">
				</div>
				<div class="col-sm-2">
					<select class="form-control">
						<option>人民币</option>
					</select>
				</div>
			</div>
			<div class="form-group div2">
				<label for="firstname7" class="col-sm-2 control-label">收费说明</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题"  name="pay_title"  value="{{ $v->pay_title }}">
					<textarea class="form-control" rows="6" placeholder="400字内" name="pay_detail" >{{ $v->pay_detail }}</textarea>
				</div>
			</div>
			<div class="form-group">
                <label class="col-sm-2 control-label">作品信息</label>
				<div class="col-sm-9">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="author" name="info[]" checked> 作者姓名
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="author_r" name="required[]" checked> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="detail" name="info[]" checked> 文字描述
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="detail_r" name="required[]" checked> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="title" name="info[]" checked> 作品标题
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="title_r" name="required[]" checked> 必填
						</label>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-2">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  name="" value="represent" name="info[]" > 代表单位
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  name="" value="represent_r"  name="required[]" > 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  name="" value="year" name="info[]" > 年份
						</label>
						<label class="checkbox-inline" style="padding-left:48px;">
							<input type="checkbox"  name="" value="year_r" name="required[]" > 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="country" name="info[]" > 国籍
						</label>
						<label class="checkbox-inline" style="padding-left:48px;">
							<input type="checkbox"  value="country_r" name="required[]" > 必填
						</label>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-2">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="lacation" name="info[]" > 拍摄地点
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="lacation_r" name="required[]" > 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="size" name="info[]" > 作品尺寸
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="size_r" name="required[]" > 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox" id="inlineCheckbox1" value="en" name="info[]" > 中英双语
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" id="inlineCheckbox2" value="en_r" name="required[]" > 必填
						</label>
					</div>
				</div>
            </div>
            <div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">赛事须知</label>
				<div class="col-sm-8">
					<textarea class="form-control" rows="6" placeholder="400字内" name="notice" >{{ $v->notice }}</textarea>
				</div>
				<div class="col-sm-8 col-sm-offset-2" style="color:#cccccc;">
					(赛事须知为用户必须确认已知才能参与比赛的声明内容)
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2 col-sm-offset-5">
					<a class="btn btn-warning" data-toggle="modal" data-target="#newform" style="background-color:#d4b179;color:#000;border:none;" title="创建个人表单">创建报名表</a>
				</div>
			</div>
		</div>
		@endforeach
		@else
		<div class="match-require">
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">单张/组图</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname" placeholder="张/组" name="group_min" value="">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname" placeholder="张/组"  name="group_max" value="">
				</div>
				<div class="col-sm-1" style="padding-top:6px;">
					<input type="checkbox" value="1" name="group_limit"> 不限
				</div>
				<div class="col-sm-2" style="padding-top:6px;">
					<input type="checkbox" id="only"> 仅限单张
				</div>
				<div>
					<a href="{{ url('admin/match/del_personal/'.$id)}}" class="btn btn-danger "> 清空本页所有内容</a>
				</div>
			</div>
			<div class="form-group div1">
				<label for="firstname3" class="col-sm-2 control-label">每组张数</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="张"  name="num_min" value="">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control"  placeholder="张"  name="num_max" value="">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">图片大小</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="MB" name="size_min"  min="0" value="">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname4" placeholder="MB" name="size_max"  min="0" value="">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">最小边长</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="像素"  name="length"  value="">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">补充说明</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题"  name="introdution_title" value="">
					<textarea class="form-control" rows="6" placeholder="400字内" name="introdution_detail" ></textarea>
				</div>
			</div>
			<div class="form-group">
                <label for="firstname3" class="col-sm-2 control-label">收费类型</label>
				<div class="col-sm-6">
					<label class="radio-inline">
						<input type="radio" name="pay"  value="1" checked id="only1">每张/组收费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="pay"  value="2" id="only3">报名费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="pay"  value="0" id="only2">免费
					</label>
				</div>
            </div>
            <div class="form-group div2">
				<label for="firstname5" class="col-sm-2 control-label">单价</label>
				<div class="col-sm-2">
					<input type="number"  min="0" step="0.01" class="form-control" id="firstname5" placeholder="" name="price"  value="">
				</div>
				<div class="col-sm-2">
					<select class="form-control">
						<option>人民币</option>
					</select>
				</div>
			</div>
			<div class="form-group div2">
				<label for="firstname7" class="col-sm-2 control-label">收费说明</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题"  name="pay_title"  value="">
					<textarea class="form-control" rows="6" placeholder="400字内" name="pay_detail" ></textarea>
				</div>
			</div>
			<div class="form-group">
                <label class="col-sm-2 control-label">作品信息</label>
				<div class="col-sm-9">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="author" name="info[]" checked> 作者姓名
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="author_r" name="required[]" checked> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="detail" name="info[]" checked> 文字描述
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="detail_r" name="required[]" checked> 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="title" name="info[]" checked> 作品标题
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="title_r" name="required[]" checked> 必填
						</label>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-2">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"   value="represent" name="info[]" > 代表单位
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"   value="represent_r"  name="required[]" > 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox" value="year" name="info[]" > 年份
						</label>
						<label class="checkbox-inline" style="padding-left:48px;">
							<input type="checkbox"  value="year_r" name="required[]" > 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="country" name="info[]" > 国籍
						</label>
						<label class="checkbox-inline" style="padding-left:48px;">
							<input type="checkbox"  value="country_r" name="required[]" > 必填
						</label>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-2">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="lacation" name="info[]" > 拍摄地点
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="lacation_r" name="required[]" > 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="size" name="info[]" > 作品尺寸
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="size_r" name="required[]" > 必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox" id="inlineCheckbox1" value="en" name="info[]" > 中英双语
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" id="inlineCheckbox2" value="en_r" name="required[]" > 必填
						</label>
					</div>
				</div>
            </div>
            <div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">赛事须知</label>
				<div class="col-sm-8">
					<textarea class="form-control" rows="6" placeholder="400字内" name="notice" ></textarea>
				</div>
				<div class="col-sm-8 col-sm-offset-2" style="color:#cccccc;">
					(赛事须知为用户必须确认已知才能参与比赛的声明内容)
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2 col-sm-offset-5">
					<a class="btn btn-warning" data-toggle="modal" data-target="#newform" style="background-color:#d4b179;color:#000;border:none;" title="创建个人表单">创建报名表</a>
				</div>
			</div>
		</div>
		@endif
		<div class="nextPage">

			<button type="submit" class="btn btn-default" style="padding:10px 15px;margin-left:50px;">下一页</button>
		</div>
	</form>
</div>

<!-- 模态框（Modal） -->
<div class="modal fade" id="newform" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal200">
		<div class="modal-content" style="background-color:#f5f5f5">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					报名表单编辑
				</h4>
			</div>
			<div class="modal-body clearfix">
				<div class="type">
					<ul class="nav nav-tabs nav-otherjob" role="tablist">
						<li role="presentation" class="active" style="margin-bottom:25px;padding-left:29px;"><a href="">个人</a></li>
					</ul>
				</div>
				<form class="form-horizontal" role="form">
					<div class="col-sm-12">
						<div class="col-sm-8">
							<div class="wrapperform">
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">1</label>
									<div class="col-sm-3">
										<select class="form-control">
											<option selected>填空题</option>
											<option>选择题</option>
											<option>附件</option>
										</select>
									</div>
									<label for="firstname" class="col-sm-2 control-label">必填</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline1" id="optionsRadios1" value="option1" checked> 是
									</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline1" id="optionsRadios1"  value="option2"> 否
									</label>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">标题名称</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" placeholder="输入标题名称">
									</div>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">提示文字</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" placeholder="输入提示文字">
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4" style="margin-top:3px;">
							<div class="handle">
								<span><a href="#"><i class="fa fa-arrow-up"></i></a></span>
	                            <span><a href="#"><i class="fa fa-arrow-down"></i></a><span>
	                            <span><a href="#" style="margin-left:50px;"><i class="fa fa-minus-square-o"></i></a></span>
                            </div>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="col-sm-8">
							<div class="wrapperform">
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">2</label>
									<div class="col-sm-3">
										<select class="form-control">
											<option>填空题</option>
											<option>选择题</option>
											<option>附件</option>
										</select>
									</div>
									<label for="firstname" class="col-sm-2 control-label">必填</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline2" id="optionsRadios2" value="option1" checked> 是
									</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline2" id="optionsRadios2"  value="option2"> 否
									</label>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">标题名称</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" placeholder="输入标题名称">
									</div>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">提示文字</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" placeholder="输入提示文字">
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4" style="margin-top:3px;">
							<div class="handle">
								<span><a href="#"><i class="fa fa-arrow-up"></i></a></span>
	                            <span><a href="#"><i class="fa fa-arrow-down"></i></a><span>
	                            <span><a href="#" style="margin-left:50px;"><i class="fa fa-minus-square-o"></i></a></span>
                            </div>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="col-sm-8">
							<div class="wrapperform">
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">3</label>
									<div class="col-sm-3">
										<select class="form-control">
											<option>填空题</option>
											<option selected>选择题</option>
											<option>附件</option>
										</select>
									</div>
									<label for="firstname" class="col-sm-2 control-label">必填</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline3" id="optionsRadios3" value="option1" checked> 是
									</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline3" id="optionsRadios3"  value="option2"> 否
									</label>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">是否多选</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline4" id="optionsRadios4" value="option1" checked> 是
									</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline4" id="optionsRadios4"  value="option2"> 否
									</label>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">题目名称</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" 
										placeholder="输入标题名称">
									</div>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">选项1</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" 
										placeholder="输入选项1内容">
									</div>
									<div class="col-sm-1 minus">
										<span><a href="#" style="margin-left:50px;"><i class="fa fa-minus-square-o"></i></a></span>
									</div>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">选项2</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" 
										placeholder="输入选项2内容">
									</div>
									<div class="col-sm-1 minus">
										<span><a href="#" style="margin-left:50px;"><i class="fa fa-minus-square-o"></i></a></span>
									</div>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">选项3</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" 
										placeholder="输入选项3内容">
									</div>
									<div class="col-sm-1 minus">
										<span><a href="#" style="margin-left:50px;"><i class="fa fa-minus-square-o"></i></a></span>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="additem">
										<span><a href="#"><i class="fa fa-plus-square-o"></i></a></span>
									</div>
								</div>
								 <div class="form-group">
								 	<label for="firstname" class="col-sm-2 control-label">添加'其它'选项</label>
								 	<label class="radio-inline">
								 		<input type="radio" name="optionsRadiosinline5" id="optionsRadios5" value="option1" checked> 是
								 	</label>
								 	<label class="radio-inline">
								 		<input type="radio" name="optionsRadiosinline5" id="optionsRadios5"  value="option2"> 否
								 	</label>
								 </div>
							</div>
						</div>
						<div class="col-sm-4" style="margin-top:3px;">
							<div class="handle">
								<span><a href="#"><i class="fa fa-arrow-up"></i></a></span>
	                            <span><a href="#"><i class="fa fa-arrow-down"></i></a><span>
	                            <span><a href="#" style="margin-left:50px;"><i class="fa fa-minus-square-o"></i></a></span>
                            </div>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="col-sm-8">
							<div class="wrapperform">
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">4</label>
									<div class="col-sm-3">
										<select class="form-control">
											<option>填空题</option>
											<option>选择题</option>
											<option selected>附件</option>
										</select>
									</div>
									<label for="firstname" class="col-sm-2 control-label">必填</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline6" id="optionsRadios6" value="option1" checked> 是
									</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline6" id="optionsRadios6"  value="option2"> 否
									</label>
								</div>

								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">附件</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline7" id="optionsRadios7" value="option1" checked> 文件
									</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline7" id="optionsRadios7"  value="option2"> 图片
									</label>
								</div>

								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">标题名称</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" 
										placeholder="输入标题名称">
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4" style="margin-top:3px;">
							<div class="handle">
								<span><a href="#"><i class="fa fa-arrow-up"></i></a></span>
	                            <span><a href="#"><i class="fa fa-arrow-down"></i></a><span>
	                            <span><a href="#" style="margin-left:50px;"><i class="fa fa-minus-square-o"></i></a></span>
                            </div>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="col-sm-8">
							<div class="wrapperform">
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">1</label>
									<div class="col-sm-3">
										<select class="form-control">
											<option>填空题</option>
											<option>选择题</option>
											<option>附件</option>
											<option selected>其它</option>
										</select>
									</div>
									<label for="firstname" class="col-sm-2 control-label">必填</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline8" id="optionsRadios8" value="option1" checked> 是
									</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline8" id="optionsRadios8"  value="option2"> 否
									</label>
								</div>
								<div class="form-group">
									<div class="col-sm-3 col-sm-offset-2">
										<select class="form-control">
											<option selected>日期</option>
											<option>国籍</option>
											<option>详细地址</option>
											<option>分栏标题</option>
											<option>个人简介</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">标题名称</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" 
										placeholder="输入标题名称">
									</div>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">提示文字</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" 
										placeholder="输入提示文字">
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4" style="margin-top:3px;">
							<div class="handle">
								<span><a href="#"><i class="fa fa-arrow-up"></i></a></span>
	                            <span><a href="#"><i class="fa fa-arrow-down"></i></a><span>
	                            <span><a href="#" style="margin-left:50px;"><i class="fa fa-minus-square-o"></i></a></span>
                            </div>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="col-sm-8">
							<div class="wrapperform">
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">1</label>
									<div class="col-sm-3">
										<select class="form-control">
											<option>填空题</option>
											<option>选择题</option>
											<option>附件</option>
											<option selected>其它</option>
										</select>
									</div>
									<label for="firstname" class="col-sm-2 control-label">必填</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline9" id="optionsRadios9" value="option1" checked> 是
									</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline9" id="optionsRadios9"  value="option2"> 否
									</label>
								</div>
								<div class="form-group">
									<div class="col-sm-3 col-sm-offset-2">
										<select class="form-control">
											<option>日期</option>
											<option selected>国籍</option>
											<option>详细地址</option>
											<option>分栏标题</option>
											<option>个人简介</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">标题名称</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" 
										placeholder="输入标题名称">
									</div>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">提示文字</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" 
										placeholder="输入提示文字">
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4" style="margin-top:3px;">
							<div class="handle">
								<span><a href="#"><i class="fa fa-arrow-up"></i></a></span>
	                            <span><a href="#"><i class="fa fa-arrow-down"></i></a><span>
	                            <span><a href="#" style="margin-left:50px;"><i class="fa fa-minus-square-o"></i></a></span>
                            </div>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="col-sm-8">
							<div class="wrapperform">
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">1</label>
									<div class="col-sm-2">
										<select class="form-control">
											<option>填空题</option>
											<option>选择题</option>
											<option>附件</option>
											<option selected>其它</option>
										</select>
									</div>
									<label for="firstname" class="col-sm-2 control-label">必填</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline9" id="optionsRadios9" value="option1" checked> 是
									</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline9" id="optionsRadios9"  value="option2"> 否
									</label>
								</div>
								<div class="form-group">
									<div class="col-sm-2 col-sm-offset-2">
										<select class="form-control">
											<option>日期</option>
											<option>国籍</option>
											<option selected>详细地址</option>
											<option>分栏标题</option>
											<option>个人简介</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">标题名称</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" 
										placeholder="输入标题名称">
									</div>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">提示文字</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" 
										placeholder="输入提示文字">
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4" style="margin-top:3px;">
							<div class="handle">
								<span><a href="#"><i class="fa fa-arrow-up"></i></a></span>
	                            <span><a href="#"><i class="fa fa-arrow-down"></i></a><span>
	                            <span><a href="#" style="margin-left:50px;"><i class="fa fa-minus-square-o"></i></a></span>
                            </div>
						</div>
					</div>


					<div class="col-sm-12">
						<div class="col-sm-8">
							<div class="wrapperform">
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">1</label>
									<div class="col-sm-3">
										<select class="form-control">
											<option>填空题</option>
											<option>选择题</option>
											<option>附件</option>
											<option selected>其它</option>
										</select>
									</div>
									<label for="firstname" class="col-sm-2 control-label">必填</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline10" id="optionsRadios10" value="option1" checked> 是
									</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline10" id="optionsRadios10"  value="option2"> 否
									</label>
								</div>
								<div class="form-group">
									<div class="col-sm-3 col-sm-offset-2">
										<select class="form-control">
											<option>日期</option>
											<option>国籍</option>
											<option>详细地址</option>
											<option selected>分栏标题</option>
											<option>个人简介</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">标题名称</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="firstname" 
										placeholder="输入标题名称">
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4" style="margin-top:3px;">
							<div class="handle">
								<span><a href="#"><i class="fa fa-arrow-up"></i></a></span>
	                            <span><a href="#"><i class="fa fa-arrow-down"></i></a><span>
	                            <span><a href="#" style="margin-left:50px;"><i class="fa fa-minus-square-o"></i></a></span>
                            </div>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="col-sm-8">
							<div class="wrapperform">
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label">1</label>
									<div class="col-sm-3">
										<select class="form-control">
											<option>填空题</option>
											<option>选择题</option>
											<option>附件</option>
											<option selected>其它</option>
										</select>
									</div>
									<label for="firstname" class="col-sm-2 control-label">必填</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline11" id="optionsRadios11" value="option1" checked> 是
									</label>
									<label class="radio-inline">
										<input type="radio" name="optionsRadiosinline11" id="optionsRadios11"  value="option2"> 否
									</label>
								</div>
								<div class="form-group">
									<div class="col-sm-3 col-sm-offset-2">
										<select class="form-control">
											<option>日期</option>
											<option>国籍</option>
											<option>详细地址</option>
											<option>分栏标题</option>
											<option selected>个人简介</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4" style="margin-top:3px;">
							<div class="handle">
								<span><a href="#"><i class="fa fa-arrow-up"></i></a></span>
	                            <span><a href="#"><i class="fa fa-arrow-down"></i></a><span>
	                            <span><a href="#" style="margin-left:50px;"><i class="fa fa-minus-square-o"></i></a></span>
                            </div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-sm-12">
				<div class="addbtn">
					<span><a href="#"><i class="fa fa-plus-square-o"></i></a></span>
				</div>
			</div>
			<div class="nextPage">
				<button type="submit" class="btn btn-default" style="margin-left:44px;margin-right:30px;">提交</button>
				<button type="submit" class="btn btn-default">预览</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
@endsection