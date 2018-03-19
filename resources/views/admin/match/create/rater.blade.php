@extends('admin.match.create.layout')
@section('title', '评委/嘉宾')

@section('body2')
<style>
  .match-guest .content ul>li{
    width: 266px;
  }
  
</style>
<div class="match-guest">
	<!-- <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="{{ url('admin/match/rater/'.$id) }}" >评委</a></li>
		<li role="presentation"><a href="{{ url('admin/match/guest/'.$id) }}" >嘉宾</a></li>
	</ul> -->
	<div class="content">
		<ul class="judgelist">
			<li class="addjudge">
				<a  data-toggle="modal" data-target="#matchnew2" id="new">
					<div class="add-button">+</div>
					<p>添加评委/嘉宾</p>
				</a>
			</li>
            @if(count($rater))
            @foreach($rater as $v)
			<li>
				<a href="#">
					<div class="judge-img">
						<img src="{{ url($v->pic)}}"  index="{{$v->pic}}" class="rater-img">
                        <a href="{{ url('admin/match/delrater/'.$v->id)}}"><div class="close"><i class="fa fa-close"></i></div></a>
					</div>
					 <div class="judge-content text-left">
                        <div style="display:none;" id="hiddenId">{{ $v->id}}</div>
                        <h4 class="name" style="overflow: hidden;text-overflow:ellipsis;white-space: nowrap;">{{ $v->name}}</h4>
                        <p class="tag" style="overflow: hidden;text-overflow:ellipsis;white-space: nowrap;">{{ $v->tag}}</p>
                        <p class="detail impose" style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 3;overflow: hidden;word-wrap:break-word">{{ $v->detail}}</p>
                    </div>
                    <div class="judge-edit">
                        <a href="#" class="btn editraterBtn" data-toggle="modal" data-target="#matchnew"><i class="fa fa-edit"></i></a>
                    </div>
				</a>
			</li>
            @endforeach
            @endif
		</ul>
	</div>
	<!-- 编辑评委模态框 -->
    <div class="modal fade" id="matchnew" tabindex="-1" role="dialog" aria-labelledby="matchnewlabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="matchnewlabel">
                        编辑评委信息
                    </h4>
                </div>
                <div class="modal-body">
                   <div class="match-new">
                        <form class="form-horizontal" role="form" action="{{ url('admin/match/editnewrater/') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="hidden">
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">姓名</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="ratername" name="name" onchange="this.value=this.value.substring(0, 20)" onkeydown="this.value=this.value.substring(0, 20)" onkeyup="this.value=this.value.substring(0, 20)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="grade" class="col-sm-2 control-label">头衔</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="ratertag" name="tag" onchange="this.value=this.value.substring(0, 25)" onkeydown="this.value=this.value.substring(0, 25)" onkeyup="this.value=this.value.substring(0, 25)">
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label for="introduction" class="col-sm-2 control-label">简介</label>
                                <div class="col-sm-5">
                                    <textarea class="form-control" rows="5" placeholder="500字内" id="raterdetail" name="detail" onchange="this.value=this.value.substring(0, 500)" onkeydown="this.value=this.value.substring(0, 500)" onkeyup="this.value=this.value.substring(0, 500)"></textarea>
                                </div>
                            </div>
                           <div class="guestimg" id="aetherupload-wrapper" onclick="popShow('popCapture')">
                                <div class="upload-pic">
                                    <div class="upload-wrapper">
                                        <a class="file">+</a>
                                        <p class="help-block">添加个人图片</p>
                                        <span style="font-size:12px;color:#aaa;" id="output"></span>
                                        <!-- <div class="progress " style="height: 6px;margin-bottom: 2px;margin-top: 10px;width: 56px;margin-left:70px;">
                                            <div id="progressbar" style="background:blue;height:6px;width:0;"></div>
                                        </div>
                                        <div id="poster-pic"><img src=""></div>
                                        <div class='form-group closeposition'><div class='col-sm-4 col-sm-offset-2'><div class='close'><i class='fa fa-close'></i></div></div></div> -->
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="pic" id="savedpath" class="savedraterpath">
                            <div class="modal-footer">
                                <div class="col-sm-5" style="margin-left:-5px;">
                                    <button class="btn btn-default" id="editraterBtn">确认提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
    <!-- 新建赛事模态框 -->
<div class="modal fade" id="matchnew2" tabindex="-1" role="dialog" aria-labelledby="matchnewlabel2" aria-hidden="true">
    <div class="modal-dialog">
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
                    <form class="form-horizontal" role="form" action="{{ url('admin/match/newrater/'.$id) }}" method="post">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">姓名</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="username" placeholder="不能超过20个字" required name="name" onchange="this.value=this.value.substring(0, 20)" onkeydown="this.value=this.value.substring(0, 20)" onkeyup="this.value=this.value.substring(0, 20)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grade" class="col-sm-2 control-label">头衔</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="grade" placeholder="不能超过25个字" required  name="tag" onchange="this.value=this.value.substring(0, 25)" onkeydown="this.value=this.value.substring(0, 25)" onkeyup="this.value=this.value.substring(0, 25)">
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="introduction" class="col-sm-2 control-label">简介</label>
                            <div class="col-sm-5">
                                <textarea class="form-

                                control" rows="5" placeholder="500字内" id="introduction" name="detail" onchange="this.value=this.value.substring(0, 500)" onkeydown="this.value=this.value.substring(0, 500)" onkeyup="this.value=this.value.substring(0, 500)" required></textarea>
                            </div>
                        </div>
                        <div class="guestimg" id="aetherupload-wrapper" onclick="popShow('popCapture')">
                            <div class="upload-pic">
                                <div class="upload-wrapper">
                                    <a class="file">+</a>
                                    <p class="help-block">添加个人图片</p><!-- 
                                    <span style="font-size:12px;color:#aaa;" id="output"></span>
                                    <div class="progress " style="height: 6px;margin-bottom: 2px;margin-top: 10px;width: 56px;margin-left:70px;">
                                        <div id="progressbar" style="background:blue;height:6px;width:0;"></div>
                                    </div>
                                    <div id="poster-pic"></div> -->
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="pic" id="savedpath">
                        <div class="modal-footer">
                            <div class="col-sm-5" style="margin-left:-5px;">
                                <input type="submit" class="btn btn-default" value="确认提交"></input>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
	<div class="nextPage">
		<a href="{{ url('admin/match/award/'.$id) }}" class="btn btn-default">下一页</a>
	</div>
	
</div>
@endsection
@section('other_js')
    <script src="{{ url('js/admin/match/matchcreate.js')}}"></script>
    <script>        
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
    </script>

    <script src="{{url('js/cropper.js')}}"></script>
    <script src="{{url('js/jquery-cropper.js')}}"></script>
    <script src="{{url('js/home/capture/capture-1-1.js')}}"></script>
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

   window.onload = function(){
    $('.closeposition').on('click',function(){
       $('#poster-pic').children().remove();
        $('.file').find('#file').removeAttr("disabled");
        $('.closeposition').remove();
        $('#output').html('');
        $('#progressbar').css('width','0');
        $('#file').val('');
    });
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