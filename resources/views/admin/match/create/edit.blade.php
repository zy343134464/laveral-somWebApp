@extends('admin.match.create.layout')
@section('title', '编辑比赛')

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
				<div class="col-sm-4 col-sm-offset-2 Modify-div-cont" >
          <input type="hidden" class="pic" name="pic" value="{{$match->pic}}">
					<div class="upload-pic  pv" onclick="popShow('popCapture')">
						<img src="{{ url($match->pic) }}" style="width:100%" id="posters_picture" title="点击修改海报">
				</div>
				<div class="form-group  Modify-div" onclick="popShow('popCapture')"><div class="col-sm-4 col-sm-offset-2"><div class="close"><i class="fa fa-close"></i></div></div></div>
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

					<ul id="list">
						<li>风光</li>
						<li>肖像
							<ul>
								<li>儿童</li>
								<li>家庭</li>
								<li>私房</li>
							</ul>
						</li>
						<li>婚纱
							<ul>
								<li>婚礼</li>
								<li>旅拍</li>
							</ul>
						</li>
						<li>艺术创意</li>
						<li>水下</li>
						<li>商业广告
							<ul>
								<li>食品</li>
								<li>产品</li>
								<li>珠宝</li>
								<li>其他</li>
							</ul>
						</li>
						<li>其他 – 自定义</li>
					</ul>
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
				<div class="col-sm-8">
					<textarea class="form-control" rows="6" placeholder="400字内 赛事内容"  name="detail"  style="width: 716px;resize:vertical;box-sizing:border-box;"  cols="5" rows="10" required>{{$match->detail}}</textarea>
				</div>
			</div>
		</div>
    @if(match($id,'cat') != 2)
		<div class="match-time">
			<h4>赛事时间设置</h4>
			<div class="form-group">
				<label class="col-sm-2 control-label">征稿开始时间<span class="sure">*</span></label>
				<div class="col-sm-4">
					<input size="14" type="text" placeholder="请选择日期和时间"  class="collectstart-datetime-lang form-control" name="collect_start"  required>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">征稿结束时间<span class="sure">*</span></label>
				<div class="col-sm-4">
					<input size="14" type="text" placeholder="请选择日期和时间"  class="collectend-datetime-lang form-control" name="collect_end"  required>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">赛果公布日期</label>
				<div class="col-sm-4">
					<input size="14" type="text" placeholder="请选择日期和时间" class="reviewstart-datetime-lang form-control" name="public_time">
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

<script>
  window.onload = function(){
  	var collect_start = {{ $match->collect_start}};
  	var collect_end = {{ $match->collect_end}};
  	var public_time = {{ $match->public_time}};
  	function timestampToTime(timestamp) {
        var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = (date.getDate() < 10 ? '0'+(date.getDate()) : date.getDate()) + ' ';
        h = (date.getHours() < 10 ? '0'+(date.getHours()) : date.getHours()) + ':';
        m = (date.getMinutes() < 10 ? '0'+(date.getMinutes()) : date.getMinutes());
        return Y+M+D+h+m;
    }
    
  	if(collect_start){
  		$('.collectstart-datetime-lang').val(timestampToTime(collect_start))
  	}

  	if(collect_end){
  		$('.collectend-datetime-lang').val(timestampToTime(collect_end))
  	}

  	if(public_time){
  		$('.reviewstart-datetime-lang').val(timestampToTime(public_time))
  	}


  	$('.closeposition').on('click',function(){
  		 $('#poster-pic').children().remove();
	      $('.file').find('#file').removeAttr("disabled");
	      $('.closeposition').remove();
	      $('#output').html('');
	      $('#progressbar').css('width','0');
	      $('#file').val('');
  	});
  }
    

</script>

@section('other_js')
    <script src="{{ url('js/admin/match/matchcreate.js')}}"></script>
    <script>     
    	$('#firstname').click(function(){
			$('#list').show();
		})   
        $('.navbar-nav li a').each(function(){
            if($($(this))[0].href==String(window.location)){
                $(this).parent().parent().find('li').removeClass('active')
                $(this).parent().addClass('active');
            }
        });
        function popShow(id) {
            $('.pop-mask').show();
            $('#'+id).show();
        }
        document.getElementById('list').onclick = function(e){
			var target = event.target;
			if(target.innerHTML.indexOf('<')<0){
				$('#firstname').val(target.innerHTML);
				$('#list').hide();
			}
		}
         
    </script>

    <script src="{{url('js/cropper.js')}}"></script>
    <script src="{{url('js/jquery-cropper.js')}}"></script>
    <script src="{{url('js/home/capture/capture-16-9.js')}}"></script>
@endsection
