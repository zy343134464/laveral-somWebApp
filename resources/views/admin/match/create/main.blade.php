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
			<h4>赛事海报</h4>
			<div class="form-group" id="aetherupload-wrapper">
				<div class="col-sm-4 col-sm-offset-2">
					<div class="upload-pic">
						<div class="limit">
							<p>横板尺寸：1920 X 1080 像素</p>
							<p>jpg png格式,不超过2m</p>
						</div>
						<div class="upload-wrapper">
							<a class="file">+
                                <input type="file" id="file" onchange="if(fileChange(this)!==false){aetherupload(this,'file').success(someCallback).upload()}" >
                            </a>
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
					<textarea class="form-control" rows="8" placeholder="400字内 赛事内容"  name="detail" style="resize:none;"  required></textarea>
				</div>
			</div>
		</div>
		@if(!$_GET['pid'])
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
<script>
	
    // 图片上传
  someCallback = function(){
    // 加载图片
    var path = $('#savedpath')[0].defaultValue;
    var image=$("<image src=\\uploadtemp\\"+path+"/>");
    $("#poster-pic").append(image);

    // 点击删除按钮
    var $resetBtn = $("<div class='form-group closeposition'><div class='col-sm-4 col-sm-offset-2'><div class='close'><i class='fa fa-close'></i></div></div></div>");
    $(".upload-wrapper").append($resetBtn);

    $resetBtn.on('click',function(){
      $('#poster-pic').children().remove();
      $('.file').find('#file').removeAttr("disabled");
      $resetBtn.remove();
      $('#output').html('');
      $('#progressbar').css('width','0');
      $('#file').val('');
    })
  }
    

  //限制文件大小
    var isIE = /msie/i.test(navigator.userAgent) && !window.opera; 
    function fileChange(target,id) { 
      var fileSize = 0; 
      var filetypes =[".jpg",".png",".jpeg",".jepg"]; 
      var filepath = target.value; 
    var filemaxsize = 1024*2;//2M 
    if(filepath){ 
      var isnext = false; 
      var fileend = filepath.substring(filepath.indexOf(".")); 
      if(filetypes && filetypes.length>0){ 
        for(var i =0; i<filetypes.length;i++){ 
          if(filetypes[i]==fileend){ 
            isnext = true; 
            break; 
          } 
        } 
      } 
      if(!isnext){ 
        alert("不接受此文件类型！"); 
        target.value =""; 
        return false; 
      } 
    }else{ 
      return false; 
    } 
    if (isIE && !target.files) { 
      var filePath = target.value; 
      var fileSystem = new ActiveXObject("Scripting.FileSystemObject"); 
      if(!fileSystem.FileExists(filePath)){ 
        alert("附件不存在，请重新输入！"); 
        return false; 
      } 
      var file = fileSystem.GetFile (filePath); 
      fileSize = file.Size; 
    } else { 
      fileSize = target.files[0].size; 
    } 

    var size = fileSize / 1024; 
    if(size>filemaxsize){ 
      alert("附件大小不能大于"+filemaxsize/1024+"M！"); 
      target.value =""; 
      return false; 
    } 
    if(size<=0){ 
      alert("附件大小不能为0M！"); 
      target.value =""; 
      return false; 
    } 
  } 
</script>

