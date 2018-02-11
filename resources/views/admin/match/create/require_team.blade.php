@extends('admin.match.create.layout')
@section('title', '投稿要求')

@section('body2')
<div class="match-theme">
	<form class="form-horizontal" role="form" action="{{ url('admin/match/storerequire_team/'.$id) }}" method="post" >
	{{ csrf_field() }}
		<ul class="nav nav-tabs nav-otherjob" role="tablist">
			<li role="presentation" ><a href="{{ url('admin/match/require_personal/'.$id) }}" >个人</a></li>
			<li role="presentation" class="active" ><a href="{{ url('admin/match/require_team/'.$id) }}" >团体</a></li>
		</ul>
		@if(count($require_team))
		@foreach($require_team as $v)
		<div class="match-require">
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">独照/组图</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname" placeholder="张/组" name="group_min" value="{{ $v->group_min }}">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname" placeholder="张/组"  name="group_max" value="{{ $v->group_max }}">
				</div>
				<div class="col-sm-1">
					<input type="checkbox" name="group_limit"  value="1"> 不限
				</div>
				<div class="col-sm-2" style="padding-top:6px;">
					<input type="checkbox" name="" value=""> 仅限单张
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">每组张数</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="张"  name="num_min"   value="{{ $v->num_min }}">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="" placeholder="张"  name="num_max" value="{{ $v->num_max }}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">图片大小</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="MB" name="size_min" step="0.01" min="0.01" value="{{ $v->size_min }}">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname4" placeholder="MB" name="size_max"  value="{{ $v->size_max }}">
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
						<input type="radio" name="pay" id="" value="1" checked>每张/组收费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="pay" id="" value="2">报名费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="pay" id="" value="0">免费
					</label>
				</div>
            </div>
            <div class="form-group">
				<label for="firstname5" class="col-sm-2 control-label">单价</label>
				<div class="col-sm-2">
					<input type="number" step="0.01" min="0.00" class="form-control" id="firstname5" placeholder="" name="price"  value="{{ $v->price }}">
				</div>
				<div class="col-sm-2">
					<select class="form-control">
						<option>人民币</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">收费说明</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题"  name="introdution_title"  value="{{ $v->introdution_title }}">
					<textarea class="form-control" rows="6" placeholder="400字内" name="introdution_detail" >{{ $v->introdution_detail }}</textarea>
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
							<input type="checkbox"  value="author_r" name="required[]" checked> 是否必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="detail" name="info[]" checked> 文字描述
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="detail_r" name="required[]" checked> 是否必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="title" name="info[]" checked> 作品标题
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="title_r" name="required[]" checked> 是否必填
						</label>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-2">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  name="" value="represent" name="info[]" > 代表单位
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  name="" value="represent_r"  name="required[]" > 是否必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  name="" value="year" name="info[]" > 年份
						</label>
						<label class="checkbox-inline" style="padding-left:48px;">
							<input type="checkbox"  name="" value="year_r" name="required[]" > 是否必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="country" name="info[]" > 国籍
						</label>
						<label class="checkbox-inline" style="padding-left:48px;">
							<input type="checkbox"  value="country_r" name="required[]" > 是否必填
						</label>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-2">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="lacation" name="info[]" > 拍摄地点
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="lacation_r" name="required[]" > 是否必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="size" name="info[]" > 作品尺寸
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="size_r" name="required[]" > 是否必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox" id="inlineCheckbox1" value="en" name="info[]" > 中英双语
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" id="inlineCheckbox2" value="en_r" name="required[]" > 是否必填
						</label>
					</div>
				</div>
            </div>
            <div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">赛事须知</label>
				<div class="col-sm-8">
					<textarea class="form-control" rows="6" placeholder="400字内" name="introdution_detail" >{{ $v->introdution_detail }}</textarea>
				</div>
				<div class="col-sm-8 col-sm-offset-2" style="color:#cccccc;">
					(赛事须知为用户必须确认已知才能参与比赛的声明内容)
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2 col-sm-offset-2">
					<button class="btn btn-warning" style="background-color:#d4b179;color:#000;border:none;">创建表单</button>
				</div>
			</div>
		</div>
		@endforeach
		@else
		<div class="match-require">
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">独照/组图</label>
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
					<input type="checkbox" name="" value=""> 仅限单张
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">每组张数</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="张"  name="num_min"   value="">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control"  placeholder="张"  name="num_max" value="">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">图片大小</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname3" placeholder="MB" name="size_min" step="0.01" min="0.01" value="">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="firstname4" placeholder="MB" name="size_max"  value="">
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
						<input type="radio" name="pay"  value="1" checked>每张/组收费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="pay"  value="2">报名费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="pay"  value="0">免费
					</label>
				</div>
            </div>
            <div class="form-group">
				<label for="firstname5" class="col-sm-2 control-label">单价</label>
				<div class="col-sm-2">
					<input type="number" step="0.01" min="0.00" class="form-control" id="firstname5" placeholder="" name="price"  value="">
				</div>
				<div class="col-sm-2">
					<select class="form-control">
						<option>人民币</option>
					</select>
				</div>
			</div>
			<div class="form-group">
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
							<input type="checkbox"  value="author_r" name="required[]" checked> 是否必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="detail" name="info[]" checked> 文字描述
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="detail_r" name="required[]" checked> 是否必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="title" name="info[]" checked> 作品标题
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="title_r" name="required[]" checked> 是否必填
						</label>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-2">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"   value="represent" name="info[]" > 代表单位
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"   value="represent_r"  name="required[]" > 是否必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox" value="year" name="info[]" > 年份
						</label>
						<label class="checkbox-inline" style="padding-left:48px;">
							<input type="checkbox"  value="year_r" name="required[]" > 是否必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="country" name="info[]" > 国籍
						</label>
						<label class="checkbox-inline" style="padding-left:48px;">
							<input type="checkbox"  value="country_r" name="required[]" > 是否必填
						</label>
					</div>
				</div>
				<div class="col-sm-9 col-sm-offset-2">
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="lacation" name="info[]" > 拍摄地点
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="lacation_r" name="required[]" > 是否必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox"  value="size" name="info[]" > 作品尺寸
						</label>
						<label class="checkbox-inline">
							<input type="checkbox"  value="size_r" name="required[]" > 是否必填
						</label>
					</div>
					<div class="col-sm-4">
						<label class="checkbox-inline">
							<input type="checkbox" id="inlineCheckbox1" value="en" name="info[]" > 中英双语
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" id="inlineCheckbox2" value="en_r" name="required[]" > 是否必填
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
					<a class="btn btn-warning" style="background-color:#d4b179;color:#000;border:none;" title="创建团体表单">创建表单</a>
				</div>
			</div>
		</div>
		@endif
		<div class="nextPage">
			<button type="submit" class="btn btn-default" style="margin-left:-211px;">预览</button>
			<button type="submit" class="btn btn-default" style="margin-left:-80px;">保存</button>
			<button type="submit" class="btn btn-default" style="padding:10px 15px;margin-left:50px;">下一页</button>
		</div>
	</form>
</div>

@endsection