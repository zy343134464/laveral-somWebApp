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
		<div class="match-review">
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">独照/组图</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname" placeholder="张/组" name="group_min" value="{{ $v->group_min }}">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname" placeholder="张/组"  name="group_max" value="{{ $v->group_max }}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">每组张数</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname3" placeholder="张"  name="num_min"   value="{{ $v->num_min }}">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="" placeholder="张"  name="num_max" value="{{ $v->num_max }}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">图片大小</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname3" placeholder="MB" name="size_min"  value="{{ $v->size_min }}">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname4" placeholder="MB" name="size_max"  value="{{ $v->size_max }}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">最小边长</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname3" placeholder="像素"  name="length"  value="{{ $v->length }}">
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
				<label for="firstname7" class="col-sm-2 control-label">文字描述</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题"  "name="introdution_title"  value="{{ $v->introdution_title }}">
					<textarea class="form-control" rows="6" placeholder="400字内" name="introdution_detail" >{{ $v->introdution_detail }}</textarea>
				</div>
			</div>
		</div>
		@endforeach
		@else
		<div class="match-review">
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">独照/组图</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname" placeholder="张/组" name="grop_min" name="group_min">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname" placeholder="张/组" name="grop_max" name="group_max">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">每组张数</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname3" placeholder="张"  name="num_min" name="num_min">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="" placeholder="张"  name="num_max" name="num_max">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">图片大小</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname3" placeholder="MB" name="size_min">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname4" placeholder="MB" name="size_max">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">最小边长</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname3" placeholder="像素"  name="length">
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
					<input type="number" step="0.01" min="0.00" class="form-control" id="firstname5" placeholder="" name="price">
				</div>
				<div class="col-sm-2">
					<select class="form-control">
						<option>人民币</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">文字描述</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题"  name="introdution_title"  >
					<textarea class="form-control" rows="6" placeholder="400字内" name="introdution_detail" ></textarea>
				</div>
			</div>
		</div>
		@endif
		<div class="nextPage">
			<button type="submit" class="btn btn-default">下一页</button>
		</div>
	</form>
</div>
@endsection