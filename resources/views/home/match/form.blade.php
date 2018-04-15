@extends('home.layout')   
@section('title', '报名表单')

@section('other_css')
    <script src="{{ url('js/vue.js') }}"></script>
    <link rel="stylesheet" href="{{ url('css/home/uploadcenter/statement.css') }}"/>
@endsection


@section('body')
<!-- 上传中心 -->
<div id="app">
    <div class="container">
      <div class="row">
          <div class="col-sm-12">
            <!-- 顶部进展 -->
            <div class="body_top">
              <ul>
                <li>
                  <i class="top_num">1</i>
                  <span>阅读声明</span>
                </li>
                <li>
                  <i class="top_num">2</i>
                  <i class="top_border"></i>
                  <span>报名表单</span>
                </li>
                <li>
                  <i class="top_num">3</i>
                  <i class="top_border"></i>
                  <span>上传作品</span>
                </li>
                <li>
                  <i class="top_num">4</i>
                  <i class="top_border"></i>
                  <span>支付</span>
                </li>
              </ul>
            </div>
            <!-- 主体 -->
            <div class="main">
            <div class="regist-info" >
              <!-- <form class="form-horizontal" method="post" action="{{ url('match/join/'.$id) }}"> -->
              
              
                <h2>报名表单</h2>
                <div class="form-cont">
                    <div class="form-group"  style="width:760px; margin:0 auto">
                      <label for="inputEmail3" class="col-sm-3 control-label tar"><span>* </span>报名类型</label>
                      <div class="radio col-sm-7 team-div">
                        <label>
                            <input type="radio" value="1" name="status" class="layer-check-input">个人
                          </label>
                          <label style="margin-left:95px">
                            <input type="radio" value="2" name="status" class="layer-check-input" >团体
                          </label>
                        </div>
                    </div>
                 
                    <!-- 个人 -->
                    <div class="team-personal">
                        <form class="form-horizontal" method="post" action="{{ url('match/join/'.$id) }}">
                        {{ csrf_field() }}
                          <input type="hidden" name="status" value="1">
                          <div class="form-group">
                            <label for="personal_name" class="col-sm-3 control-label"><span>* </span>姓名</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" required name="personal_name" placeholder="请输入您的姓名?">
                            </div>
                          </div>
            

                          <div class="form-group">
                            <label for="personal_number" class="col-sm-3 control-label"><span>* </span>手机</label>
                            <div class="col-sm-7">
                              <input type="number" class="form-control" name="personal_number" required placeholder="请输入电话号码?">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="personal_email" class="col-sm-3 control-label"><span>* </span>邮箱</label>
                            <div class="col-sm-7">
                              <input type="email" class="form-control" required name="personal_email" placeholder="请输入您的邮箱?">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="personal_address" class="col-sm-3 control-label"><span>* </span>地址</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" required name="personal_address" placeholder="请输入您的地址?">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="personal_msg" class="col-sm-3 control-label">个人说明</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control"  name="personal_msg" placeholder="请输入您的个人说明?">
                            </div>
                          </div>

                            <div class="form-group Confirm-msg">
                              <div class="checkbox">
                                <input type="checkbox" class="layer-check-input"> 本人上述信息，一经提交无法修改
                               </div>
                              <div class="regist-info-div">
                                <button class="layer-btn" type="submit" disabled>同意声明</button>
                              </div>
                            </div>
                        </form>
                    </div>
               
                <!-- 个人END -->
                <!-- 团体 -->
                 <div class="team-group">
                    <form class="form-horizontal" method="post" action="{{ url('match/join/'.$id) }}">
                    {{ csrf_field() }}
                      <input type="hidden" name="status" value="2">
                        <div class="form-group">
                            <label for="group_unit" class="col-sm-3 control-label"><span>* </span>单位名称</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" required name="group_unit" placeholder="请输入单位名称?">
                            </div>
                          </div>

                         <div class="form-group">
                            <label for="group_name" class="col-sm-3 control-label"><span>* </span>联系人姓名</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" required name="group_name" placeholder="请输入联系人姓名?">
                            </div>
                          </div>


                         <div class="form-group">
                            <label for="group_number" class="col-sm-3 control-label"><span>* </span>联系人电话</label>
                            <div class="col-sm-7">
                              <input type="number" class="form-control" required name="group_number" placeholder="请输入联系人电话?">
                            </div>
                          </div>

                        <div class="form-group">
                            <label for="group_email" class="col-sm-3 control-label"><span>* </span>联系人邮箱</label>
                            <div class="col-sm-7">
                              <input type="email" class="form-control" required name="group_email" placeholder="请输入您的邮箱?">
                            </div>
                          </div>

                        <div class="form-group">
                          <label for="group_address" class="col-sm-3 control-label"><span>* </span>单位地址</label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" required name="group_address" placeholder="请输入您的地址?">
                          </div>
                        </div>

                       <div class="form-group Confirm-msg">
                        <div class="checkbox">
                          <input type="checkbox" class="layer-check-input"> 本人上述信息，一经提交无法修改
                         </div>
                        <div class="regist-info-div">
                          <button class="layer-btn" type="submit" disabled>同意声明</button>
                        </div>
                      </div>
                    </form>
                </div>
                 
                <!-- 团体END -->

           
            </div>
             </div>

            </div>
          </div>
      </div>
    </div>
</div> 
</div> 

@endsection

@section('other_js')
<script>
  $(function(){
    var _url = '{{ url('match/uploadimg/'.$id) }}';
      $('.body_top li:nth-child(2),.body_top li:first-child').addClass('mainCourse');
     $('.regist-info').on('click','.layer-check-input',function(){

      if($('input[type="radio"]').is(':checked')&&$('input[type="checkbox"]').is(':checked')){
          $('.regist-info .layer-btn').addClass('current').removeAttr("disabled");
        }else{
          $('.regist-info .layer-btn').removeClass('current').attr("disabled",'disabled');
        }
       
    })

      $('.regist-info').on('click','input[type="radio"]',function(){
      //个人团体选择框
        var radio_val = $(this).val();
        if(radio_val=='1'){
          $('.team-group').hide();
          $('.team-personal').show();
        }else{
           $('.team-group').show();
           $('.team-personal').hide();
        }
    })


      
  }) 
    
     
</script>
@endsection