@extends('admin.match.create.layout')
@section('title', '新建比赛')
	
@section('body2')
<style>
		
	</style>
<div class="match-theme" id="new_game"> 
	<form class="form-horizontal" role="form" action="{{ url('admin/match/store/'.$type) }}" method="post"  enctype="multipart/form-data" name="haibao">
	 {{ csrf_field() }}
	 	<div class="match-poster">
			<div class="form-group" style="color:red;margin-left:40px;">
			<!-- {{ $errors->first() }} -->{{ session('msg') }}
			</div>
			<img src="" class="pv" >
			<h4>赛事海报</h4>
			<div class="form-group" id="aetherupload-wrapper">
				<div class="col-sm-4 col-sm-offset-2">
					<div class="form-group Modify-div" onclick="popShow('popCapture')"><div class="col-sm-4 col-sm-offset-2"><div class="close"><i class="fa fa-close"></i></div></div></div>
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
				<div class="col-sm-4 as user_defined_type" style="position:relative;">
					<input type="text" class="form-control bs" id="firstname" placeholder="" name="type" style="margin-right:10px;">
					<i class="type_icon glyphicon glyphicon-menu-down"></i>
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
					<textarea class="form-control" rows="8" placeholder="400字内 赛事内容"  name="detail"  style="width: 716px;resize:vertical;box-sizing:border-box;"  cols="5" rows="10"></textarea>
				</div>
			</div>
		</div>
		@if(!isset($_GET['pid']))
		<div class="match-time">
			<h4>赛事时间设置</h4>
			<div class="form-group">
				<label class="col-sm-2 control-label">征稿开始时间<span class="sure">*</span></label>
				<div class="col-sm-4">
					<input size="14" type="text" placeholder="请选择日期和时间" class="collectstart-datetime-lang am-form-field form-control" name="collect_start"  required>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">征稿结束时间<span class="sure">*</span></label>
				<div class="col-sm-4">
					<input size="14" type="text" placeholder="请选择日期和时间" class="collectend-datetime-lang am-form-field form-control" name="collect_end"  required>
				</div>
			</div>
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">赛果公布日期</label>
				<div class="col-sm-4">
					<input size="14" type="text" placeholder="请选择日期和时间" class="reviewstart-datetime-lang am-form-field form-control" name="public_time">
				</div>
			</div>
		</div>
		@endif
		<div class="nextPage">
			<input type="submit" value="下一页" class="btn btn-default">
		</div>

@endsection
@section('other_js')
    <script src="{{ url('js/admin/match/matchcreate.js')}}"></script>
    <script>     
		$('.type_icon').click(function(){
			$('#list').show();
		})   
		$('#firstname').click(function(){
			$('#list').show();
		})
		var body = document.body||document.getElementsByTagName("body")[0];
		body.onclick = function(e){
			var target = event.target;
			if(target.className!='form-control bs'&&target.className!='col-sm-4 as'&&target.className!='type_icon glyphicon glyphicon-menu-down'){
				$('#list').hide();
			}
		}
		document.getElementById('list').onclick = function(e){
			var target = event.target;
			// console.log(target)
			if(target.innerHTML=='其他 – 自定义'){
				$('#firstname').attr('name','');
				if($('.user_defined_type').find('input').length==1){
					var input=document.createElement("input");
					input.name = "type";
					input.className = "form-control new";
					$('.user_defined_type')[0].appendChild(input);
				}
			}else{
				$('#firstname').attr('name','type');
				$('.new').remove();
			}
			if(target.innerHTML.indexOf('<')<0){
				$('#firstname').val(target.innerHTML);
				$('#list').hide();
			}else{
				$('#firstname').val(target.innerHTML.substring(0,target.innerHTML.indexOf('<')));
				$('#list').hide();
			}
		}
		
        $('.navbar-nav li a').each(function(){
            if($($(this))[0].href==String(window.location)){
                $(this).parent().parent().find('li').removeClass('active')
                $(this).parent().addClass('active');
            }
        });
        function popShow(id) {
            $('.pop-mask').show();
            $('#'+id).show();
            $('#popCapture .capture-title').html('上传赛事海报');
            $('#popCapture .preview-title').html('赛事海报预览');
        }
        // $('form').submit(function(){
        // 	var params = serializeForm('haibao');
        // 	console.log(params);
        // 	return false;
        // })
    </script>

    <script src="{{url('js/cropper.js')}}"></script>
    <script src="{{url('js/jquery-cropper.js')}}"></script>
    <script src="{{url('js/home/capture/capture-16-9.js')}}"></script>
@endsection

