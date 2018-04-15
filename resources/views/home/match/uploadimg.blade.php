@extends('home.layout')   
@section('title', '上传图片')

@section('other_css')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <script src="{{ url('js/vue.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/spin.min.js') }}"></script>
    <link rel="stylesheet" href="{{ url('css/swiper.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/home/uploadcenter/uploadImgs.css') }}"/>
@endsection


@section('body')
<!-- 上传中心 -->
<div id="app">
    <div class="container">
      <div class="row">
          <div class="col-sm-12">
            <!-- 顶部进展 -->
            <!-- <div class="body_top">
              <ul ref="mainCourse">
                <li :class=" mainCourseNum!=0?'mainCourse':'' ">
                  <i class="top_num">1</i>
                  <span>阅读声明</span>
                </li>
                <li :class=" mainCourseNum>=1?'mainCourse':'' ">
                  <i class="top_num">2</i>
                  <i class="top_border"></i>
                  <span>报名表单</span>
                </li>
                <li :class=" mainCourseNum>=2?'mainCourse':'' ">
                  <i class="top_num">3</i>
                  <i class="top_border"></i>
                  <span>上传作品</span>
                </li>
                <li :class=" mainCourseNum>=3?'mainCourse':'' ">
                  <i class="top_num">4</i>
                  <i class="top_border"></i>
                  <span>支付</span>
                </li>
              </ul>
            </div> -->
            <!-- 主体 -->
            <div class="main">
              <!-- 类别 -->
              <ul class="uploading_class">
                <li v-if="{{ $personal->group_limit }}==1||{{ $personal->group_limit }}==0" :class=" isClass?'select_on':'' " @click="one_img">上传单张</li>
                <li v-if="{{ $personal->group_limit }}==2||{{ $personal->group_limit }}==0" :class=" isClass?'':'select_on' " @click="group_img">上传组图</li>
              </ul>
              <!-- 提交要求 -->
              <div class="require_title" @click="submitRequire" v-show="show1==true">
                请详细阅读提交要求
                <i><img src="{{ url('img/downward.png') }}" alt=""></i>
              </div>
              <!-- 要求内容 -->
              <div class="require_content" v-show="!show1">

              <ul>
                        <li>
                          <span class="require_list">收费类型:</span><span class="require_content">
                          @if($personal->pay == 1)
                          每张/组收费
                          @elseif($personal->pay == 2)
                          报名费
                          @else
                          免费  
                          @endif

                          </span>
                        </li>
                        @if($personal->pay != 0)
                        <li>
                          <span class="require_list">单价:</span><span class="require_content">{{ $personal->price }} 人民币</span>
                        </li>
                        <li>
                          <span class="require_list">收费说明:</span><span class="require_content">{{$personal->pay_detail}}</span>
                        </li>
                        @endif
                       
                          @if($personal->pay == 1)
                          <!-- 仅限单张 -->
                        <li>
                          <span class="require_list">单张:</span><span class="require_content"> {{$personal->group_min}} 至 {{$personal->group_max}} 张</span>
                        </li>
                          @elseif($personal->pay == 2)
                          <!-- 仅限组图 -->
                        <li>
                          <span class="require_list">组图:</span><span class="require_content">{{$personal->group_min}} 至 {{$personal->group_max}} 组</span>
                        </li>
                        <li>
                          <span class="require_list">每组张数:</span><span class="require_content">{{$personal->num_min}} 至 {{$personal->num_max}} 张</span>
                        </li>
                          @else
                          <!-- 不限 -->
                        <li>
                          <span class="require_list">单张/组图:</span><span class="require_content">{{$personal->group_min}} 至 {{$personal->group_max}}</span>
                        </li>
                        <li>
                          <span class="require_list">每组张数:</span><span class="require_content">{{$personal->num_min}} 至 {{$personal->num_max}} 张</span>
                        </li>
                          @endif
                        <li>
                          <span class="require_list">图片大小:</span><span class="require_content">{{ $personal->size_min }} 至 {{ $personal->size_max }} MB</span>
                        </li>
                        <li>
                          <span class="require_list">最小边长:</span><span class="require_content">{{ $personal->length }} px</span>
                        </li>
                         <li>
                          <span class="require_list gundan">补充说明:</span>
                          <div class="require_content bucong">
                            <p class="title">{{ $personal->introdution_title }}</p>
                            {!! str_replace(array("\r\n", "\r", "\n"), "<br/>", $personal->introdution_detail) !!}
                        </div>
                        </li>
                      </ul>

              </div>
            <!-- 图片内容 -->
              <!-- 单张 -->
              <div class="uploadingImg" v-show="isClass">
                <ul>
                  <!-- 添加单张图片 -->
                  <li class="add_Img">
                    <input type="file" multiple="multiple" accept="image/jpeg,image/png" @change="uploadingImg($event)" style="width:100%;height:100%;position: absolute;z-index:1000;display:block;opacity: 0;">
                    <i class="add_icon">+</i>
                    <span>上传单张作品</span>
                    <span class="remain">剩余投稿数： @{{remain}}</span>
                  </li>
                  <!-- 图片 -->
                  <li class="Img" v-for="(item,index) in ImgArrs[0]">
                    <div class="Img_main">
                      <img :src="www+item.pic" alt="" ref="ImgSize">
                      <i class="Img_delete" data-toggle="modal" data-target="#myModal1" @click="deleteImg(index)">+</i>
                      <!-- 加载器开始 -->
                      <div class="foo" style="width:100px; height:100px;" v-show="item.pic==''"></div>
                      <!-- 加载器结束 -->
                      <div class="shade" ref="oneShade" v-show="item.status==0">
                        <span data-toggle="modal" data-target="#myModal1" @click="addMessage(index)">添加信息</span>
                        
                      </div>
                    </div>
                    <div class="Img_title">
                      <span>@{{item.title}}</span>
                      <i class="redact" data-toggle="modal" data-target="#myModal1" @click="addMessage(index)" v-show="item.status==1||item.status==2"><img src="{{ url('img/redact.png') }}" alt=""></i>
                    </div>
                  </li>
                </ul>
              </div> 
              <!-- 组图 -->
              <div class="uploadingImg" v-show="!isClass">
                <ul>
                  <!-- 添加组图图片 -->
                  <li class="add_Img">
                    <input type="file" multiple="multiple" accept="image/jpeg,image/png" @change="uploadingGroup($event)" style="width:100%;height:100%;position: absolute;z-index:1000;display:block;opacity: 0;">
                    <i class="add_icon">+</i>
                    <span>上传组图作品</span>
                    <span class="remain">剩余投稿数： @{{remain}}</span>
                  </li>
                  <!-- 图片 -->
                  <li class="Img" v-for="(item,index) in ImgArrs[1]">
                    <div class="Img_main">
                      <i class="Img_delete" data-toggle="modal" data-target="#myModal1" @click="deleteGroupImg(index)">+</i>
                      <!-- 加载器开始 -->
                      <div class="foo" style="width:100px; height:100px;" v-show="item.pic==''"></div>
                      <!-- 加载器结束 -->
                      <div class="group" v-for="(pic,index2) in item.pic" v-if="index2<4">
                        <img :src="www+pic" ref="ImgSize">
                      </div>
                      <div class="shade" ref="groupShade" v-show="item.status==0">
                        <span data-toggle="modal" data-target="#myModal1" @click="addGroupMessage(index)">添加信息</span>
                        
                      </div>
                    </div>
                    <div class="Img_title">
                      <span>@{{item.title}}</span>
                      <i class="redact" data-toggle="modal" data-target="#myModal1" @click="addGroupMessage(index)" v-show="item.status==1||item.status==2"><img src="{{ url('img/redact.png') }}" alt=""></i>
                    </div>
                  </li>
                </ul>
              </div> 
            </div>
            <!-- 按钮 -->
            <div class="button">
                <ul>
                  <!-- <li><span class="Return"><a href="{{ url('user/match') }}">我的赛事</a></span></li> -->
                  <li>
                    <span class="on">
                      <button class="contribute_before" @click="contributeFunc($event)" v-show="isClass" v-if="uio==1&&cat!=2">投稿</button>
                      <button class="contribute_before" data-toggle="modal" data-target="#myModal1" @click="contributeFunc" v-show="isClass" v-if="uio==0&&cat!=2">投稿</button>
                      <button class="contribute_before" @click="submitProduction($event)"  data-status="1" v-show="!isClass" v-if="cat!=2">投稿</button>
                      <button class="contribute_before" @click="contributeFunc($event)" v-if="cat==2">继续投稿</button>
                    </span>
                  </li>
                  <li><span @click="submitProduction($event)" data-status="0">保存</span></li>
                </ul>
              </div>
          </div>
          <!-- 模态框（Modal） -->
          <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" @click="myModal">
            <div class="modal-dialog" v-show="dialogNum==1||dialogNum==2||dialogNum==3">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                  </button>
                  <!-- 投稿确认模态框 -->
                  <div class="contribute_affirm" v-show="dialogNum==1">
                    <h5>投稿确认</h5>
                    <div class="dialog_content">
                      <span>你还没添加组图作品，是否往组图继续添加</span>
                    </div>
                    <div class="dialog_button">
                      <button type="button" class="continue_add" data-dismiss="modal" @click="go_on_contribute">继续添加组图</button>
                      <button type="button" class="contribute" @click="submitProduction($event)" data-status="1">直接投稿</button>
                    </div>
                  </div>
                  <!-- 删除确认模态框 -->
                  <div class="delete_affirm"  v-show="dialogNum==2||dialogNum==3">
                    <h5>作品管理</h5>
                    <div class="dialog_content">
                      <span>如果你确认删除此作品，里面的内容将全部清空</span>
                    </div>
                    <div class="dialog_button">
                      <button type="button" class="continue_add" data-dismiss="modal" @click="deleteImgAffirm">确认</button>
                      <button type="button" class="contribute" data-dismiss="modal">取消</button>
                    </div>
                  </div>
                  <!--  -->
                </div>
            </div>
          </div>
          <!-- 模态框（Modal） -->
          <!-- 作品详细信息模态框 -->
          <div class="modal-dialog2" v-show="dialogNum==4||dialogNum==5">
            <div class="dialog2_header">
              <span v-if="dialogNum==4">单张作品信息</span>
              <span v-if="dialogNum==5">组图作品信息</span>
            </div>
            <div class="dialog2_main">
              <div class="dialog2_left">
                <!--  -->
                <div class="swiper-container gallery-top">
                    <div class="swiper-wrapper groupIMG" @click="magnifyImg($event)">
                        <div class="swiper-slide" v-for="item in ImgArrs[0]" v-if="dialogNum==4">
                            <img :src="www+item.pic" alt="">
                        </div>
                    </div>
                    <div class="swiper-button-next swiper-button-white" @click="nextNum"></div>
                    <div class="swiper-button-prev swiper-button-white" @click="prevNum"></div>
                </div>
                <div class="swiper-container gallery-thumbs">
                    <div class="swiper-wrapper groupIMG">

                        <div class="swiper-slide" v-for="item in ImgArrs[0]" v-if="dialogNum==4">
                            <img :src="www+item.pic" alt="">
                        </div>
                    </div>
                </div>
                <!--  -->
              </div>
              <div class="dialog2_right">

                <ul class="dialog2_right_ul">
                  <li v-for="(item,index) in mustMessage" v-if="item.text!=null||item.text!=undefined">
                    <input type="text" :name="item.name" :mustFill="item.judge"   ref="input" :num="index" value="">
                    <span><i v-if="item.judge==1">*</i><a href="javascript:" :title="item.text">@{{item.text}}</a></span>
                  </li>
                </ul>
                   
              </div>
              <div class="dialog_button dialog2_button">
                <button type="button" class="continue_add" @click="previous" v-if="dialogNum==4">《 上一单张</button>
                <button type="button" class="continue_add" @click="previous" v-if="dialogNum==5">《 上一组图</button>
                <button type="button" class="continue_add" @click="next" v-if="dialogNum==4">下一单张 》</button>
                <button type="button" class="continue_add" @click="next" v-if="dialogNum==5">下一组图 》</button>
                <button type="button" class="contribute dialog2_return" data-dismiss="modal" @click="returnPreserve">返回</button>
              </div>
            </div>
          </div>
        <!-- 模态框（Modal）结束 -->
      </div>
      <div class="Img_magnify" @click="hideMagnify"><img src="" alt=""></div>
    </div>
    
