@extends('home.layout')   
@section('title', '上传组图')

@section('other_css')
  <meta name="_token" content="{{ csrf_token() }}"/>
    <script src="{{ url('js/vue.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plupload.full.min.js') }}"></script>
    <link rel="stylesheet" href="{{ url('css/home/uploadingImg.css') }}">
@endsection


@section('body')
<!-- 上传中心 -->
<div id="app">
  <div class="container">
      <div class="row">
          <div class="col-sm-12">
            <!-- 标题 -->
              <div class="head">
                <h4>XXXXXX摄影大赛上传作品(组图)</h4>
                
              </div>
              <input type="file" id="asd" @change="onprogress($event)">
              <div style="width:176px;height:176px;position: relative;">
                <i  id="father_i" style="width:100%;height:100%;position: absolute;z-index:100;display:block;line-height: 176px;text-align: center;color:#fff;"></i>
                <div id="ImgShade" style="width:100%;height:100%;background:#000;position: absolute;opacity: 0.5;bottom:0;"></div>
                <img src="" alt="" id="img" style="width:100%;height:100%;">
              </div>

            <!-- 组图数量 -->
              <div class="group_img_num">
                  <div class="group_img_title">
                    <span>组图数量</span>
                    <span>已上传@{{uploadingNum}}</span>
                    <span>剩余@{{Maxgroup-uploadingNum}}</span>
                  </div>
                  <div class="group_img_quantity">
                    <span v-for="(item,index) in groupArrs" ref="group">

                      <div @click="groupClick(item,index)">@{{index+1}}</div>
                      <i class="group_img_icon" @click="removegroupImg(index)"></i>

                    </span>
                    
                    <span class="add_group_img" @click="addgroupImg">+</span>
                  </div>
              </div>
              <div class="content" v-for="(groupArr,index) in groupArrs" v-show="index==showGroup">
                <!-- 选择图片 -->
                    <div class="selectImg">
                      <h4>选择图片</h4>

                      

                      <div class="imgMain"  v-for="(item,index2) in groupArr.ImgArr">
                        <h4>@{{index2+1}}</h4>
                        <div class="img">
                          <img :src="www+item" alt="">
                        </div>
                        <span @click="anew_uploading(index2)" :id="index+''+index2">重新上传</span>
                        <i class="group_img_icon"  @click="removeImg(item)"></i>
                      </div>

                      <!-- 进度条 -->
                      <div class="add_img progress_bar" v-show="flag">
                        <span>
                          <i>@{{progress}}</i>
                          <span ref="progress"></span>
                        </span>
                      </div>
                <!-- 点击上传 -->
                      <div class="add_img" :id="index">
                        <span>+</span>
                        <span>点击上传</span>
                      </div>
                      
                    </div>
                  <!-- 作品信息 -->
                    <div class="production_message">
                      <h4>作品信息</h4>
                      <div v-for="item in mustMessage">
                        <input type="text" :placeholder="item.text" :name='item.name'  maxlength="50"  ref="input" :num="index">
                        <span class="must" v-if="item.judge==1">*</span>
                        <i>50</i>
                      </div>
                    </div>
                  <!-- 更多描述 -->
                    <div class="more_describe">
                      <h4>更多描述</h4>
                      <div class="more_describe_top">
                        <input type="text" placeholder="创作日期">
                        <input type="text" placeholder="创作地点">
                      </div>
                      <div class="more_describe_bottom">
                        <input type="text" placeholder="长(px)">
                        <span>*</span>
                        <input type="text" placeholder="宽(px)">
                      </div>
                    </div>
                  
              </div>
              <!-- 提交按钮 -->
              <div class="bottom">
                <button class="submit" @click="submitProduction">提交作品</button>
              </div>
          </div>
      </div>
    </div>
</div> 

@endsection

@section('other_js')
<script>
  
