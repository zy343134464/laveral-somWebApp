@extends('admin.match.create.layout')
@section('title', '奖项设置')

@section('body2')
<div class="match-theme">
	<form class="form-horizontal" role="form" action="{{ url('admin/match/storeaward/'.$id) }}" method="post" >
	{{ csrf_field() }}
		<div class="match-award">
			<h4>奖项设置</h4>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">奖项名称</label>
				<label for="" class="col-sm-2 control-label" style="margin-left:-48px;">名额</label>
				<label for="" class="col-sm-2 control-label" style="margin-left:10px;">奖品说明</label>
			</div>
			@if(count($award))
			@foreach($award as $v)
			<div class="form-group">
				<div class="col-sm-2 col-sm-offset-1">
					<input type="text" class="form-control" id="" placeholder="奖项等级" name="name[]" value="{{ $v->name}}" required autocomplete="off">
				</div>
				<div class="col-sm-2" style="margin-left:-20px;">
					<input type="number" class="form-control" id="" placeholder="位" name="num[]" min="1" value="{{ $v->num}}" required autocomplete="off">
				</div>
				<div class="col-sm-4" style="margin-left:-20px;">
					<input type="text" class="form-control" id="" placeholder="" name="detail[]" value="{{ $v->detail}}" required autocomplete="off">
				</div>
				<span class="removeVar3">-</span>
			</div>
			@endforeach
			@else

			<div class="form-group">
				<div class="col-sm-2 col-sm-offset-1">
					<input type="text" class="form-control" id="" placeholder="奖项等级" name="name[]" value="" required autocomplete="off">
				</div>
				<div class="col-sm-2" style="margin-left:-20px;">
					<input type="number" class="form-control" id="" placeholder="位" name="num[]" value="" required autocomplete="off">
				</div>
				<div class="col-sm-4" style="margin-left:-20px;">
					<input type="text" class="form-control" id="" placeholder="" name="detail[]" value="" required autocomplete="off">
				</div>
				<span class="removeVar3">-</span>
			</div>
			@endif
			<p><span id="addVar3" class="col-sm-offset-1">+</span></p>
		</div>
		<div class="nextPage">
			<input type="text" value="1" name="jump" style="display:none;" class="jump_input">
			<input type="submit" class="btn btn-default" value="上一页" style="margin-right:20px;">
			<input type="submit" value="下一页" class="btn btn-default">
		</div>
	</form>
</div>
@endsection

@section('more_js')
<script>
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