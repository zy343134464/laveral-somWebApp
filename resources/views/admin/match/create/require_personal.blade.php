@extends('admin.match.create.layout')
@section('title', '投稿要求')

@section('body2')
<div class="match-theme">
	<form class="form-horizontal" role="form" action="{{ url('admin/match/storerequire_personal/'.$id) }}" method="post" >
		<ul class="nav nav-tabs nav-otherjob" role="tablist">
			<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">个人</a></li>
			<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">团体</a></li>
		</ul>

		<div class="match-review">
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">独照/组图</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname" placeholder="张/组" name="grop_min">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname" placeholder="张/组" name="grop_max">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">每组张数</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname3" placeholder="张"  name="num_min">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="" placeholder="张"  name="num_max">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">图片大小</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname3" placeholder="MB">
				</div>
				<label class="col-sm-1 control-label" style="margin-left:-54px;">至</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname4" placeholder="MB">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname3" class="col-sm-2 control-label">最小边长</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname3" placeholder="像素">
				</div>
			</div>
			<div class="form-group">
                <label for="firstname3" class="col-sm-2 control-label">收费类型</label>
				<div class="col-sm-6">
					<label class="radio-inline">
						<input type="radio" name="name1" id="" value="option1" checked>每张/组收费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="name1" id="" value="option2">报名费
					</label>
					<label class="radio-inline" style="padding-left:60px;">
						<input type="radio" name="name1" id="" value="option3">免费
					</label>
				</div>
            </div>
            <div class="form-group">
				<label for="firstname5" class="col-sm-2 control-label">单价</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="firstname5" placeholder="">
				</div>
				<div class="col-sm-2">
					<select class="form-control">
						<option>人民币</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname6" class="col-sm-2 control-label">作品标题</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname6" placeholder="20字内">
				</div>
			</div>
			<div class="form-group">
				<label for="firstname7" class="col-sm-2 control-label">文字描述</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="firstname7" placeholder="小标题">
					<textarea class="form-control" rows="6" placeholder="400字内"></textarea>
				</div>
			</div>
		</div>
		<div class="nextPage">
			<button type="button" class="btn btn-default">下一页</button>
		</div>
	</form>
</div>
@endsection