</div> 

@endsection

@section('other_js')
<script src="{{ url('js/swiper.min.js') }}"></script>
<script>
var groupObjs = {'pic':[]};      //组图图片数据
  var app = new Vue({
      el: '#app',
      data: {
        show1:false,
        showMessage:[],         //显示的详细信息
        deleteIndex:0,          //删除的索引
        showIndexes:0,         //显示的作品索引
        mustMessage:[],         //input信息
        dialogNum:0,            //模态对话框
        number:0,
        slideState:0,           //轮播图滑动状态
        isClass:true,           //单张或组图的显示
        mainCourseNum:2,        //参赛进度
        www:window.location.protocol+'//'+window.location.host+'/',
        ImgArrs:{},
        groupShow:0,
        remain:20,                //单张剩余投稿数
        uio:0,
        cat: '{{$match->cat}}'
      },
      mounted(){
        this.init()     //初始化
        this.mustMessageFunc();
        this.uio = JSON.parse('{!! $personal->group_limit !!}' );
        console.log(this.cat)
        setInterval(function(){
          if(document.getElementsByTagName('body')[0].style.paddingRight != 0){
            document.getElementsByTagName('body')[0].style.paddingRight = '0px';
          }
        },200)
      },
      updated(){
        
      },
      methods:{
        // 提交要求的显示隐藏
        submitRequire(){
          this.show1 = !this.show1;
        },
        go_on_contribute(){
          this.isClass = false;
        },
        // 单张view
        one_img(){
          this.isClass = true;
          // console.log(this.isClass)
        },
        //组图view
        group_img(){
          this.isClass = false;
        },
        // 上传单张
        uploadingImg(e){
          this.show1 = true;
          this.preview(e.target,false);
          this.remain = 20-(this.ImgArrs[0].length+this.ImgArrs[1].length);
          this.loader();
        },
        // 图片上传ajax
        Ajax(formData,number,group){
          var _this = this;
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

                        }
                    };
                  
          　　　 }
                  return xhr;
          　 },
            success:function(data){

              var Data = eval("(" + data + ")");
              if(group){
                groupObjs.pic.push(Data.pic);
                groupObjs['status'] = 0;
                for(let i=0;i<_this.mustMessage.length;i++){
                  groupObjs[_this.mustMessage[i].name] = '';
                }
                
                _this.ImgArrs[1].splice([number],1,groupObjs);
                
              }else{
                var obj = {};
                obj['pic'] = Data.pic;
                obj['status'] = 0;
                for(let i=0;i<_this.mustMessage.length;i++){
                  obj[_this.mustMessage[i].name] = '';
                }
                _this.ImgArrs[0].splice([number],1,obj)
              }
            }
          })
        },
        // 上传组图
        uploadingGroup(e){
          this.show1 = true;
          this.preview(e.target,true);
          this.remain = 20-(this.ImgArrs[0].length+this.ImgArrs[1].length);
          this.loader();
        },
        // 图片预览
        preview(e,group){

            var _this = this;

            if(!group){   //单张
              for(let i=0;i<e.files.length;i++){
                
                var obj = {};
                obj['pic'] = ''; 
                _this.ImgArrs[0].push(obj);

                _this.number = _this.ImgArrs[0].length-1;     //当前预览与上传的图片索引
                // 图片数据开始
                var formData = new FormData();
                var type = 'image';
                formData.append("file",e.files[i]);
                formData.append("type",type);
                _this.Ajax(formData,_this.number,group);
              }
            }else{
              var obj = {};
              obj['pic'] = []; 
              _this.ImgArrs[1].push(obj);
              
              _this.number = _this.ImgArrs[1].length-1;     //当前预览与上传的图片索引

              for(let i=0;i<e.files.length;i++){
                // 图片数据开始
                var formData = new FormData();
                var type = 'image';
                formData.append("file",e.files[i]);
                formData.append("type",type);
                _this.Ajax(formData,_this.number,group);
              }
            }
            groupObjs = {'pic':[]};
            
        },
        // 删除单张
        deleteImg(index){
          this.dialogNum = 2;         //对话框样式与单张 的值
          this.deleteIndex = index;   //删除的单张图片索引
        },
        // 删除组图
        deleteGroupImg(index){
          this.dialogNum = 3;
          this.deleteIndex = index;   //删除的组图图片索引
        },
        // 投稿
        contributeFunc(e){
          if(this.uio==1){
            this.submitProduction(e);
          }
          this.dialogNum = 1;
          
        },
        myModal(){
         
        },
        // 删除确认
        deleteImgAffirm(){
          if(this.dialogNum == 3){
            this.ImgArrs[1].splice([this.deleteIndex],1);
          }else if(this.dialogNum == 2){
            this.ImgArrs[0].splice([this.deleteIndex],1);
          }
          this.remain += 1;
        },
        //单张添加信息 
        addMessage(index2){
          this.dialogNum = 4;
          this.showIndexes = index2;
          
          document.getElementsByClassName('groupIMG')[0].innerHTML = '';
          document.getElementsByClassName('groupIMG')[1].innerHTML = '';

          for(let i=0;i<this.ImgArrs[0].length;i++){
            document.getElementsByClassName('groupIMG')[0].innerHTML += '<div class="swiper-slide"><img src="'+this.www+this.ImgArrs[0][i].pic+'" alt=""></div>';
            document.getElementsByClassName('groupIMG')[1].innerHTML += '<div class="swiper-slide"><img src="'+this.www+this.ImgArrs[0][i].pic+'" alt=""></div>';
          }
          this.Swiper(index2);
          var Length = 0;
          for(let i in this.ImgArrs[0][index2]){
            Length++;
          }
          if(Length!=1){
            for(let i=0;i<this.$refs.input.length;i++){
              for(let j in this.ImgArrs[0][index2]){
                if(this.$refs.input[i].name==j){
                  this.$refs.input[i].value = this.ImgArrs[0][index2][j];
                }
              }
            }
          }else{
            for(let i=0;i<this.$refs.input.length;i++){
              this.$refs.input[i].value = '';
            }
          }
          
        },
        //组图添加信息
        addGroupMessage(index){
          this.dialogNum = 5;
          this.showIndexes = index;
          this.groupShow = index;
          
          document.getElementsByClassName('groupIMG')[0].innerHTML = '';
          document.getElementsByClassName('groupIMG')[1].innerHTML = '';

          for(let i=0;i<this.ImgArrs[1][index].pic.length;i++){
            document.getElementsByClassName('groupIMG')[0].innerHTML += '<div class="swiper-slide"><img src="'+this.www+this.ImgArrs[1][index].pic[i]+'" alt=""></div>';
            document.getElementsByClassName('groupIMG')[1].innerHTML += '<div class="swiper-slide"><img src="'+this.www+this.ImgArrs[1][index].pic[i]+'" alt=""></div>';
          }

          this.Swiper(index);
          var Length = 0;
          for(let i in this.ImgArrs[1][index]){
            Length++;
          }
          if(Length!=1){
            for(let i=0;i<this.$refs.input.length;i++){
              for(let j in this.ImgArrs[1][index]){
                if(this.$refs.input[i].name==j){
                  this.$refs.input[i].value = this.ImgArrs[1][index][j];
                }
              }
            }
          }else{
            for(let i=0;i<this.$refs.input.length;i++){
              this.$refs.input[i].value = '';
            }
          }
        },
        // 上一张
        prevNum(){},
        // 下一张
        nextNum(){},
        // 上一个作品
        previous(){
          // console.log(this.showIndexes)
          if(this.isClass){
            $('.swiper-button-prev').trigger("click");
            for(let i=0;i<this.$refs.input.length;i++){
              this.ImgArrs[0][this.showIndexes][this.$refs.input[i].name] = this.$refs.input[i].value;      //将input中的值赋值给单张数组
            }
      
            for(let i=0;i<this.$refs.input.length;i++){
              if(this.$refs.input[i].getAttribute('mustfill')=='1'){         //判断必填信息有无填写
                if(this.$refs.input[i].value==''){
                  this.ImgArrs[0][this.showIndexes]['status'] = 0;
                  // console.log(this.ImgArrs[0][this.showIndexes])
                  return false;
                }else{
                  this.ImgArrs[0][this.showIndexes]['status'] = 1;
                  // console.log(this.ImgArrs[0][this.showIndexes])
                }
              }
            }
            
          }else{
            for(let i=0;i<this.$refs.input.length;i++){                                                 ////将input中的值赋值给组图数组
                this.ImgArrs[1][this.groupShow][this.$refs.input[i].name] = this.$refs.input[i].value;
              } 
              var falg = 0;
              for(let i=0;i<this.$refs.input.length;i++){
                if(this.$refs.input[i].getAttribute('mustfill')=='1'&&falg == 0){         //判断必填信息有无填写
                  if(this.$refs.input[i].value==''){
                    this.ImgArrs[1][this.groupShow]['status'] = 0;
                    // console.log(this.ImgArrs[0][this.groupShow])
                    falg++;
                  }else{
                    this.ImgArrs[1][this.groupShow]['status'] = 1;
                    // console.log(this.ImgArrs[0][this.groupShow])
                  }
                }
              }

            if(this.groupShow!=0){      //当前组图不是第一组时
              this.groupShow--;
              document.getElementsByClassName('groupIMG')[0].innerHTML = '';
              document.getElementsByClassName('groupIMG')[1].innerHTML = '';
              
              for(let i=0;i<this.$refs.input.length;i++){       //将下一组图的信息显示在input上
                if(this.ImgArrs[1][this.groupShow][this.$refs.input[i].name]){
                  this.$refs.input[i].value = this.ImgArrs[1][this.groupShow][this.$refs.input[i].name];
                }else{
                  this.$refs.input[i].value = '';
                }
              }
              
              for(let i=0;i<this.ImgArrs[1][this.showIndexes].pic.length;i++){      //显示下一组图的图片
                document.getElementsByClassName('groupIMG')[0].innerHTML += '<div class="swiper-slide"><img src="'+this.www+this.ImgArrs[1][this.groupShow].pic[i]+'" alt=""></div>';
                document.getElementsByClassName('groupIMG')[1].innerHTML += '<div class="swiper-slide"><img src="'+this.www+this.ImgArrs[1][this.groupShow].pic[i]+'" alt=""></div>';
              }
              
            }
          }
          // console.log(this.ImgArrs)
        },
        // 下一个作品
        next(){
          
          if(this.isClass){
            $('.swiper-button-next').trigger("click");
            for(let i=0;i<this.$refs.input.length;i++){
              this.ImgArrs[0][this.showIndexes][this.$refs.input[i].name] = this.$refs.input[i].value;
            }

            for(let i=0;i<this.$refs.input.length;i++){
              if(this.$refs.input[i].getAttribute('mustfill')=='1'){         //判断必填信息有无填写
                if(this.$refs.input[i].value==''){
                  this.ImgArrs[0][this.showIndexes]['status'] = 0;
                  // console.log(this.ImgArrs[0][this.showIndexes])
                  return false;
                }else{
                  this.ImgArrs[0][this.showIndexes]['status'] = 1;
                  // console.log(this.ImgArrs[0][this.showIndexes])
                }
              }
            }
            // this.OneData();
          }else{
              for(let i=0;i<this.$refs.input.length;i++){
                this.ImgArrs[1][this.groupShow][this.$refs.input[i].name] = this.$refs.input[i].value;
              }
              var falg = 0;
              for(let i=0;i<this.$refs.input.length;i++){
                if(this.$refs.input[i].getAttribute('mustfill')=='1'&&falg == 0){         //判断必填信息有无填写
                  if(this.$refs.input[i].value==''){
                    this.ImgArrs[1][this.groupShow]['status'] = 0;
                    // console.log(this.ImgArrs[0][this.groupShow])
                    falg++;
                  }else{
                    this.ImgArrs[1][this.groupShow]['status'] = 1;
                    // console.log(this.ImgArrs[0][this.groupShow])
                  }
                }
              }
            if(this.groupShow!=this.ImgArrs[1].length-1){     //当前显示的组图不是最后一组
              this.groupShow++;
              document.getElementsByClassName('groupIMG')[0].innerHTML = '';
              document.getElementsByClassName('groupIMG')[1].innerHTML = '';

              for(let i=0;i<this.$refs.input.length;i++){
                if(this.ImgArrs[1][this.groupShow][this.$refs.input[i].name]){
                  this.$refs.input[i].value = this.ImgArrs[1][this.groupShow][this.$refs.input[i].name];
                }else{
                  this.$refs.input[i].value = '';
                }
              }
              
              for(let i=0;i<this.ImgArrs[1][this.showIndexes].pic.length;i++){
                document.getElementsByClassName('groupIMG')[0].innerHTML += '<div class="swiper-slide"><img src="'+this.www+this.ImgArrs[1][this.groupShow].pic[i]+'" alt=""></div>';
                document.getElementsByClassName('groupIMG')[1].innerHTML += '<div class="swiper-slide"><img src="'+this.www+this.ImgArrs[1][this.groupShow].pic[i]+'" alt=""></div>';
              }
              
            }
          }
// console.log(this.ImgArrs)
        },
        // 轮播图函数
        Swiper(index){
          var _this = this;
          var galleryTop = new Swiper('.gallery-top', {
              nextButton: '.swiper-button-next',
              prevButton: '.swiper-button-prev',
              spaceBetween: 6,           //slide之间的距离（单位px）
              observer:true,
              observeParents:true,
              onSlideChangeEnd: function(swiper){
                // alert(swiper.activeIndex)           //切换结束时，告诉我现在是第几个slide
                _this.showIndexes = swiper.activeIndex;
                if(_this.dialogNum==4){
                  var Length = 0;
                  for(let i in _this.ImgArrs[0][swiper.activeIndex]){
                    Length++;
                  }
                  if(Length!=1){
                    for(let i=0;i<_this.$refs.input.length;i++){
                      for(let j in _this.ImgArrs[0][swiper.activeIndex]){
                        if(_this.$refs.input[i].name==j){
                          _this.$refs.input[i].value = _this.ImgArrs[0][swiper.activeIndex][j];
                        }
                      }
                    }
                  }else{
                    for(let i=0;i<_this.$refs.input.length;i++){
                      _this.$refs.input[i].value = '';
                    }
                  }
                }
              }
          });
          var galleryThumbs = new Swiper('.gallery-thumbs', {
              spaceBetween: 6,
              centeredSlides: true,         //false无法使用
              slidesPerView: 'auto',        //设置slider容器能够同时显示的slides数量(carousel模式)。
              touchRatio: 0.2,              //触摸距离与slide滑动距离的比率。
              slideToClickedSlide: true,    //设置为true则点击slide会过渡到这个slide。
              observer:true,                //vue框架加入
              observeParents:true           //vue框架加入
          });
          galleryTop.params.control = galleryThumbs;
          galleryThumbs.params.control = galleryTop;
          if(index!=undefined&&_this.dialogNum==4){
            setTimeout(() => {
              galleryTop.slideTo(index, 1000, false)
            }, 500);
          }
        },
        // 提交
        submitProduction(dom){
          var _this = this;
          if(this.ImgArrs[0].length==0&&this.ImgArrs[1].length==0&&dom.target.getAttribute('data-status')==1){
            alert('未添加作品！')
            $('.continue_add').trigger("click");
            return false;
          }
          $('.continue_add').trigger("click");
          if(dom.target.getAttribute('data-status')==0){
              console.log(this.ImgArrs)
               $.ajax({
                  url: _this.www+"match/douploadimgs/"+{{ $personal->match_id }}, 
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                      },
                  method:'post',
                  data: {'data':JSON.stringify(_this.ImgArrs),'method':0},
                  success:function(data){
                    console.log(JSON.parse(data))
                    if(JSON.parse(data).data){
                      alert('保存成功！');
                    }else{
                      alert('保存失败，请重新保存！');
                    }
                  }
                })

          }else{
           
              for(let j=0;j<this.ImgArrs[0].length;j++){
                for(let u in this.ImgArrs[0][j]){
                  if(this.ImgArrs[0][j]['status']==0){
                    alert('有未填项！')
                    return false;
                  }
                }
              }
              for(let j=0;j<this.ImgArrs[1].length;j++){
                for(let u in this.ImgArrs[1][j]){
                  if(this.ImgArrs[1][j]['status']==0){
                    alert('有未填项！')
                    return false;
                  }
                }
              }
              console.log(this.ImgArrs)
               $.ajax({
                  url: _this.www+"match/douploadimgs/"+{{ $personal->match_id }}, 
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                      },
                  method:'post',
                  data: {'data':JSON.stringify(_this.ImgArrs),'method':1},
                  success:function(data){
                    console.log(JSON.parse(data))
                    if(JSON.parse(data).data){
                      alert('投稿成功！');
                      window.location.href=_this.www+'user/match';
                    }else{
                      alert('投稿失败，请重新投稿！');
                    }
                  }
                })
           
          }
          
          
        },
        // 初始化
        init(){
          
          var _this = this;
          $.ajax({
            url: _this.www+"match/ajax/pic/"+{{ $personal->match_id }},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
            method:'post',
            success:function(data){
              
              var Data = JSON.parse(data);
              for(let i=0;i<Data[0].length;i++){
                for(let j in Data[0][i]){
                  if(j=='diy_info'){
                    delete Data[0][i][j];
                  }
                }
              }
              for(let i=0;i<Data[1].length;i++){
                for(let j in Data[1][i]){
                  if(j=='diy_info'){
                    delete Data[1][i][j];
                  }
                }
              }
              // console.log(Data)
              _this.ImgArrs = Data;
              // console.log(_this.ImgArrs)
            }
          }).then(function(){
            _this.remain = 20-(_this.ImgArrs[0].length+_this.ImgArrs[1].length);
          })
        },
        // 返回保存
        returnPreserve(){
          if(this.isClass){
            // console.log('showIndexes',this.showIndexes)
            this.OneData();
          }else{
            // console.log('groupShow',this.groupShow)
            for(let i=0;i<this.$refs.input.length;i++){
                this.ImgArrs[1][this.groupShow][this.$refs.input[i].name] = this.$refs.input[i].value;
              }
              var falg = 0;
              for(let i=0;i<this.$refs.input.length;i++){
                if(this.$refs.input[i].getAttribute('mustfill')=='1'&&falg == 0){         //判断必填信息有无填写
                  if(this.$refs.input[i].value==''){
                    this.ImgArrs[1][this.groupShow]['status'] = 0;
                    // console.log(this.ImgArrs[0][this.groupShow])
                    falg++;
                  }else{
                    this.ImgArrs[1][this.groupShow]['status'] = 1;
                    // console.log(this.ImgArrs[0][this.groupShow])
                  }
                }
              }
          }
        },
        //获取单张input数据
        OneData(){
          for(let i=0;i<this.$refs.input.length;i++){
              this.ImgArrs[0][this.showIndexes][this.$refs.input[i].name] = this.$refs.input[i].value;
            }
            for(let i=0;i<this.$refs.input.length;i++){
              if(this.$refs.input[i].getAttribute('mustfill')=='1'){         //判断必填信息有无填写
                if(this.$refs.input[i].value==''){
                  this.ImgArrs[0][this.showIndexes]['status'] = 0;
                  // console.log(this.ImgArrs[0][this.showIndexes])
                  return false;
                }else{
                  this.ImgArrs[0][this.showIndexes]['status'] = 1;
                  // console.log(this.ImgArrs[0][this.showIndexes])
                }
              }
            }
        },
        //图片放大
        magnifyImg(e){
          if(e.target.nodeName.toLowerCase()=='img'){
            console.log(e.target.src)
            document.getElementsByClassName('Img_magnify')[0].style.display = 'block';
            document.getElementsByClassName('Img_magnify')[0].getElementsByTagName('img')[0].src = e.target.src;
          }
        },
        //放大的图片隐藏
        hideMagnify(){
          document.getElementsByClassName('Img_magnify')[0].style.display = 'none';
        },
        //加载器
        loader(){
          $(function(){
              var opts = {
                  lines: 9, // The number of lines to draw
                  length: 0, // The length of each line
                  width: 10, // The line thickness
                  radius: 15, // The radius of the inner circle
                  corners: 1, // Corner roundness (0..1)
                  rotate: 0, // The rotation offset
                  color: '#000', // #rgb or #rrggbb
                  speed: 1, // Rounds per second
                  trail: 60, // Afterglow percentage
                  shadow: false, // Whether to render a shadow
                  hwaccel: false, // Whether to use hardware acceleration
                  className: 'spinner', // The CSS class to assign to the spinner
                  zIndex: 2e9, // The z-index (defaults to 2000000000)
                  top: 'auto', // Top position relative to parent in px
                  left: 'auto' // Left position relative to parent in px
              };
              for(let i=0;i<document.getElementsByClassName('foo').length;i++){
                var target = document.getElementsByClassName('foo')[i];
                var spinner = new Spinner(opts).spin(target);
              }
          })
        },
        // 填写信息数据
        mustMessageFunc(){
          var must = JSON.parse('{!! $personal->production_info !!}' );
          var select = '{!! $personal->diy_info !!}' ? JSON.parse('{!! $personal->diy_info !!}') : '' ;
        // console.log(must,select)
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
          if(select&&select[0]!=null){
            for(let w=0;w<select[0].length;w++){
              var obj2 = {};
              obj2['name'] = 'defined'+w;
              obj2['text'] = select[0][w];
              obj2['judge'] = select[1][w];
              this.mustMessage.push(obj2);
            }
          }
          
          // console.log(this.mustMessage)   //表单列表
        }
         
      }

  })

</script>

@endsection