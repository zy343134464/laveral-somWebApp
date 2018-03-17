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
                    <p>单次上传最多20个图像</p>
                    <p>{{$personal->introdution_title}}</p>
                    <p>{{$personal->introdution_detail}}</p>
                </div>
                @endif
                <div class="warm">
                    <p>注：大会对输出发展有最终决定和解释权，请密切留意作品入选状态（页面左方菜单栏中上传记录可见）</p>
                </div>
                <div class="alreadyimg">
                    <h3>上传作品<span>&nbsp;&nbsp;已上传<span id="uploadNum">5</span>&nbsp;&nbsp;剩余<span id="residueNum">5</span></span></h3>
                    <!-- 图片显示区域 -->
                    <div class="imgwrapper">
                      <!-- 上传按钮 -->
                      <label for="file" class="upload-btn" id="aetherupload-wrapper">
                        <p>点击添加图片</p>
                        <!-- <span>支持多张上传，不可超过剩余张数</span> -->
                        <input type="file" id="file" multiple="multiple" onchange="if(fileChange(this)!==false){aetherupload(this,'file').success(someCallback).upload()}">
                        <input type="hidden" name="pic" id="savedpath">
                      </label>
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
      var pathArr = [];
      var pathId = 0;
      var imgNum = 0;

      var imgMaxNum = 2; //最大上传数量

      $(function() {
        imgNumShow()
      })

      function imgNumShow() {
        $('#uploadNum').html(imgNum);
        $('#residueNum').html(parseInt(imgMaxNum) - imgNum);
      }

    // 图片上传
      someCallback = function(){
        imgNum ++;
        $('#file').removeAttr("disabled").val('');
        if(imgNum >= parseInt(imgMaxNum)) {
          $('#aetherupload-wrapper').hide();
        }
        // 加载图片
        var path = $('#savedpath')[0].defaultValue;
        var $imgObj = $('<div class="upload-item"><image src=\\uploadtemp\\'+path+'/></div>');

        var pathItem = {id: pathId, path: path};
        pathArr.push(pathItem);

        // 点击删除按钮
        var $resetBtn = $('<a href="javascript:void(0)" class="upload-del" data-id="'+ pathItem.id +'" title="删除图片"><i class="fa fa-close"></i></a>');
        $imgObj.append($resetBtn);
        $(".imgwrapper").append($imgObj);

        $resetBtn.on('click',function(){
          var _this = $(this);
          var pid = _this.attr('data-id');
          _this.parents('.upload-item').remove();
          $('#aetherupload-wrapper').show();
          for(var i=0; i<pathArr.length; i++) {
            if(pathArr[i].id === parseInt(pid)) {
              pathArr.splice(i, 1);
            }
          }
          console.log(pathArr);
        });

        pathId ++;
      }
      
      var minsize = '{{$personal->size_min}}';
      var maxsize = '{{$personal->size_max}}';
      //限制文件大小
      var isIE = /msie/i.test(navigator.userAgent) && !window.opera; 
      function fileChange(target,id) { 
        console.log(target.files);
        var fileSize = 0; 
        var filetypes =[".jpg",".png",".jpeg",".jepg"]; 
        var filepath = target.value; 
        var fileminsize = 1024 * parseInt(minsize);
        var filemaxsize = 1024 * parseInt(maxsize);
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
          alert("附件大小不能大于"+ minsize +"M！"); 
          target.value =""; 
          return false; 
        } 
        if(size<=fileminsize){ 
          alert("附件大小不能小于"+ minsize +"M！"); 
          target.value =""; 
          return false; 
        } 
      } 
    </script>
@endsection