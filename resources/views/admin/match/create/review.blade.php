@extends('admin.match.create.layout')
@section('title', '评选设定')

@section('body2')
<link rel="stylesheet" href="{{ url('lib/commonLsf/css/commonLsf.css') }}" />
<div class="match-theme">

	<form class="form-horizontal form-lun" role="form" action="{{ url('admin/match/storereview/'.$id) }}" method="post">
		{{ csrf_field() }}
		@if(count($review))
		@foreach($review as $k=>$v)
		<div class="match-review sheave">
			<div class="reviewfirst">
				<h4>第{{['一','二','三','四','五','六','七','八','九','十'][$k]}}轮</h4>
				<div class="form-group">
					<label class="col-sm-2 control-label">评委方式</label>
					<div class="col-sm-2">
						<select class="form-control reviewselect{{$k+1}}" name="type[]">
							<option value="vote" {{ $v->type == 1 ? 'selected' :'' }}>评委投票</option>
							<option value="grade" {{ $v->type == 2 ? 'selected' :'' }}>评委评分</option>
						</select>
					</div>
				</div>
				<div class="reviewvote{{$k+1}}" style="{{ $v->type == 2 ? 'display:none;': ''}}">
					<div class="form-group">
						<label for="time" class="col-sm-2 control-label">评选结束时间</label>
						<div class="col-sm-5">
							<input size="14" type="text" placeholder="请选择日期和时间"  class="elect-datetime-lang am-form-field form-control" name="end_time1[]" value="@if($v->end_time && $v->type == 1){{date('Y-m-d h:i:s', $v->end_time)}}@endif">
						</div>
						<ul class="competition_time">
							<li><span class="over_time"> 征稿结束时间：</span><span>{{$end}}</span></li>
							<li><span class="publish_time">赛果公布日期：</span><span>{{$push}}</span></li>
						</ul>
					</div>
					<div class="form-group NameNum" style="display:none;">
						<label for="number" class="col-sm-2 control-label">入围名额</label>
						<div class="col-sm-2">
							<input type="number" min="0" class="form-control" id="number" placeholder="___名" name="promotion1[]" value="@if($v->type == 1){{ $v->promotion}}@endif">
						</div>
					</div>
					<div class="form-group">
						<label for="number" class="col-sm-2 control-label">评委票数</label>
						<div class="col-sm-2">
							<input type="number" min="0" class="form-control" id="number" placeholder="" name="setting1[vote][0][]"  value="@if($v->type == 1){{ $v->setting}}@endif">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">参与评委</label>
						<div class="col-sm-10">
							<ul class="judgethumb round{{ $k+1}} typeSelectvote">
						<?php
						if($v->type == 1){

							echo arrtorater(json_decode($v->rater,true),$v->round,$v->type);
						}
						?>
								<li class="addjudgethumb">
									<a href="#">
										<div class="add-button" data-toggle="modal" data-target="#matchadd" round="{{ $k+1}}" typeSelect="vote">+</div>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="removeadd text-right a">
						轮数增减：
						<span class="removeVar6">-</span>
						<span class="addVar6">+</span>
					</div>
				</div>
				<div class="reviewgrade{{ $k+1}} {{ $v->type == 1 ? '': 'dimensionality'}}" style="{{ $v->type == 1 ? 'display:none;': ''}}">
					<div class="form-group">
						<label for="time" class="col-sm-2 control-label">评选结束时间</label>
						<div class="col-sm-5">
							<input size="14" type="text" placeholder="请选择日期和时间" class="elect-datetime-lang am-form-field form-control" name="end_time2[]" value="@if($v->end_time && $v->type == 2){{date('Y-m-d h:i:s', $v->end_time)}}@endif">
						</div>
						<ul class="competition_time">
							<li><span class="over_time">征稿结束时间：</span><span>{{$end}}</span></li>
							<li><span class="publish_time">赛果公布日期：</span><span>{{$push}}</span></li>
						</ul>
					</div>
					<div class="form-group NameNum" style="display:none;">
						<label for="number" class="col-sm-2 control-label">入围名额</label>
						<div class="col-sm-2">
							<input type="number" min="0" class="form-control" id="number" placeholder="___名" name="promotion2[]" value="@if($v->type == 2){{ $v->promotion}}@endif">
						</div>
					</div>
					<div class="form-group">
						<label for="number" class="col-sm-2 control-label">分数区间</label>
						<div class="col-sm-2">
							<input type="number" min="0" class="form-control" id="number" placeholder="分" name="min2[]"  value="@if($v->type == 2){{(json_decode($v->setting,true))['min']}}@endif" >
						</div>
						<label class="col-sm-1" style="padding-top:6px;margin-left:-22px;">至</label>
						<div class="col-sm-2" style="margin-left: -74px;">
							<input type="number" min="0" class="form-control" id="number" placeholder="分" name="max2[]" value="@if($v->type == 2){{(json_decode($v->setting,true))['max']}}@endif">
						</div>
						
					</div>
					<div class="form-group">
							<label class="col-sm-2 control-label" style="padding-top:6px;">参考:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" autocomplete="off" name="reference2[]" value="@if($v->type == 2){{(json_decode($v->setting,true))['reference']}}@endif">
							</div>
					</div>

						@if($v->type == 2)
						<span style="color:red;padding-left:190px;">* 评分维度可填写：色彩/创意/构图等</span>
						<div class="form-group">
							<label class="col-sm-2 control-label">分数构成设定</label>
							@foreach((json_decode($v->setting,true))['dimension'] as $kk=>$vv)
							<div style="padding: 0 0 20px 16.7%" class="form-group-weidu">
								<div class="col-sm-2">
									<input type="text" class="form-control weidu" placeholder="维度" name="setting2[dimension][{{$k}}][]" value="{{$vv}}" autocomplete="off">
								</div>
								<div class="col-sm-2" style="margin-left:-20px;">
									<input type="text" class="form-control scoreInput" placeholder="100%" name="setting2[percent][{{$k}}][]" autocomplete="off"
									value="{{(json_decode($v->setting,true))['percent'][$kk]}}">
								</div>
								<span class="removeVar4">-</span>
							</div>
							@endforeach
						</div>
					
						
						@else
						<span style="color:red;padding-left:190px;">* 评分维度可填写：色彩/创意/构图等</span>
						<div class="form-group">
							<label class="col-sm-2 control-label">分数构成设定</label>
							<div style="padding: 0 0 20px 16.7%" class="form-group-weidu">
								<div class="col-sm-2">
									<input type="text" class="form-control weidu" placeholder="维度" name="setting2[dimension][{{$k}}][]" autocomplete="off">
								</div>
								<div class="col-sm-2" style="margin-left:-20px;">
									<input type="text" class="form-control scoreInput" placeholder="100%" name="setting2[percent][{{$k}}][]" autocomplete="off">
								</div>
								<span class="removeVar4">-</span>
							</div>
						</div>
						@endif
						<p><span class="col-sm-offset-2 addVar4" index="{{$k+1}}">+</span></p>
					
					<div class="form-group">
						<label class="col-sm-2 control-label">参与评委</label>
						<div class="col-sm-10">
							<ul class="judgethumb round{{$k+1}} typeSelectgrade">
							<?php
							if($v->type == 2){

								echo arrtorater(json_decode($v->rater,true),$v->round,$v->type);
							}
							?>
								<li class="addjudgethumb">
									<a>
										<div class="add-button" data-toggle="modal" data-target="#matchadd" round="{{$k+1}}" typeSelect="grade">+</div>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="removeadd text-right a">
						轮数增减：
						<span class="removeVar6">-</span>
						<span class="addVar6">+</span>
					</div>
				</div>
			</div>
		</div>
		@endforeach
		@else
