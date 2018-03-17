@extends('admin.match.create.layout')
@section('title', '新建比赛')

@section('body2')
<div class="match-theme">
	<form class="form-horizontal" role="form" action="{{ url('admin/match/store/'.$type) }}" method="post"  enctype="multipart/form-data">
	 {{ csrf_field() }}
	 	<div class="match-poster">
			<div class="form-group" style="color:red;margin-left:40px;">
			<!-- {{ $errors->first() }} -->{{ session('msg') }}
			</div>
			<img src="" class="pv" >
			<h4>赛事海报</h4>
			<div class="form-group" id="aetherupload-wrapper">
				<div class="col-sm-4 col-sm-offset-2">
					<input type="hidden" class="pic" name="pic" >
					<div class="upload-pic pv" onclick="popShow('popCapture')">
						<div class="limit">
							<p>横板尺寸：1920 X 1080 像素</p>
							<p>jpg png格式,不超过2m</p>
						</div>
						<div class="upload-wrapper">
							<a class="file">+</a>
                			<input type="hidden" name="pic" id="savedpath"><!--需要有一个名为savedpath的id，用以标识文件保存路径的表单字段，还需要一个任意名称的name-->
                            <p class="help-block">点击添加海报</p>
                            <span style="font-size:12px;color:#aaa;" id="output"></span><!--需要有一个名为output的id，用以标识提示信息-->
                            <div class="progress " style="height: 6px;margin-bottom: 2px;margin-top: 10px;width: 200px;margin-left:70px;">
			                    <div id="progressbar" style="background:blue;height:6px;width:0;"></div><!--需要有一个名为progressbar的id，用以标识进度条-->
			                </div>
			                <div id="poster-pic"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="match-detailpage">
			<h4>基本信息</h4>
			<input type="hidden"  name="pid" value="{{ $pid }}">
			<?php
				if($type != 1):
			?>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">赛事类别</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname" placeholder="" name="type">
				</div>
			</div>
			<?php
				endif;
			?>
			<div class="form-group">
				<label for="var1" id="var1" class="col-sm-2 control-label">标题<span class="sure">*</span></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname" placeholder="赛事标题"  name="title[]" required>
				</div>
			</div>
			<p><span id="addVar" class="col-sm-offset-2">+</span></p>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">详情内容<span class="sure">*</span></label>
				<div class="col-sm-8">
					<textarea class="form-control" rows="8" placeholder="400字内 赛事内容"  name="detail" style="resize:none;"  ></textarea>
				</div>
			</div>
		</div>
		@if(!isset($_GET['pid']))
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
@endsection

