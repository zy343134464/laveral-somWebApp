@extends('home.layout')   
@section('title', '上传中心')

@section('other_css')
    <link href="{{url('lib/owl.carousel/dist/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/home/uploadcenter/uploadimg.css') }}"/>
@endsection


@section('body')
<!-- 上传中心 -->
<main id="uploadimg">
    <div class="container">
    <form action="{{ url('match/douploadimg/'.@$id) }}" method="post">
    {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @if(count($personal))
                <div class="requireimg">
                    <h3>图片递交要求</h3>
                    <p>图片大小（MB）:{{$personal->size_min}}-{{$personal->size_max}}</p>
                    <p>图片最小边长（像素）:{{$personal->length}}（*作品最短的一边长度必须达到此尺寸或以上）</p>
                    <p>{{$personal->introdution_title}}</p>
                    <p>{{$personal->introdution_detail}}</p>
                </div>
                @endif
                <div class="warm">
                    <p>注：大会对输出发展有最终决定和解释权，请密切留意作品入选状态（页面左方菜单栏中上传记录可见）</p>
                </div>
                <div class="alreadyimg">
                    <h3>已上传图片</h3>
                    <!-- 图片点击轮播 -->
                    <div class="imgwrapper" style="position: relative;margin:0 auto;">
                        <div id="poster-pic">
                            
                        </div>
                    </div>
                </div>
                <div class="guestimg" id="aetherupload-wrapper">
                    <div class="upload-pic">
                        <div class="upload-wrapper">
                            <a class="file">+
                                <input type="file" id="file" onchange="if(fileChange(this)!==false){aetherupload(this,'file').success(someCallback).upload()}">
                            </a>
                            <input type="hidden" name="pic" id="savedpath">
                            <p class="help-block">将图片拖拽至此释放</p>
                            <span style="font-size:12px;color:#aaa;" id="output"></span>
                            <div class="progress " style="height: 6px;margin-bottom: 2px;margin-top: 10px;width: 100px;margin-left:50%;position:relative;left:-50px;">
                                <div id="progressbar" style="background:blue;height:6px;width:0;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nextPage">
                    <input type="submit" class="btn btn-default" value="下一步">
                </div>
            </div>
        </div>
    </form>
    </div>
</main> 

@endsection

@section('other_js')
    <script src="{{ url('lib/owl.carousel/dist/owl.carousel.min.js')}}"></script>
    <!-- 图片上传 -->
    <script src="{{ URL::asset('js/spark-md5.min.js') }}"></script><!--需要引入spark-md5.min.js-->
    <script src="{{ URL::asset('js/aetherupload.js') }}"></script><!--需要引入aetherupload.js-->
    <script src="{{ url('js/home/uploadcenter/uploadimg.js')}}"></script>
    <script>
    // 图片上传
      someCallback = function(){
        // 加载图片
        var path = $('#savedpath')[0].defaultValue;
        var image=$("<image src=\\uploadtemp\\"+path+"/>");
        $("#poster-pic").append(image);

        // 点击删除按钮
        var $resetBtn = $("<div class='form-group closeposition'><div class='col-sm-4 col-sm-offset-2'><div class='close'><i class='fa fa-close'></i></div></div></div>");
        $(".imgwrapper").append($resetBtn);

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
        var filemaxsize = 1024*20;//20M 
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
@endsection