var app = new Vue({
			el: '#app',
			data: {
        www:'',  
        progress:0,
        indexes:0,
        groupId:0,
        flag:false,
        mustMessage:[],                            //必填input信息
        uploadingNum:0,                            //上传数
        brr:[0],                                   //限制图片上传插件new的次数
        showGroup:0,                               //当期显示的组图
        Maxgroup:{{ $personal->group_max }},       //最多组图
        groupArrs:[ {ImgArr:[],} ]                 
      },
      mounted(){
        this.$refs.group[0].style.border = '1px solid #D4B178';
        this.www = window.location.protocol+'//'+window.location.host+'/';
        
        this.uploading(this.showGroup,true,this.Imgfunc);
        
        //获取点击图片的本地路径
        // setTimeout(() => {
        //   var input = document.getElementById(this.showGroup).nextElementSibling.getElementsByTagName('input')[0];
        //   console.log(input)
        // }, 100);
        
        
        var must = JSON.parse('{!! $personal->production_info !!}' );
      
        var select = '{!! $personal->diy_info !!}' ? JSON.parse('{!! $personal->diy_info !!}') : '' ;
        
          //列表数据
          for(let i=0;i<must[0].length;i++){
            switch (must[0][i]) {
              case 'author':
                var obj = {};
                obj['name'] = must[0][i];
                obj['text'] = '作者姓名';
                obj['judge'] = must[1][i];
                this.mustMessage.push(obj);
              break; 
              case 'detail':
                var obj = {};
                obj['name'] = must[0][i];
                obj['text'] = '文字描述';
                obj['judge'] = must[1][i];
                this.mustMessage.push(obj);
              break; 
              case 'title':
                var obj = {};
                obj['name'] = must[0][i];
                obj['text'] = '作品标题';
                obj['judge'] = must[1][i];
                this.mustMessage.push(obj);
              break; 
              case 'represent':
                var obj = {};
                obj['name'] = must[0][i];
                obj['text'] = '代表单位';
                obj['judge'] = must[1][i];
                this.mustMessage.push(obj);
              break; 
              case 'year':
                var obj = {};
                obj['name'] = must[0][i];
                obj['text'] = '年份';
                obj['judge'] = must[1][i];
                this.mustMessage.push(obj);
              break; 
              case 'country':
                var obj = {};
                obj['name'] = must[0][i];
                obj['text'] = '国籍';
                obj['judge'] = must[1][i];
                this.mustMessage.push(obj);
              break; 
              case 'lacation':
                var obj = {};
                obj['name'] = must[0][i];
                obj['text'] = '拍摄地点';
                obj['judge'] = must[1][i];
                this.mustMessage.push(obj);
              break; 
              case 'size':
                var obj = {};
                obj['name'] = must[0][i];
                obj['text'] = '作品尺寸';
                obj['judge'] = must[1][i];
                this.mustMessage.push(obj);
              break; 
            }
          }
          for(let w=0;w<select[0].length;w++){
            var obj2 = {};
            obj2['name'] = 'defined'+w;
            obj2['text'] = select[0][w];
            obj2['judge'] = select[1][w];
            this.mustMessage.push(obj2);
          }

      },
      updated(){
        this.uploadingNum = this.groupArrs.length;  //已上传数量
      },
      methods:{
        //图片上传
        uploading(id,multi,func){
          var _this = this;
          // console.log(id)
          var uploader = new plupload.Uploader({                      //创建实例的构造方法
              runtimes: 'html5,flash,silverlight,html4',             //上传插件初始化选用那种方式的优先级顺序
              browse_button: id+'',                      // 上传按钮
              url: _this.www+"match/upload",                       //远程上传地址
              flash_swf_url: _this.www+'plupload/Moxie.swf',       //flash文件地址
              silverlight_xap_url: _this.www+'plupload/Moxie.xap', //silverlight文件地址
              headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
              filters: {
              max_file_size: '10mb',                                  //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
              
              mime_types: [                                           //允许文件上传类型
                {
                  title: "files",
                  extensions: "jpg,png,gif,ico"
                }
              ]
            },
            multi_selection: multi,                                    //true:ctrl多文件上传, false 单文件上传
            init: {
              FilesAdded: function(up, files) {                       //文件上传前
                //   uploader.destroy();
                // var input = document.getElementById(_this.showGroup).nextElementSibling.getElementsByTagName('input');
                  
                //   input[0].onchange = function(){
                //       console.log(this[0].value)
                //   }.apply(input)
                  uploader.start();
            
              },
              UploadProgress: function(up, file) {                    //上传中，显示进度条
            
                var percent = file.percent;
                _this.progress = percent;
                _this.flag = true;
                
                _this.$refs.progress[0].style.width = percent+'%';
              },
              FileUploaded: function(up, file, info) {                //文件上传成功的时候触发
                var data = eval("(" + info.response + ")");
                var imgPic;
                _this.flag = false;
                if(data.error=='0'){
                  imgPic = data.pic
                  func(imgPic);                                       //图片上传显示的数组方法
                }else{
                  alert('上传失败！')
                }
              },
              Error: function(up, err) {                              //上传出错的时候触发
                alert(err.message);
              }
            }
          });
          uploader.init();
        },
        //图片上传显示的数组方法
        Imgfunc(imgPic){
          this.groupArrs[this.showGroup].ImgArr.push(imgPic);
          this.groupId = this.showGroup;
          var id = this.groupId+''+(this.groupArrs[this.showGroup].ImgArr.length-1);
          setTimeout(() => {
            this.uploading(id,false,this.anewImgfunc);
          }, 100);
        },
        //重新上传图片
        anew_uploading(index){
          this.indexes = index;
        },
        //重新上传图片显示的数组方法
        anewImgfunc(imgPic){
          this.groupArrs[this.showGroup].ImgArr.splice(this.indexes,1,imgPic);
        },
        //删除选中的图片
        removeImg(e){
          
          for(let j=0;j<this.groupArrs.length;j++){
            for(let i=0;i<this.groupArrs[j].ImgArr.length;i++){
              if(this.groupArrs[j].ImgArr[i]==e){
                this.groupArrs[j].ImgArr.splice([i],1);
              }
            }
          }
        },
        // 添加组图
        addgroupImg(){
          var obj = {ImgArr:[]};
          if(this.Maxgroup>this.groupArrs.length){
            this.groupArrs.push(obj);
          }

        },
        //点击改变当前组图
        groupClick(item,index){
          this.showGroup=index
          if(this.brr.indexOf(index)==-1){
            this.brr.push(index)
            this.uploading(this.showGroup,true,this.Imgfunc);
          }
          for(let i=0;i<this.$refs.group.length;i++){
            this.$refs.group[i].style.border = 'none';
          }
          this.$refs.group[index].style.border = '1px solid #D4B178';

        },
        //删除组图
        removegroupImg(e){
          this.groupArrs.splice([e],1);
          this.brr.splice([e],1);
        },
        // ---------------------------------------開始-------------------------------------------------------
        onprogress(e){
          var _this = this;
          this.preview(e.target);
          // console.log(e.target.files[0])
          
          // 图片数据开始
          var formData = new FormData();
          var type = 'image';
          formData.append("file",e.target.files[0]);
          formData.append("type",type);
          // 图片数据结束


          //图片数据上传
          $.ajax({
            url: _this.www+"match/upload", 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
            method:'post',
            data: formData,
            processData:false,
            contentType:false,  
            xhr: function() {
      　　　　var xhr = $.ajaxSettings.xhr();
      　　　　if (xhr.upload) {
      　　　　　　xhr.upload.onprogress = function(progress) {
                      if (progress.lengthComputable) {
                          // console.log(progress.loaded / progress.total * 100);
                          console.log(Math.round(progress.loaded / progress.total * 100));
                          document.getElementById('ImgShade').style.height = 100-Math.round(progress.loaded / progress.total * 100)+'%';
                          document.getElementById('father_i').innerHTML = Math.round(progress.loaded / progress.total * 100)+'%';
                      }
                  };
                  xhr.upload.onloadstart = function() {
                      console.log('started...');
                  };
                  
        　　　 }
                return xhr;
        　 },
          success:function(data){
            var Data = eval("(" + data + ")");
            console.log(Data)
          }
          })
         
        },
        // 图片预览
        preview(e){
          // console.log(e)
            var reader = new FileReader();
            reader.onload = (function (file) {
                return function (e) {
                    // console.log(this.result); //这个就是base64的数据了
                    document.getElementById('img').setAttribute("src",this.result)
                };
            })(e.files[0]);
            reader.readAsDataURL(e.files[0]);
        },
        // ----------------------------------------結束------------------------------------------------------
        //提交
        submitProduction(){
          var _this = this;
            for(let i=0;i<this.$refs.input.length;i++){
                if(this.$refs.input[i].nextSibling.nextSibling.className&&(!this.$refs.input[i].value)){
                  alert('有未填项！');
                  return false;
                }
            }
            for(let i=0;i<this.groupArrs.length;i++){
                if(this.groupArrs[i].ImgArr.length<1){
                  alert('图片未上传！');
                  return false;
                }
            }
            for(let i=0;i<this.$refs.input.length;i++){
              
              for(let j=0;j<this.groupArrs.length;j++){
                if(this.$refs.input[i].getAttribute('num')==j){
                  this.groupArrs[j][this.$refs.input[i].getAttribute('name')] = this.$refs.input[i].value;
                }
              }
            }
          $.ajax({
            url: _this.www+"match/douploadimgs/"+{{ $personal->match_id }}, 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
            method:'post',
            data: {'data':JSON.stringify(_this.groupArrs)},
            success:function(data){
              
              console.log(data)
            }
          })
        }
      }
  })

</script>

  
@endsection