<!-- 第一轮 -->
		<div class="match-review sheave">
			<div class="reviewfirst">
				<h4>第一轮</h4>
				<div class="form-group">
					<label class="col-sm-2 control-label">评委方式</label>
					<div class="col-sm-2">
						<select class="form-control reviewselect1" name="type[]">
						<!-- ddssssss -->
							<option value="vote">评委投票</option>
							<option value="grade">评委评分</option>
						</select>
					</div>
				</div>
				<div class="reviewvote1">
				<!-- ssssss -->
					<div class="form-group">
					<label for="time" class="col-sm-2 control-label">评选结束时间</label>
					<div class="col-sm-5">
						<input size="14" type="text" placeholder="请选择日期和时间" class="elect-datetime-lang form-control" name="end_time1[]">
					</div>
					<ul class="competition_time">
							<li><span class="over_time">征稿结束时间：</span><span>{{$end}}</span></li>
							<li><span class="publish_time">赛果公布日期：</span><span>{{$push}}</span></li>
						</ul>
					</div>
					<div class="form-group NameNum">
						<label for="number" class="col-sm-2 control-label">入围名额</label>
						<div class="col-sm-2">
							<input type="number" min="0" class="form-control" id="number" placeholder="___名" name="promotion1[]">
						</div>
					</div>
					<div class="form-group">
						<label for="number" class="col-sm-2 control-label">评委票数</label>
						<div class="col-sm-2">
							<input type="number" min="0" class="form-control" id="number" placeholder="" name="setting1[vote][0][]">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">参与评委</label>
						<div class="col-sm-10">
							<ul class="judgethumb round1 typeSelectvote">
							<!-- ssssss -->
								<li class="addjudgethumb">
									<a>
										<div class="add-button" data-toggle="modal" data-target="#matchadd" round="1" typeSelect="vote">+</div>
										<!-- ssssss -->
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="removeadd text-right a">
						轮数增加：
						<!-- <span class="removeVar6">-</span> -->
						<span class="addVar6">+</span>
					</div>
				</div>
				<div class="reviewgrade1" style="display:none;">
				<!-- ssssss -->
					<div class="form-group">
						<label for="time" class="col-sm-2 control-label">评选结束时间</label>
						<div class="col-sm-5">
							<input size="14" type="text" placeholder="请选择日期和时间" 
							class="elect-datetime-lang am-form-field form-control" name="end_time2[]">
						</div>
						<ul class="competition_time">
							<li><span class="over_time">征稿结束时间：</span><span>{{$end}}</span></li>
							<li><span class="publish_time">赛果公布日期：</span><span>{{$push}}</span></li>
						</ul>
					</div>
					<div class="form-group NameNum">
						<label for="number" class="col-sm-2 control-label">入围名额</label>
						<div class="col-sm-2">
							<input type="number" min="0" class="form-control" id="number" placeholder="___名" name="promotion2[]">
						</div>
					</div>
					<div class="form-group">
						<label for="number" class="col-sm-2 control-label">分数区间</label>
						<div class="col-sm-2">
							<input type="number" min="0" class="form-control" id="number" placeholder="分" name="min2[]">
						</div>
						<label class="col-sm-1" style="padding-top:6px;margin-left:-22px;">至</label>
						<div class="col-sm-2" style="margin-left: -74px;">
							<input type="number" min="0" class="form-control" id="number" placeholder="分" name="max2[]">
						</div>
					</div>
					<div class="form-group">
							<label class="col-sm-2 control-label" style="padding-top:6px;">参考:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="reference2[]" value="">
							</div>
					</div>
					<span style="color:red;padding-left:190px;">* 评分维度可填写：色彩/创意/构图等</span>
					<div class="form-group as">
						<label class="col-sm-2 control-label">分数构成设定</label>
						<div class="col-sm-2">
							<input type="text" class="form-control weidu" placeholder="维度" name="setting2[dimension][0][]" autocomplete="off">
						</div>
						<div class="col-sm-2" style="margin-left:-20px;">
							<input type="text" class="form-control scoreInput" placeholder="100%" name="setting2[percent][0][]" autocomplete="off">
						</div>
						<span class="removeVar4">-</span>
					</div>
					<p><span class="col-sm-offset-2 addVar4" index="1">+</span></p>
					<!-- ssssss -->
					<div class="form-group">
						<label class="col-sm-2 control-label">参与评委</label>
						<div class="col-sm-10">
							<ul class="judgethumb round1 typeSelectgrade">
							<!-- ssssss -->
								<li class="addjudgethumb">
									<a>
										<div class="add-button" data-toggle="modal" data-target="#matchadd" round="1" typeSelect="grade">+</div>
										<!-- ssssss -->
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="removeadd text-right a">
						轮数增加：
						<!-- <span class="removeVar6">-</span> -->
						<span class="addVar6">+</span>
					</div>
				</div>
			</div>
		</div>
