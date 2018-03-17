@extends('admin.match.create.layout')
@section('title', '新建比赛')

@section('body2')
<div class="match-theme">
	<form class="form-horizontal" role="form" action="{{ url('admin/match/mainedit/'.$id) }}" method="post"  enctype="multipart/form-data">
	 {{ csrf_field() }}
	 	<div class="match-poster">
			<div class="form-group" style="color:red;margin-left:40px;">
			<!-- {{ $errors->first() }} -->{{ session('msg') }}
			</div>
			<h4>赛事海报</h4>
			<div class="form-group" id="aetherupload-wrapper" >
				<div class="col-sm-4 col-sm-offset-2" >
          <input type="hidden" class="pic" name="pic" value="$match->pic">
					<div class="upload-pic  pv" onclick="popShow('popCapture')">
						<img src="{{ url($match->pic) }}" style="width:100%"  title="点击修改海报">
						
				</div>
      </div>
			</div>
		<div class="match-detailpage">
			<h4 style="padding-bottom:0;">基本信息</h4>
			<!-- {{ $errors->first() }} -->{{ session('msg') }}
			<?php
				if($match->cat != 1):
			?>
			<div class="form-group" style="position:relative;top:20px;">
				<label for="firstname" class="col-sm-2 control-label">赛事类别</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname" placeholder="" name="type" value="{{$match->type }}">
				</div>
			</div>
			<?php
				endif;
			?>
			<div class="form-group" style="margin-bottom:0;position:relative;top:25px;">
				<label for="firstname" class="col-sm-2 control-label">标题<span class="sure">*</span></label>
			</div>
			@foreach(@json_decode($match->title) as $k=>$v)
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="赛事标题"  name="title[]"  value="{{ $v }}" required>
				</div>
				@if($k!=0)
				<span class="removeVar">-</span>
				@endif
			</div>
			@endforeach
			<p><span id="addVar" class="col-sm-offset-2">+</span></p>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">详情内容<span class="sure">*</span></label>
				<div class="col-sm-5">
					<textarea class="form-control" rows="6" placeholder="400字内 赛事内容"  name="detail" required>{{$match->detail}}</textarea>
				</div>
			</div>
		</div>
    @if(match($id,'cat') != 2)
		<div class="match-time">
			<h4>赛事时间设置</h4>
			<div class="form-group">
				<label class="col-sm-2 control-label">征稿开始时间<span class="sure">*</span></label>
				<div class="col-sm-4">
					<input size="14" type="text" placeholder="请选择日期和时间" readonly class="collectstart-datetime-lang am-form-field form-control" name="collect_start"  required>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">征稿结束时间<span class="sure">*</span></label>
				<div class="col-sm-4">
					<input size="14" type="text" placeholder="请选择日期和时间" readonly class="collectend-datetime-lang am-form-field form-control" name="collect_end"  required>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">赛果公布日期</label>
				<div class="col-sm-4">
					<input size="14" type="text" placeholder="请选择日期和时间" readonly class="reviewstart-datetime-lang am-form-field form-control" name="public_time">
				</div>
			</div>
		</div>
    @endif
		<div class="nextPage">
		<input type="submit" value="下一页" class="btn btn-default">
		</div>
	</form>
</div>
@endsection
