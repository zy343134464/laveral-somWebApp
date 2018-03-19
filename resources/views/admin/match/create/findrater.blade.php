@extends('admin.layout')
@section('title', '评委详情页')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/match/matchcreate.css') }}">
    <link rel="stylesheet" href="{{url('css/home/user/cropper.css')}}">
    <link rel="stylesheet" href="{{url('css/home/user/capture.css')}}">
@endsection


@section('body')
<div class="match-guestdata">
    <form action="{{ url('admin/match/findrater/'.$id) }}" method="get">
        <!--搜索框-->
        <div class="search-form">
            <i class="fa fa-search"></i>
            <input type="text" placeholder="关键字搜索" name="kw" id="input">
        </div>
    </form>
    <form action="{{ url('admin/match/storerater/'.$id) }}" method="post" id="form">
    {{ csrf_field() }}
        <div class="addguest text-right">
            <a href="#" class="btn btn-default new" data-toggle="modal" data-target="#matchnew" id="new">新建评委</a>
            <input type="submit" value="添加到赛事" class="btn btn-default add" style="display:none;" id="add">
        </div>
            @if(count($user))
        <div class="content">
            <ul class="judgedata">
                @foreach($user as $v)
                <li>
                    <a>
                        <div class="judgedata-img">
                            <img src="{{ url($v->pic) }}">
                            <div class="check"><i class="fa fa-check"></i></div>
                        </div>
                        <div class="judgedata-content text-left">
                            <input type="hidden" value="{{$v->id}}" class="input">
                            <h4>{{$v->name}}</h4>
                            
                            <p>{{$v->introdution}}</p>
                        </div>
                        <div class="model middle"></div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
            <div class="wrapper text-center" style="background:#f5f5f5;">{{ $user->appends(['kw' => $kw])->links() }}</div> 
            @endif
    </form>
    
</div>
               
             
<!-- 新建赛事模态框 -->
<div class="modal fade" id="matchnew" tabindex="-1" role="dialog" aria-labelledby="matchnewlabel" aria-hidden="true">
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

<div class="pop-mask" style="display: none;"></div>
    <div id="popCapture" class="pop-capture pop-info" style="display: none;">
        <a href="javascript:void:void(0)" class="pop-close pop-hide"></a>
        <h1 class="capture-title">上传头像</h1>
        <!-- Content -->
        <div class="capture-container">
            <div class="capture-info">
                <!-- <h3>Demo:</h3> -->
                <div class="img-container">
                    <img src="" id="image" alt="">
                    <label id="upload" for="inputImage">点击添加图片<br>只支持JPG、PNG、GIF，大小不超过2M</label>
                </div>

                <div class="manage-btn-box">
                    <label class="manage-btn btn-upload" for="inputImage">重新上传</label>
                    <a href="javascript:void(0)" class="manage-btn btn-plus">＋</a>
                    <a href="javascript:void(0)" class="manage-btn btn-minus">－</a>
                </div>
                <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
            </div>
            <div class="capture-show">
                <!-- <h3>Preview:</h3> -->
                <div class="docs-preview clearfix">
                    <div class="img-preview preview-lg"></div>
                </div>
                <p class="preview-title">头像预览</p>
                <a href="javascript:void(0)" class="capture-btn btn-confirm">确定</a>
                <a href="javascript:void(0)" class="capture-btn btn-cancel pop-hide">取消</a>
            </div>
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
    <script src="{{ url('js/admin/match/matchcreate.js')}}"></script>
@endsection

<script>
  window.onload = function(){
    if ($('#form').find('.content').length > 0) {
      $('#add').css('display','inline-block')
      $('#new').css('display','none')
    };
  }
 
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