<!-- 第二轮 -->		
		<div class="match-review sheave">
			<div class="reviewsecond">
				<h4>第二轮</h4>
				<div class="form-group">
					<label class="col-sm-2 control-label">评委方式</label>
					<div class="col-sm-2">
						<select class="form-control reviewselect2" name="type[]">  
							<option value="vote">评委投票</option>
							<option value="grade" selected>评委评分</option>
						</select>
					</div>
				</div>
				<div class="reviewvote2" style="display:none;">
					<div class="form-group">
					<label for="time" class="col-sm-2 control-label">评选结束时间</label>
					<div class="col-sm-5">
						<input size="14" type="text" placeholder="请选择日期和时间" 
						class="elect-datetime-lang am-form-field form-control" name="end_time1[]">
					</div>
					<ul class="competition_time">
						<li><span class="over_time">征稿结束时间：</span><span>{{$end}}</span></li>
						<li><span class="publish_time">赛果公布日期：</span><span>{{$push}}</span></li>
					</ul>
					</div>
					<div class="form-group NameNum">
						<label for="number" class="col-sm-2 control-label">入围名额</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="number" placeholder="___名" name="promotion1[]">
						</div>
					</div>
					<div class="form-group">
						<label for="number" class="col-sm-2 control-label">评委票数</label>
						<div class="col-sm-2">
							<input type="number" min="0" class="form-control" id="number" placeholder="" name="setting1[vote][1][]">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">参与评委</label>
						<div class="col-sm-10">
							<ul class="judgethumb round2 typeSelectvote">
								<li class="addjudgethumb">
									<a>
										<div class="add-button diyBtn" data-toggle="modal" data-target="#matchadd" round="2" typeSelect="vote">+</div>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="removeadd text-right a">
						轮数增减：
						<span class="removeVar6">-</span>
						<span class="addVar6">+</span>
					</div>
				</div>
				<div class="reviewgrade2 dimensionality">
					<div class="form-group">
						<label for="time" class="col-sm-2 control-label">评选结束时间</label>
						<div class="col-sm-5">
							<input size="14" type="text" placeholder="请选择日期和时间" 
							class="elect-datetime-lang am-form-field form-control" name="end_time2[]">
						</div>
						<ul class="competition_time">
							<li><span class="over_time">征稿结束时间：</span><span>{{$end}}</span></li>
							<li><span class="publish_time">赛果公布日期：</span><span>{{$push}}</span></li>
						</ul>
					</div>
					<div class="form-group NameNum">
						<label for="number" class="col-sm-2 control-label">入围名额</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="number" placeholder="___名" name="promotion2[]">
						</div>
					</div>
					<div class="form-group">
						<label for="number" class="col-sm-2 control-label">分数区间</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="number" placeholder="分" name="min2[]">
						</div>
						<label class="col-sm-1" style="padding-top:6px;margin-left:-22px;">至</label>
						<div class="col-sm-2" style="margin-left: -74px;">
							<input type="number" min="0" class="form-control" id="number" placeholder="分" name="max2[]">
						</div>
						</div>
					<div class="form-group">
							<label class="col-sm-2 control-label" style="padding-top:6px;">参考:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" autocomplete="off" name="reference2[]" value="">
							</div>
					</div>
					<span style="color:red;padding-left:190px;">* 评分维度可填写：色彩/创意/构图等</span>
					<div class="form-group as">
						<label class="col-sm-2 control-label">分数构成设定</label>
						<div class="col-sm-2">
							<input type="text" class="form-control weidu" placeholder="维度" name="setting2[dimension][1][]" autocomplete="off">
						</div>
						<div class="col-sm-2" style="margin-left:-20px;">
							<input type="text" class="form-control scoreInput" placeholder="100%" name="setting2[percent][1][]" autocomplete="off">
						</div>
						<span class="removeVar4">-</span>
					</div>
					<p><span class="col-sm-offset-2 addVar4" index="2">+</span></p>
					<div class="form-group">
						<label class="col-sm-2 control-label">参与评委</label>
						<div class="col-sm-10">
							<ul class="judgethumb round2 typeSelectgrade">
								<li class="addjudgethumb">
									<a>
										<div class="add-button" data-toggle="modal" data-target="#matchadd" round="2" typeSelect="grade">+</div>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="removeadd text-right a">
						轮数增减：
						<span class="removeVar6">-</span>
						<span class="addVar6">+</span>
					</div>
				</div>
			</div>
		</div>
		@endif
		@if(count($win))
		<div class="match-review">
			<div class="match-winout" style="border-bottom: 0">
				<h4>胜出设置</h4>
				<div class="form-group">
					<label for="" class="col-sm-3 control-label">奖项名称</label>
					<label for="" class="col-sm-2 control-label" style="margin-left:-48px;">名额</label>
				</div>
				@foreach($win as $wv)
				<div class="form-group">
					<div class="col-sm-2 col-sm-offset-2">
						<input type="text" class="form-control" autocomplete="off" placeholder="输入奖项名称" name="win_name[]" value="{{ $wv->name }}">
					</div>
					<div class="col-sm-1" style="margin-left:-20px;">
						<input type="number" class="form-control" autocomplete="off" placeholder="" min="0" name="win_number[]"  value="{{ $wv->num }}">
					</div>
					<span class="removeVar5">-</span>
				</div>
				@endforeach
				<p><span class="col-sm-offset-2 addVar5">+</span></p>
			</div>
		</div>
		@else
		<div class="match-review">
			<div class="match-winout" style="border-bottom: 0">
				<h4>胜出设置</h4>
				<div class="form-group">
					<label for="" class="col-sm-3 control-label">奖项名称</label>
					<label for="" class="col-sm-2 control-label" style="margin-left:-48px;">名额</label>
				</div>
				<div class="form-group">
					<div class="col-sm-2 col-sm-offset-2">
						<input type="text" class="form-control" placeholder="输入奖项名称" name="win_name[]" autocomplete="off">
					</div>
					<div class="col-sm-1" style="margin-left:-20px;">
						<input type="number" class="form-control" placeholder="__名" min="0" name="win_number[]" autocomplete="off">
					</div>
					<span class="removeVar5">-</span>
				</div>
				<p><span class="col-sm-offset-2 addVar5">+</span></p>
			</div>
		</div>
		@endif
		@if(count($pop))
		<div class="match-review">
			<div class="match-people">
				<h4>人气投票设定</h4>
				<div class="form-group">
					<label for="" class="col-sm-4 control-label">是否为赛事添加人气投票?</label>
					<div class="col-sm-6">
						<label class="radio-inline">
							<input type="radio" name="hot"  value="1" checked>是
						</label>
						<label class="radio-inline" style="padding-left:60px;">
							<input type="radio" name="hot"  value="0" >否
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="time" class="col-sm-2 control-label">开始时间</label>
					<div class="col-sm-5">
						<input size="14" type="text" placeholder="请选择日期和时间" 
						class="peoplestrat-datetime-lang am-form-field form-control" name="hot_start" value="{{date('Y-m-d h:i:s', $pop->start)}}">
					</div>
				</div>
				<div class="form-group">
					<label for="time" class="col-sm-2 control-label">结束时间</label>
					<div class="col-sm-5">
						<input size="14" type="text" placeholder="请选择日期和时间"  class="peopleend-datetime-lang am-form-field form-control" name="hot_end" value="{{date('Y-m-d h:i:s', $pop->end)}}">
					</div>
				</div>
			</div>
		</div>
		@else
		<div class="match-review">
			<div class="match-people">
				<h4>人气投票设定</h4>
				<div class="form-group">
					<label for="" class="col-sm-4 control-label">是否为赛事添加人气投票?</label>
					<div class="col-sm-6">
						<label class="radio-inline">
							<input type="radio" name="hot"  value="1">是
						</label>
						<label class="radio-inline" style="padding-left:60px;">
							<input type="radio" name="hot"  value="0" checked>否
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="time" class="col-sm-2 control-label">开始时间</label>
					<div class="col-sm-5">
						<input size="14" type="text" placeholder="请选择日期和时间" class="peoplestrat-datetime-lang am-form-field form-control" name="hot_start">
					</div>
				</div>
				<div class="form-group">
					<label for="time" class="col-sm-2 control-label">结束时间</label>
					<div class="col-sm-5">
						<input size="14" type="text" placeholder="请选择日期和时间"  class="peopleend-datetime-lang am-form-field form-control" name="hot_end">
					</div>
				</div>
			</div>
		</div>
		@endif
		<div class="nextPage">
			<button type="submit" class="btn btn-default" style="padding:10px 15px;margin-right:20px;" _href="{{ url('admin/match/require_personal/'.$id) }}" onclick="return addInput(0,2,this)">上一页</button>
			<button type="submit" class="btn btn-default" style="padding:10px 15px;margin-right:10px;" onclick="return addInput(0,0)">保存</button>
			<!-- <button type="submit" class="btn btn-default" onclick="return addInput(1)">确认提交</button> href="{{ url('admin/match/showedit/'.$id) }} -->
			@if( $match->cat !=2)
			<button type="submit" class="btn btn-default" style="padding:10px 15px;margin-left:10px;" _href="{{ url('admin/match/showedit/'.$id) }}"  onclick="return addInput(0,1,this)">预览</button>
			@endif
		</div>
	</form>
	<iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
