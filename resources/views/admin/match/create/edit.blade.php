@extends('admin.match.create.layout')
@section('title', '新建比赛')

@section('body2')
<div class="match-theme">
	<form class="form-horizontal" role="form" action="{{ url('admin/match/mainedit/'.$id) }}" method="post"  enctype="multipart/form-data">
	 {{ csrf_field() }}
		<div class="match-poster">
			<h4>赛事海报设置</h4>
			<!-- {{ $errors->first() }} -->{{ session('msg') }}
			<?php
				if($match->cat != 1):
			?>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">赛事类别</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname" placeholder="" name="type" value="{{$match->type }}">
				</div>
			</div>
			<?php
				endif;
			?>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">赛事标题</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="firstname" placeholder="20字内   海报赛事标题" name="show_title"  value="{{$match->show_title}}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">赛事简介</label>
				<div class="col-sm-5">
					<textarea class="form-control" rows="6" placeholder="50字内"  name="show_introdution" >{{$match->show_introdution}}</textarea>
				</div>
			</div>
		</div>
		<div class="match-detailpage">
			<h4>赛事详情页设置</h4>
			@foreach(@json_decode($match->detail_title) as $k=>$v)
			<div class="form-group">
				<label for="var1" id="var1" class="col-sm-2 control-label">赛事标题</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname" placeholder="赛事标题"  name="detail_title[]"  value="{{ $v }}">
				@if($k!=0)
				<span class="removeVar">-</span>
				@endif
				</div>
			</div>
			@endforeach
			<p><span id="addVar" class="col-sm-offset-2">+</span></p>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">赛事详情内容</label>
				<div class="col-sm-5">
					<textarea class="form-control" rows="6" placeholder="400字内 赛事内容"  name="detail_introdution"  >{{$match->detail_introdution}}</textarea>
				</div>
			</div>
		</div>
		<div class="match-time">
			<h4>赛事时间设置</h4>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">征稿开始时间</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="firstname" placeholder="请选择日期和时间" name="collect_start"  value="{{$match->collect_start}}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">征稿结束时间</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="firstname" placeholder="请选择日期和时间" name="collect_end"  value="{{$match->collect_end}}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">初审结束时间</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="firstname" placeholder="请选择日期和时间" name="review_start"  value="{{$match->review_start}}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">评分截止时间</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="firstname" placeholder="请选择日期和时间" name="review_end"  value="{{$match->review_end}}">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">结果公布时间</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="firstname" placeholder="请选择日期和时间" name="public_time"  value="{{$match->public_time}}">
				</div>
			</div>
		</div>
		<div class="nextPage">
		<input type="submit" value="下一页" class="btn btn-default">
		</div>
	</form>
</div>
@endsection