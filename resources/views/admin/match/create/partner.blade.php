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
			<div class="form-group match-partner-add">
				<div class="col-sm-2 col-sm-offset-2">
					<input type="text" class="form-control" id="firstname" placeholder="主办方" name="role[]" value="{{ $v->role }}" autocomplete="off">
				</div>
				<div class="col-sm-4" style="margin-left:-24px;">
					<input type="text" class="form-control" id="firstname" placeholder="名称" name="name[]" value="{{ $v->name }}" autocomplete="off">
				</div>
				<span class="removeVar1">-</span>
			</div>
			@endforeach
			@else
			<div class="form-group match-partner-add">
				<div class="col-sm-2 col-sm-offset-2">
					<input type="text" class="form-control" id="firstname" placeholder="主办方"   name="role[]" value="" autocomplete="off">
				</div>
				<div class="col-sm-4" style="margin-left:-24px;">
					<input type="text" class="form-control" id="firstname" placeholder="名称"  name="name[]" value="" autocomplete="off">
				</div>
			</div>
			@endif
			<p><span id="addVar1" class="col-sm-offset-2">+</span></p>
		</div>
		<div class="match-partner">
			<h4>主办方联系信息</h4>
			@if(count($connection))
			@foreach($connection as $cv)
			<div class="form-group match-partner-add">
				<div class="col-sm-2 col-sm-offset-2">
					<input type="text" class="form-control" id="firstname" placeholder="QQ/电话/微信/邮箱" name="type[]" value="{{ $cv->type }}" autocomplete="off">
				</div>
				<div class="col-sm-4" style="margin-left:-24px;">
					<input type="text" class="form-control" id="firstname" placeholder="" name="value[]" value="{{ $cv->value }}" autocomplete="off">
				</div>
				<span class="removeVar2">-</span>
			</div>
			@endforeach
			@else
			<div class="form-group match-partner-add">
				<div class="col-sm-2 col-sm-offset-2">
					<input type="text" class="form-control" id="firstname" placeholder="QQ/电话/微信/邮箱"  name="type[]" value="" autocomplete="off">
				</div>
				<div class="col-sm-4" style="margin-left:-24px;">
					<input type="text" class="form-control" id="firstname" placeholder=""  name="value[]" value="" autocomplete="off">
				</div>
			</div>
			@endif
			<p><span id="addVar2" class="col-sm-offset-2">+</span></p>
		</div>
		<div class="nextPage">
			<input type="text" value="1" name="jump" style="display:none;" class="jump_input">
			<input type="submit" class="btn btn-default" value="上一页" style="margin-right:20px;">
			<input type="submit" class="btn btn-default" value="下一页">
		</div>
	</form>
</div>

@endsection

@section('more_js')
<script>
	// console.log(123)
	$('.btn-default').click(function(){
		if($(this).val()=='上一页'){
			$('.jump_input').val(0);
		}else{
			$('.jump_input').val(1);
		}
		console.log($('.jump_input').val())
		// return false;
	})
</script>
@endsection