</div>



<!-- 评委模态框 -->
<div class="modal fade" id="matchadd" tabindex="-1" role="dialog" aria-labelledby="matchaddlabel" aria-hidden="true">
    <div class="modal-dialog modal200">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="matchaddlabel">
                    参与评委
                </h4>
            </div>
            <div class="modal-body">
              	<div class="match-guestdata">
				    <form name="searchrater">
				        {{ csrf_field() }}
				        <!--搜索框-->
				        <div class="search-form">
			               <button class="btn btn-sm btn-default fa fa-search" style="margin-left:-10px;border:none;"></button>
			               <input type="text" name="kw" placeholder="请输入手机或用户名">
			            </div>
				    </form>
				    <form name="addrater">
				        <div class="addguest text-right">
				            <a href="#" class="btn btn-default new" data-toggle="modal" data-target="#matchnew">新建评委</a>
				            <input type="submit" value="添加到赛事" class="btn btn-default add">
				        </div>
				        <div class="content">
				            <ul class="judgedata"></ul>
				        </div>
				    </form>
				</div>
				<!-- 新建赛事模态框 -->
				<div class="modal fade" id="matchnew" tabindex="-1" role="dialog" aria-labelledby="matchnewlabel" aria-hidden="true">
				    <div class="modal-dialog moda360">
				        <div class="modal-content">
				            <div class="modal-header">
				                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
				                    &times;
				                </button>
				                <h4 class="modal-title" id="matchnewlabel">
				                    新建评委
				                </h4>
				            </div>
				            <div class="modal-body">
				               <div class="match-new">
				                    <form class="form-horizontal" role="form" name="addguest">
					                    {{ csrf_field() }}
					                        <div class="form-group">
				                            <label class="col-sm-3 control-label">手机号</label>
				                            <div class="col-sm-8">
				                                <input type="text" class="form-control" name="phone">
				                            </div>
				                        </div>
				                        <div class="form-group">
				                            <label for="grade" class="col-sm-3 control-label">用户名</label>
				                            <div class="col-sm-8">
				                                <input type="text" class="form-control" name="name" autocomplete="off">
				                            </div>
				                        </div>
				                        <div class="form-group">
				                            <label for="grade" class="col-sm-3 control-label">密码</label>
				                            <div class="col-sm-8">
				                                <input type="text" class="form-control" name="password">
				                            </div>
				                        </div>
				                        <div class="modal-footer">
				                            <div class="col-sm-5" style="margin-left:-5px;">
				                                <input type="submit" class="btn btn-default" value="确认提交" id="btnnewguest">
				                            </div>
				                        </div>
				                    </form>
				                </div>
				            </div>
				        </div><!-- /.modal-content -->
				    </div><!-- /.modal -->
				</div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script>
	var status = true;
					//表单提交事件
		    function addInput (id,judge,e){
				// 分数维度判断开始
				for(let i=0;i<$('.dimensionality').length;i++){
					var number = 0;
					
					// if($('.dimensionality .weidu').eq(i).length<0){
					// 	alert('维度不能为空！');
					// 	$('.dimensionality .weidu').eq(i).css('border','1px solid red');
					// 	return false;
					// };
					for(let j=0;j<$('.dimensionality')[i].getElementsByClassName('scoreInput').length;j++){
						if($('.dimensionality')[i].getElementsByClassName('weidu')[j].value==''||$('.dimensionality')[i].getElementsByClassName('weidu')[j].value==undefined||$('.dimensionality')[i].getElementsByClassName('weidu')[j].value.length<=0){
							$('.dimensionality')[i].getElementsByClassName('weidu')[j].style.border='1px solid red';
								alert('分数维度未填写！');
								return false;
						}
						 
						number +=parseInt($('.dimensionality')[i].getElementsByClassName('scoreInput')[j].value);
					}
					if(number>100){
						alert('分数维度大于100！');
						for(let o=0;o<$('.dimensionality')[i].getElementsByClassName('scoreInput').length;o++){
							$('.dimensionality')[i].getElementsByClassName('scoreInput')[o].style.border='1px solid red';
						}
						return false;
					}else if(number<100){
						alert('分数维度小于100！');
						for(let o=0;o<$('.dimensionality')[i].getElementsByClassName('scoreInput').length;o++){
							$('.dimensionality')[i].getElementsByClassName('scoreInput')[o].style.border='1px solid red';
						}
						return false;
					}else if(number==100){
						for(let o=0;o<$('.dimensionality')[i].getElementsByClassName('scoreInput').length;o++){
							$('.dimensionality')[i].getElementsByClassName('scoreInput')[o].style.border='1px solid #ccc';
						}
					}else{
						alert('分数维度不等于100！');
						for(let o=0;o<$('.dimensionality')[i].getElementsByClassName('scoreInput').length;o++){
							$('.dimensionality')[i].getElementsByClassName('scoreInput')[o].style.border='1px solid red';
						}
						return false;
					}
				}
		        var $inputTpl = '<input type="hidden" name="jump" value="'+id+'">';
		        $('.nextPage').prepend($inputTpl);

		        document.forms[0].target="rfFrame";
		        $.ajax({  
	                cache: true,  
	                type: "POST",  
	                url:"{{ url('admin/match/storereview/'.$id) }}",  
	                data:$('.form-lun').serialize(),// 你的formid  
	                async: false,  
	                error: function(request) {  
	                   
	                },  
	                success: function(data) {  
						alert(data)
						$('.weidu').css('border','1px solid #ccc');

	                	if({{ $match->cat }}==0){			//单项赛事
							if(judge==0){					//保存按钮点击
								// alert(data);
							}else if(judge==1){							//预览按钮点击
								console.log(e.getAttribute('_href'))
								window.location.href = e.getAttribute('_href');
							}else{
								console.log(e.getAttribute('_href'))
								window.location.href = e.getAttribute('_href');
							}
						}else if({{ $match->cat }}==2){								//子赛事保存
							console.log('{{ $match->pid }}')
							var www = window.location.protocol+'//'+window.location.host+'/admin/match/son/';
							window.location.href = www+'{{ $match->pid }}';
						}
						// console.log({{ $match->cat }},judge)http://39.108.168.33:7979/admin/match/son/441
						
	                }  
	            });  

			  };
