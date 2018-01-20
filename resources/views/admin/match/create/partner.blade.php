@extends('admin.match.create.layout')
@section('title', '组委会信息')

@section('body2')
<div class="match-theme">
	<form class="form-horizontal" role="form" action="{{ url('admin/match/storepartner/'.$id) }}" method="post" >
	{{ csrf_field() }}
		<div class="match-partner">
			<h4>比赛合作方信息</h4>
			@if(count($partner))
			@foreach($partner as $v)
			<div class="two-wrapper">
			<div class="form-group match-partner-add">
				<div class="col-sm-5 col-sm-offset-2">
					<input type="text" class="form-control" id="firstname" placeholder="合作角色" name="role[]" value="{{ $v->role }}" >
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-5 col-sm-offset-2">
					<input type="text" class="form-control" id="firstname" placeholder="合作信息" name="name[]" value="{{ $v->name }}">
				</div>
				<span class="removeVar1">-</span>
			</div>
			</div>
			@endforeach
			@else
			<div class="two-wrapper">
			<div class="form-group match-partner-add">
				<div class="col-sm-5 col-sm-offset-2">
					<input type="text" class="form-control" id="firstname" placeholder="合作角色"   name="role[]" value="" >
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-5 col-sm-offset-2">
					<input type="text" class="form-control" id="firstname" placeholder="合作信息"  name="name[]" value="">
				</div>
			</div>
			</div>
			@endif
			<p><span id="addVar1" class="col-sm-offset-2">+</span></p>
		</div>
		<div class="match-partner">
			<h4>主办方联系信息</h4>
			@if(count($connection))
			@foreach($connection as $cv)
			<div class="two-wrapper">
			<div class="form-group match-partner-add">
				<div class="col-sm-5 col-sm-offset-2">
					<input type="text" class="form-control" id="firstname" placeholder="QQ/电话/微信" name="type[]" value="{{ $cv->type }}">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-5 col-sm-offset-2">
					<input type="text" class="form-control" id="firstname" placeholder="" name="value[]" value="{{ $cv->value }}">
				</div>
				<span class="removeVar2">-</span>
			</div>
			</div>
			@endforeach
			@else
			<div class="two-wrapper">
			<div class="form-group match-partner-add">
				<div class="col-sm-5 col-sm-offset-2">
					<input type="text" class="form-control" id="firstname" placeholder="QQ/电话/微信"  name="type[]" value="">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-5 col-sm-offset-2">
					<input type="text" class="form-control" id="firstname" placeholder=""  name="value[]" value="">
				</div>
			</div>
			</div>
			@endif
			<p><span id="addVar2" class="col-sm-offset-2">+</span></p>
		</div>
		<div class="nextPage">
			<input type="submit" class="btn btn-default" value="下一页">
		</div>
	</form>
</div>
@endsection