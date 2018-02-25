@extends('home.user.layout')   


@section('more_css')

@endsection

@section('body2')
<div class="basic-information">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">基本信息</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
					class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			<form class="form-horizontal" role="form" style="position: relative;" action="{{ url('user/editInfo/'.$info->id) }}" method="post">
			 {{ csrf_field() }}
			 
				<div class="form-group">
					<label for="firstname" class="col-sm-1 control-label">用户名</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="firstname" name="name" placeholder="" value="{{ $info->name }}">
					</div>
					<label for="nationality" class="col-sm-1 control-label">国籍</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="nationality" placeholder=""  name="country" value="{{ $info->country }}">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">
						<label class="radio-inline col-sm-3" style="color: #9a9895;font-weight: bold;margin-left:5px;">性别</label>
						<label class="radio-inline">
							<input type="radio" name="sex" value="0" @if($info->sex==0) checked @endif>男
						</label>
						<label class="radio-inline">
							<input type="radio" name="sex" value="1" @if($info->sex==1) checked @endif> 女
						</label>
					</div>
					<label for="city" class="col-sm-1 control-label">城市</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="city" name="city" placeholder="" value="{{ $info->city }}">
					</div>
				</div>
				<div class="form-group">
					<label for="birthday" class="col-sm-1 control-label">生日</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="birthday"  name="birthday"  placeholder="" value="{{ $info->birthday }}">
					</div>
					<label for="nationality" class="col-sm-1 control-label">职业</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="nationality" name="job" 
						placeholder="" value="{{ $info->job }}">
					</div>
				</div>
				<div class="form-group">
					<label for="firstname" class="col-sm-1 control-label">描述</label>
					<div class="col-sm-7">
						<textarea class="form-control" rows="5" name="introdution" >{{ $info->introdution }}</textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-warning">保存</button>
					</div>
				</div>
				 <div class="guestimg" id="aetherupload-wrapper">
                    <div class="upload-pic">
                        <div class="upload-wrapper">
                            <a class="file">+
                                <input type="file" id="file" onchange="if(fileChange(this)!==false){aetherupload(this,'file').success(someCallback).upload()}">
                            </a>
                            <input type="hidden" name="pic" id="savedpath">
                            <p class="help-block">添加个人图片</p>
                            <span style="font-size:12px;color:#aaa;" id="output"></span>
                            <div class="progress " style="height: 6px;margin-bottom: 2px;margin-top: 10px;width: 56px;margin-left:70px;">
                                <div id="progressbar" style="background:blue;height:6px;width:0;"></div>
                            </div>
                            <div id="poster-pic"></div>
                        </div>
                    </div>
                </div>
			</form>
		</div>
	</div>
</div>
<div class="email">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">邮箱</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
					class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="replaceemail" class="col-sm-2 control-label" style="margin-left: -86px;">更换邮箱</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="replaceemail" placeholder="" value="22449499@qq.com">
					</div>
					<label for="securitycode" class="col-sm-1 control-label">验证码</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="securitycode"
						placeholder="" value="">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-warning">确定</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="phone">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">绑定手机</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
					class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="phone-number" class="col-sm-1 control-label">手机号</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="phone-number" placeholder="请输入要绑定的手机号" value="">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-warning">确定</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="password">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">密码</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
					class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			<form class="form-horizontal" role="form" action="{{ url('user/editPassword/'.$info->id) }}"  method="post">
			{{ csrf_field() }}
				<div class="form-group">
					<label for="currentpassword" class="col-sm-2 control-label" style="margin-left: -85px">当前密码</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="currentpassword" name="currentpassword" placeholder="" value="">
					</div>
				</div>
				<div class="form-group">
					<label for="newpassword" class="col-sm-1 control-label">新密码</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="newpassword" name="newpassword"  placeholder="" value="">
					</div>
				</div>
				<div class="form-group">
					<label for="surenewpassword" class="col-sm-2 control-label" style="margin-left: -85px">确认新密码</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="surenewpassword"  name="surenewpassword" placeholder="" value="">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-warning">确定</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="thirdparty">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">第三方绑定</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
					class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="box-body">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="weixin" class="col-sm-1 control-label">微信</label>
					<label for="weixin-icon" class="col-sm-1 control-label"><i class="fa fa-weixin"></label></i>
					<div class="col-sm-1">
						<button type="submit" class="btn btn-warning" style="left: 20px;">绑定</button>
					</div>
				</div>
				<div class="form-group">
					<label for="qq" class="col-sm-1 control-label">QQ</label>
					<label for="qq-icon" class="col-sm-1 control-label"><i class="fa fa-qq"></label></i>
					<div class="col-sm-1">
						<button type="submit" class="btn btn-warning" style="left: 20px;">绑定</button>
					</div>
				</div>
				<div class="form-group">
					<label for="weibo" class="col-sm-1 control-label">微博</label>
					<label for="weibo-icon" class="col-sm-1 control-label"><i class="fa fa-weibo"></label></i>
					<div class="col-sm-1">
						<button type="submit" class="btn btn-warning" style="left: 20px;">绑定</button>
					</div>
				</div>
			</form>
		</div>
	</div>
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
      var filetypes =[".jpg",".png"]; 
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
@section('other_js')

@endsection