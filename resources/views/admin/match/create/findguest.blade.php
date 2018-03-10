@extends('admin.layout')
@section('title', '评委详情页')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/match/matchcreate.css') }}">
@endsection


@section('body')
<div class="match-guestdata">
    <form action="{{ url('admin/match/findguest/'.$id) }}" method="get">
        <!--搜索框-->
        <div class="search-form">
            <i class="fa fa-search"></i>
            <input type="text" placeholder="关键字搜索" name="kw">
        </div>
    </form>
    <form action="{{ url('admin/match/storeguest/'.$id) }}" method="post" id="form">
    {{ csrf_field() }}
        <div class="addguest text-right">
            <a href="#" class="btn btn-default new" data-toggle="modal" data-target="#matchnew" id="new">新建嘉宾</a>
            <input type="submit" value="添加到赛事" class="btn btn-default add" style="display:none" id="add">
        </div>
            @if(count($user))
        <div class="content">
            <ul class="judgedata">
                @foreach($user as $v)
                <li>
                    <a>
                        <div class="judgedata-img">
                            <img src="{{ url($v->pic) }}" alt="">
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
                    新建嘉宾
                </h4>
            </div>
            <div class="modal-body">
               <div class="match-new">
                   <form class="form-horizontal" role="form" action="{{ url('admin/match/newguest/'.$id) }}" method="post">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">姓名</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="username" placeholder="" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grade" class="col-sm-2 control-label">头街</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="grade" placeholder="" name="tag">
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="introduction" class="col-sm-2 control-label">简介</label>
                            <div class="col-sm-5">
                                <textarea class="form-control" rows="5" placeholder="50字内" id="introduction" name="detail"></textarea>
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
@endsection

@section('other_js')
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