window.onload = function(){
	  /*评选设定*/

    // 鼠标移动效果出现删除按钮
    $('.judgethumb').on('mouseenter','li',function(){
      $(this).find('.close').css('display','block');
    })
    $('.judgethumb').on('mouseleave','li',function(){
      $(this).find('.close').css('display','none');
    })


    // 分数构成设定
    $('.form-group-weidu:last-child').css('padding-bottom','0px');
    $('input').attr('autocomplete','off');

    //初始参数个数

    var varCount4 = 1;
      //新增按钮点击
      $('form').on('click','.addVar4',function(){
        varCount4++;
        $node = '<div class="form-group as"><label for="var'+varCount4+'" id="var'+varCount4+'" class="col-sm-2 control-label"></label>'
        + '<div class="col-sm-2"><input type="text" class="form-control weidu" placeholder="维度" name="setting2[dimension]['+($(this).attr('index')-1)+'][]"></div>'
        +'<div class="col-sm-2" style="margin-left:-20px;"><input type="text" class="form-control scoreInput" placeholder="100%" name="setting2[percent]['+($(this).attr('index')-1)+'][]"></div>'
        + '<span class="removeVar4">-</span></div>';
        //新表单项添加到“新增”按钮前面
        $(this).parent().before($node);
      });

      //删除按钮点击
      $('form').on('click', '.removeVar4', function(){
        $(this).parent().remove();
        varCount4--;
      });

    /*胜出设置*/

    var varCount5 = 1;
      //新增按钮点击
      $('.addVar5').on('click', function(){
        varCount5++;
        $node = '<div class="form-group"><div class="col-sm-2 col-sm-offset-2"><input type="text" autocomplete="off" class="form-control" placeholder="输入奖项名称" name="win_name[]" value=""></div>'
        + '<div class="col-sm-1" style="margin-left:-20px;"><input type="number" autocomplete="off" class="form-control" placeholder="__名" name="win_number[]" min="0" value=""></div>'
        + '<span class="removeVar5">-</span></div>';
        //新表单项添加到“新增”按钮前面
        $(this).parent().before($node);
      });

      //删除按钮点击
      $('form').on('click', '.removeVar5', function(){
        $(this).parent().remove();
        varCount5--;
      });
	  //最后一轮无入围名额
		function conceal(){
			var no = document.getElementsByClassName('NameNum');
			for(let i=0;i<no.length;i++){
			no[i].style.display = 'block';
			}
			no[no.length-1].style.display = 'none';
			no[no.length-2].style.display = 'none';
		}
		conceal();
      /*增加删除轮数*/
      var sheave = $('.sheave').length;
    //新增按钮点击
    $('form').on('click','.addVar6',function(){
		
      sheave++;
      var aBigNumber = ['一','二','三','四','五','六','七','八','九','十'];
      var bigNumber = aBigNumber[sheave-1];
      $node = '<div class="match-review sheave"><div class="reviewsecond"><h4>第'+bigNumber+'轮</h4><div class="form-group"><label class="col-sm-2 control-label">评委方式</label><div class="col-sm-2">'
      + '<select class="form-control reviewselect'+sheave+'" name="type[]"><option value="vote">评委投票</option><option value="grade" selected>评委评分</option></select></div>'
      + '</div><div class="reviewvote'+sheave+'" style="display:none;"><div class="form-group"><label for="time" class="col-sm-2 control-label">评选结束时间</label>'
      + '<div class="col-sm-5"><input size="14" type="text" placeholder="请选择日期和时间" class="elect-datetime-lang am-form-field form-control" name="end_time1[]"></div><ul class="competition_time"><li><span class="over_time">征稿结束时间：</span><span>{{$end}}</span></li><li><span class="publish_time">赛果公布日期：</span><span>{{$push}}</span></li></ul></div><div class="form-group NameNum">'
      + '<label for="number" class="col-sm-2 control-label">入围名额</label><div class="col-sm-2"><input type="text" class="form-control" id="number" placeholder="___名" name="promotion1[]"></div></div>'
      + '<div class="form-group"><label for="number" class="col-sm-2 control-label">评委票数</label><div class="col-sm-2"><input type="number" min="0" class="form-control" id="number" placeholder="" name="setting1[vote][0][]"></div></div>'
      + '<div class="form-group"><label class="col-sm-2 control-label">参与评委</label><div class="col-sm-10"><ul class="judgethumb round'+sheave+' typeSelectvote"><li class="addjudgethumb">'
      + '<a><div class="add-button" data-toggle="modal" data-target="#matchadd" round="'+sheave+'" typeSelect="vote">+</div></a></li></ul></div></div></div><div class="reviewgrade'+sheave+' dimensionality">'
      + '<div class="form-group"><label for="time" class="col-sm-2 control-label">评选结束时间</label><div class="col-sm-5"><input size="14" type="text" placeholder="请选择日期和时间" class="elect-datetime-lang am-form-field form-control" name="end_time2[]">'
      + '</div><ul class="competition_time"><li><span class="over_time">征稿结束时间：</span><span>{{$end}}</span></li><li><span class="publish_time">赛果公布日期：</span><span>{{$push}}</span></li></ul></div><div class="form-group NameNum"><label for="number" class="col-sm-2 control-label">入围名额</label><div class="col-sm-2"><input type="text" class="form-control" id="number" placeholder="___名" name="promotion2[]">'
      + '</div></div><div class="form-group"><label for="number" class="col-sm-2 control-label">分数区间</label><div class="col-sm-2"><input type="text" class="form-control" id="number" placeholder="分" name="min2[]"></div>'
      + '<label class="col-sm-1" style="padding-top:6px;margin-left:-22px;">至</label><div class="col-sm-2" style="margin-left: -74px;"><input type="number" min="0" class="form-control" id="number" paceholder="分" name="max2[]"></div></div><div class="form-group"><label class="col-sm-2 control-label" style="padding-top:6px;">参考:</label><div class="col-sm-4">'
      + '<input type="text" class="form-control" name="reference2[]" autocomplete="off"></div></div><span style="color:red;padding-left:190px;">*评分维度可填写：色彩/创意/构图等</span><div class="form-group"><label class="col-sm-2 control-label">分数构成设定</label><div style="padding:0 0 0 16.7%;" class><div class="col-sm-2">'
      + '<input type="text" class="form-control weidu" placeholder="维度" autocomplete="off" name="setting2[dimension]['+(sheave-1)+'][]"></div><div class="col-sm-2" style="margin-left:-20px;"><input type="text" class="form-control scoreInput" placeholder="100%" name="setting2[percent]['+(sheave-1)+'][]">'
      + '</div><span class="removeVar4">-</span></div></div>'
      + '<p><span class="col-sm-offset-2 addVar4" index='+sheave+'>+</span></p><div class="form-group"><label class="col-sm-2 control-label">参与评委</label><div class="col-sm-10"><ul class="judgethumb round'+sheave+' typeSelectgrade"><li class="addjudgethumb">'
      + '<a><div class="add-button" data-toggle="modal" data-target="#matchadd" round="'+sheave+'" typeSelect="grade">+</div></a></li></ul></div></div><div class="removeadd text-right">'
      + '轮数增减：<span class="removeVar6">-</span> <span class="addVar6">+</span></div></div></div></div>';
        //新表单项添加到“新增”按钮前面
        $(this).parent().parent().parent().parent().parent('.form-horizontal').children('.match-review').eq(-2).before($node);
       // $(this).parent().css("display","none");
       	//    $('.elect-datetime-lang').datetimepicker({step:10,format:'Y-m-d H:i', minDate:y_m_d});
		  initDateTime();
		  $('.elect-datetime-lang').click(function(){
				initDateTime()
			})
		  conceal();
      });

  // 切换评选方式
    for(let i = 1; i < 10; i++){
      $("form").on('change','.reviewselect'+i+'',function() {
        let n = $(this).val();
        if(n === "vote"){
		  $(".reviewgrade"+i+"").hide();
		  $(".reviewgrade"+i+"").removeClass('dimensionality');
          $(".reviewvote"+i+"").show();
        }else if(n === "grade"){
          $(".reviewvote"+i+"").hide();
		  $(".reviewgrade"+i+"").show();
		  $(".reviewgrade"+i+"").addClass('dimensionality');
        }
      });
    }
   

    //删除按钮点击    
// console.log($('.match-review.sheave').length,$('.match-review.sheave').length>1);
    $('form').on('click','.removeVar6', function(){
// console.log($('.match-review.sheave').length);

    	if($('.match-review.sheave').length>1){
    		 $(this).parent().parent().parent().parent().remove();
		      var sheaveprev = sheave-2;
		    //   console.log($('.match-review').eq(sheaveprev).find('.removeadd').show());
			  sheave--;
			  conceal();
    	}
     
	});
	function initrater(){
		$.ajax({
			url: '/admin/match/search_rater',
			method: 'get',
			async: false,
			data: '',
			success: function(data){
				var oData = JSON.parse(data);
				// console.log(oData)
				$('.judgedata').html('');
				viewrater(oData);
			}
		})
	}
	initrater();
	function viewrater(oData){
          var judgedataUl = $('.judgedata');
          
          for(var i = 0;i<oData.length;i++){
            var judgedatali = $('<li></li>')
            var a = $('<a></a>');
            judgedataUl.append(judgedatali);
            judgedatali.append(a);

            var judgedata_img = $('<div class="judgedata-img"></div>');
            var img = $('<img src="/'+oData[i].pic+'" alt="">');
            var check = $('<div class="check"><i class="fa fa-check"></i></div>');

            a.append(judgedata_img);
            judgedata_img.append(img);
            judgedata_img.append(check);

            var judgedata_content = $('<div class="judgedata-content text-left"> ');
            var input = $('<input type="hidden" value="'+oData[i].id+'">');
            var h4 = $('<h4>'+oData[i].name+'</h4>');
            var p1 = $('<p>'+oData[i].second_name+'</p>');
            var p2 = $('<p style="overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient: vertical;">'+oData[i].introdution+'</p>');

            a.append(judgedata_content);
            judgedata_content.append(input);
            judgedata_content.append(h4);
            judgedata_content.append(p1);
            judgedata_content.append(p2);

            var model = $('<div class="model middle"></div>');
            a.append(model);
          }
        }
    /*参与评委搜索功能*/
    var formrater = $('form[name=searchrater]');
      formrater.on('submit',function(e){
		e.preventDefault();
        $('.judgedata').html('');
		var string = formrater.serialize();
		// console.log('123',string)
        $.ajax({
          url: '/admin/match/search_rater',
          method: 'get',
          async: false,
          data: string,
          success: function(data){
            var oData = JSON.parse(data);
            viewrater(oData);
            $('[name="kw"]').val(' ');
          }
		})
      })
 
    /*添加评委到赛事*/
    $('form').on('click','.add',function(e){
    	e.preventDefault();
        var liSelect = $('.judgedata li[index]');
        var aa = '.round' + $(this).attr('round');
        var bb = '.typeSelect' + $(this).attr('typeSelect');
        var ff = aa + bb;
        var judgethumbInput = $(ff+' li input');
        var aId = [];
        for(var i = 0;i < judgethumbInput.length;i++){
          aId[i] = judgethumbInput.eq(i).val();
        }

        for(var i = 0;i< liSelect.length;i++){
          var cc = '.round' + $(this).attr('round');
          var dd = '.typeSelect' + $(this).attr('typeSelect');

          var string = '';
          if($(this).attr('typeSelect')==="vote"){
          	string = string + 'rater1['+($(this).attr('round')-1)+'][]';
          }else{
          	string = string + 'rater2['+($(this).attr('round')-1)+'][]';
          }
          var ee = cc + dd;
          var raterUl = $(ee);
          var raterLi = $('<li></li>');
          var a = $('<a href="#"></a>');
          var liSelectImgSrc = liSelect.eq(i).find('img').attr('src');
          var liSelectText = liSelect.eq(i).find('h4').text();
          var liSelectinputId = liSelect.eq(i).find('input').val();
          var result = $.inArray(liSelectinputId,aId);
          if(result > -1){
            continue;
          }
          var input = $('<input type="hidden" value="'+liSelectinputId+'" name="'+string+'">');
          var img = $('<img src="'+liSelectImgSrc+'" alt="">');
          var p = $('<p>'+liSelectText+'</p>');
          var close = $('<div class="close"><i class="fa fa-close"></i></div>');

          raterUl.children('li').eq(-1).before(raterLi);
          raterLi.append(a);
          a.append(input)
          a.append(img);
          a.append(p);
          a.append(close);
        }
        $('.modal').modal('hide');
  		$('.judgedata').html('');
    })

  $('form').on('click','.close', function(e){
    e.preventDefault();
    $(this).parent().parent().remove();
  });

  $('form').on('click','.add-button',function(){
	initrater();
    $('.add').attr('round',$(this).attr('round'));
    $('.add').attr('typeSelect',$(this).attr('typeSelect'))
  })

	var form = $('form[name=addguest]');
	form.on('submit',function(e){
		e.preventDefault();
		var string = form.serialize();
		$.ajax({
			url: '/admin/match/add_rater/{{$id}}',
			method: 'post',
			data: string,
			success: function(data){
				// 获取评委id
				var data = JSON.parse(data);
				getRaterInfo(data);
			}
		})

		// 获取评委信息
		function getRaterInfo(data){
			if (data.data) {
				$.ajax({
					url: '/admin/match/get_rater_info/'+data.data+'',
					method: 'get',
					success: function(data){
						alert("添加成功");
						$('.modal').modal('hide');
					}
				})
			}else{
				alert(window.decodeURIComponent(data.msg))
			};
		}

	})

	var currtTime = new Date;
	var y_m_d = currtTime.getFullYear()+"-"+(currtTime.getMonth()+1)+'-'+currtTime.getDate();
	// console.log('{{$end}}','{{$push}}')
	 //评选结束时间
    
	function analysis(str){
      var time = str.substring(str.indexOf(' ')+1);
      var date = str.substring(0,str.indexOf(' '));
      var Dates = date.split('-').join('/');
      var obj = [Dates,time];
      return obj;
	}
	var endTime = analysis('{{$end}}')[1];   //征稿结束时间
	var endDate = analysis('{{$end}}')[0];  //征稿结束日期
	var reviewstart = analysis('{{$push}}')[1];  //赛果时间
	var reviewstartDate = analysis('{{$push}}')[0];  //赛果日期
	// console.log(endTime,endDate)
	// console.log('{{$push}}')

function initDateTime(){
	
	for(let i=0;i<$('.sheave').length;i++){
		if(i==0){						//判断是第一轮
			if($('.reviewvote'+(i+2)).length!=0){										//下一轮存在情况下
				if($('.reviewvote'+(i+2)).css('display')=='none'){						//判断哪一种评委方式显示
					var nextDatetime = $('.reviewgrade'+(i+2)+' .elect-datetime-lang').val();
				}else{
					var nextDatetime = $('.reviewvote'+(i+2)+' .elect-datetime-lang').val();
				}
				if(nextDatetime!=''){													//下一轮时间框有值
					var nextTime = analysis(nextDatetime)[1];   //下一轮时间
					var nextDate = analysis(nextDatetime)[0];  	//下一轮日期
					// console.log(nextTime)
					// console.log(nextDate)
					$('.reviewvote'+(i+1)+' .elect-datetime-lang').datetimepicker({
						format:'Y-m-d H:i',
						lang:'ch',
						step:10,
						validateOnBlur:false,
						minDate:endDate,
						maxDate:nextDate,
						onSelectDate:function(ct){
							// console.log(new Date(nextDatetime).getDate())
							if(ct.getDate()==new Date(nextDatetime).getDate()){		//点击到的时间与下一轮评审结束时间相同
								// console.log(123)
								this.setOptions({
									minTime:false,
									maxTime:new Date(nextDatetime).getHours()+':'+new Date(nextDatetime).getMinutes()
								});
							}else if(ct.getDate()==new Date(endDate).getDate()){
								this.setOptions({
									minTime:endTime,
									maxTime:false
								});
							}else{
								// console.log(321)
								this.setOptions({
									minTime:false,
									maxTime:false
								});
							}
						}
					});
					$('.reviewgrade'+(i+1)+' .elect-datetime-lang').datetimepicker({
						format:'Y-m-d H:i',
						lang:'ch',
						step:10,
						validateOnBlur:false,
						minDate:endDate,
						maxDate:nextDate,
						onSelectDate:function(ct){
							// console.log(new Date(nextDatetime).getDate())
							if(ct.getDate()==new Date(nextDatetime).getDate()){		//点击到的时间与下一轮评审结束时间相同
								// console.log(123)
								this.setOptions({
									minTime:false,
									maxTime:new Date(nextDatetime).getHours()+':'+new Date(nextDatetime).getMinutes()
								});
							}else if(ct.getDate()==new Date(endDate).getDate()){
								this.setOptions({
									minTime:endTime,
									maxTime:false
								});
							}else{
								// console.log(321)
								this.setOptions({
									minTime:false,
									maxTime:false
								});
							}
						}
					});
				}else{																		//下一轮时间框无值
					if('{{$push}}'=='未设置'){												//赛果未设置
						$('.reviewvote'+(i+1)+' .elect-datetime-lang').datetimepicker({
							format:'Y-m-d H:i',
							lang:'ch',
							step:10,
							validateOnBlur:false,
							minDate:endDate,
							onSelectDate:function(ct){
								// console.log(new Date(reviewstartDate).getDate())
								if(ct.getDate()==new Date(endDate).getDate()){
									this.setOptions({
										minTime:endTime,
										maxTime:false
									});
								}else{
									this.setOptions({
										minTime:false,
										maxTime:false
									});
								}
							}
						});
						$('.reviewgrade'+(i+1)+' .elect-datetime-lang').datetimepicker({
							format:'Y-m-d H:i',
							lang:'ch',
							step:10,
							validateOnBlur:false,
							minDate:endDate,
							onSelectDate:function(ct){
								
								if(ct.getDate()==new Date(endDate).getDate()){
									this.setOptions({
										minTime:endTime,
										maxTime:false
									});
								}else{
									this.setOptions({
										minTime:false,
										maxTime:false
									});
								}
							}
						});
					}else{
						$('.reviewvote'+(i+1)+' .elect-datetime-lang').datetimepicker({
							format:'Y-m-d H:i',
							lang:'ch',
							step:10,
							validateOnBlur:false,
							minDate:endDate,
							maxDate:reviewstartDate,
							onSelectDate:function(ct){
								// console.log(new Date(reviewstartDate).getDate())
								if(ct.getDate()==new Date(endDate).getDate()){
									this.setOptions({
										minTime:endTime,
										maxTime:false
									});
								}else if(ct.getDate()==new Date(reviewstartDate).getDate()){
									this.setOptions({
										minTime:false,
										maxTime:reviewstart
									});
								}else{
									this.setOptions({
										minTime:false,
										maxTime:false
									});
								}
							}
						});
						$('.reviewgrade'+(i+1)+' .elect-datetime-lang').datetimepicker({
							format:'Y-m-d H:i',
							lang:'ch',
							step:10,
							validateOnBlur:false,
							minDate:endDate,
							maxDate:reviewstartDate,
							onSelectDate:function(ct){
								
								if(ct.getDate()==new Date(endDate).getDate()){
									this.setOptions({
										minTime:endTime,
										maxTime:false
									});
								}else if(ct.getDate()==new Date(reviewstartDate).getDate()){
									this.setOptions({
										minTime:false,
										maxTime:reviewstart
									});
								}else{
									this.setOptions({
										minTime:false,
										maxTime:false
									});
								}
							}
						});
					}
					
				}
				
			}else{
				$('.elect-datetime-lang').datetimepicker({
					format:'Y-m-d H:i',
					lang:'ch',
					step:10,
					validateOnBlur:false,
					minDate:endDate,
					maxDate:reviewstartDate,
					onSelectDate:function(ct){
						if(ct.getDate()==new Date(endDate).getDate()){
							this.setOptions({
								minTime:endTime,
								maxTime:false
							});
						}else if(ct.getDate()==new Date(reviewstartDate).getDate()){
							this.setOptions({
								minTime:false,
								maxTime:reviewstart
							});
						}else{
							this.setOptions({
								minTime:false,
								maxTime:false
							});
						}
					}
				});
			}
			
		}else{
			// console.log(i)
			// if($('.reviewvote'+(i+2)).length!=0){										//判断下一轮存在
			// console.log(0)
			// 	if($('.reviewvote'+(i+2)).css('display')=='none'){
			// 		// console.log(123)
			// 	}
			// }else{																		//判断下一轮不存在
			// console.log(3)
				if($('.reviewvote'+i).css('display')=='none'){						//判断哪一种评委方式显示
					var prevDatetime = $('.reviewgrade'+i+' .elect-datetime-lang').val();
				}else{
					var prevDatetime = $('.reviewvote'+i+' .elect-datetime-lang').val();
				}
				// console.log(prevDatetime)
				
				if(prevDatetime!=''){												//上一轮有值
					var prevDate = analysis(prevDatetime)[0];	//上一轮日期
					var prevTime = analysis(prevDatetime)[1];	//上一轮时间
					// console.log(prevDate)
					if('{{$push}}'=='未设置'){
						// console.log($('.reviewvote'+(i+1)+' .elect-datetime-lang'),prevDate)
						$('.reviewvote'+(i+1)+' .elect-datetime-lang').datetimepicker({
							format:'Y-m-d H:i',
							lang:'ch',
							step:10,
							validateOnBlur:false,
							minDate:prevDate,
							maxDate:false,
							onSelectDate:function(ct){
								if(ct.getDate()==new Date(prevDate).getDate()){
									this.setOptions({
										minTime:prevTime,
										maxTime:false
									});
								}else{
									this.setOptions({
										minTime:false,
										maxTime:false
									});
								}
							}
						})
						$('.reviewgrade'+(i+1)+' .elect-datetime-lang').datetimepicker({
							format:'Y-m-d H:i',
							lang:'ch',
							step:10,
							validateOnBlur:false,
							minDate:prevDate,
							maxDate:false,
							onSelectDate:function(ct){
								if(ct.getDate()==new Date(prevDate).getDate()){
									this.setOptions({
										minTime:prevTime,
										maxTime:false
									});
								}else{
									this.setOptions({
										minTime:false,
										maxTime:false
									});
								}
							}
						})
					}else{
						$('.reviewvote'+(i+1)+' .elect-datetime-lang').datetimepicker({
							format:'Y-m-d H:i',
							lang:'ch',
							step:10,
							validateOnBlur:false,
							minDate:prevDate,
							maxDate:reviewstartDate,
							onSelectDate:function(ct){
								if(ct.getDate()==new Date(prevDate).getDate()){
									this.setOptions({
										minTime:prevTime,
										maxTime:false
									});
								}else if(ct.getDate()==new Date(reviewstartDate).getDate()){
									this.setOptions({
										minTime:false,
										maxTime:reviewstart
									});
								}else{
									this.setOptions({
										minTime:false,
										maxTime:false
									});
								}
							}
						})
						$('.reviewgrade'+(i+1)+' .elect-datetime-lang').datetimepicker({
							format:'Y-m-d H:i',
							lang:'ch',
							step:10,
							validateOnBlur:false,
							minDate:prevDate,
							maxDate:reviewstartDate,
							onSelectDate:function(ct){
								if(ct.getDate()==new Date(prevDate).getDate()){
									this.setOptions({
										minTime:prevTime,
										maxTime:false
									});
								}else if(ct.getDate()==new Date(reviewstartDate).getDate()){
									this.setOptions({
										minTime:false,
										maxTime:reviewstart
									});
								}else{
									this.setOptions({
										minTime:false,
										maxTime:false
									});
								}
							}
						})
					}
					
				}else{			
					// console.log(reviewstartDate)													//上一轮无值
					if('{{$push}}'=='未设置'){
						$('.reviewvote'+(i+1)+' .elect-datetime-lang').datetimepicker({
							format:'Y-m-d H:i',
							lang:'ch',
							step:10,
							validateOnBlur:false,
							minDate:endDate,
							maxDate:false,
							onSelectDate:function(ct){
								if(ct.getDate()==new Date(endDate).getDate()){
									this.setOptions({
										minTime:endTime,
										maxTime:false
									});
								}else{
									this.setOptions({
										minTime:false,
										maxTime:false
									});
								}
							}
						})
						$('.reviewgrade'+(i+1)+' .elect-datetime-lang').datetimepicker({
							format:'Y-m-d H:i',
							lang:'ch',
							step:10,
							validateOnBlur:false,
							minDate:endDate,
							maxDate:false,
							onSelectDate:function(ct){
								if(ct.getDate()==new Date(endDate).getDate()){
									this.setOptions({
										minTime:endTime,
										maxTime:false
									});
								}else{
									this.setOptions({
										minTime:false,
										maxTime:false
									});
								}
							}
						})
					}else{
						$('.reviewvote'+(i+1)+' .elect-datetime-lang').datetimepicker({
							format:'Y-m-d H:i',
							lang:'ch',
							step:10,
							validateOnBlur:false,
							minDate:endDate,
							maxDate:reviewstartDate,
							onSelectDate:function(ct){
								if(ct.getDate()==new Date(endDate).getDate()){
									this.setOptions({
										minTime:endTime,
										maxTime:false
									});
								}else if(ct.getDate()==new Date(reviewstartDate).getDate()){
									this.setOptions({
										minTime:false,
										maxTime:reviewstart
									});
								}else{
									this.setOptions({
										minTime:false,
										maxTime:false
									});
								}
							}
						})
						$('.reviewgrade'+(i+1)+' .elect-datetime-lang').datetimepicker({
							format:'Y-m-d H:i',
							lang:'ch',
							step:10,
							validateOnBlur:false,
							minDate:endDate,
							maxDate:reviewstartDate,
							onSelectDate:function(ct){
								if(ct.getDate()==new Date(endDate).getDate()){
									this.setOptions({
										minTime:endTime,
										maxTime:false
									});
								}else if(ct.getDate()==new Date(reviewstartDate).getDate()){
									this.setOptions({
										minTime:false,
										maxTime:reviewstart
									});
								}else{
									this.setOptions({
										minTime:false,
										maxTime:false
									});
								}
							}
						})
					}
				}
				
			// }
		}
		
	}
}
initDateTime();
$('.elect-datetime-lang').click(function(){
	initDateTime()
})
      //人气投票开始时间
      $('.peoplestrat-datetime-lang').datetimepicker({
		format:'Y-m-d H:i',
		lang:'ch',
		step:10,
		validateOnBlur:false,
		// minDate:prevDate,
		// maxDate:reviewstartDate,
		onSelectDate:function(ct){
			
		}
	  });
       //人气投票开始时间
      $('.peopleend-datetime-lang').datetimepicker({
			format:'Y-m-d H:i',
			lang:'ch',
			step:10,
			validateOnBlur:false,
			// minDate:prevDate,
			// maxDate:reviewstartDate,
			onSelectDate:function(ct){
				
			}
      	});
}

</script>
@endsection