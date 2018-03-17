@extends('home.layout')   
@section('title', '赛事预览')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/match/matchview.css') }}"/>
@endsection

@section('body')
<!--banner 轮播-->
    <section id="advertisement">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="{{ url('img/images/banner1.jpg') }}" alt="图片1" class="img-responsive">
                </div>
                <div class="item">
                    <img src="{{ url('img/images/banner2.jpg') }}" alt="图片2" class="img-responsive">
                </div>
            </div>
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>
<!-- 赛事预览 -->
<main id="matchview">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-2">
                    <div class="side">
                        <ul class="side-up">
                            <li>
                                <span class="introduce">大赛简介</span>
                               
                            </li>
                             <!-- <li>
                               <input type="checkbox" class="ifview"> 
                                <span class="introduce">征稿时间</span>
                             
                            </li>-->
                            <li>
                                <span class="introduce">大赛评委</span>
                             
                            </li>
                            <li>
                                <span class="introduce">征稿细则</span>
                            
                            </li>
                            <li>
                                <span class="introduce">奖项设置</span>
                                <!--  <a href="#"><i class="fa fa-close"></i></a>
                               <a href="#"><i class="fa fa-arrow-up"></i></a>
                                <a href="#"><i class="fa fa-arrow-down"></i></a> -->
                            </li>
                        </ul>
                        <!-- 我要报名/回到顶部 -->
                        <div class="sign-up">
                          @if(is_join_match($id))
                           <div class="sign-up-div"><a href="{{ url('match/uploadimg/'.$id)}}">上传中心</a>
                           </div>
                            <div class="sign-up-div"><a href="">上传表格</a>
                           </div>
                          @else
                           <div class="sign-up-btn" data-status="sign">我要报名</div>
                           @endif
                           <div class="back-top-btn" data-status="top">回到顶部</div>

                           
                        </div>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="edit text-center">
                        <div class="bigtitle">
                            <h2> <span class="addpadding">{{json_decode($match->title)[0]}}</span> </h2>
                        </div>
                        <div class="lift-target">
                           <div class="lift-target-img clearfix">
                              <img src="{{ url($match->pic) }}" alt="">
                           </div>
                            <div class="t1 clearfix">
                             <h3>—— <span class="addpadding">大赛简介</span> ——</h3> 
                                <div class="content">
                                   
                                    <p>{{ $match->detail }}</p>

                                      @if(count($match->partner))
                                      @foreach($match->partner as $pv)
                                     <div class="content-lh45"> {{$pv->role}} :  {{$pv->name}}</div>
                                      @endforeach
                                      @endif
                                      
                                </div>
                            </div>
                         <!--    <div class="t2 clearfix">
                                <h3>—— <span class="addpadding">征稿时间</span> ——</h3>
                                
                            </div> -->
                            <div class="t3 clearfix" id="judges">
                                <h3>—— <span class="addpadding">大赛评委</span> ——</h3>
                                <div class="content">
                                    <ul class="clearfix ">
                                       @if($match->rater)
                                        @foreach($match->rater as $rv)
                                       <li class="fl">
                                             <img src="{{ url($rv->pic) }}" alt="" class="title-img">
                                             <div class="Personal-info">
                                             <img src="{{ url($rv->pic) }}" alt="" width="215" height="215"> 
                                                 <div class="Personal-desc">
                                                     <p>{{ $rv->name}}</p>
                                                     <div class="Personal-identity">{{ $rv->tag}}</div>
                                                     <div class="Personal-msg">
                                                         {{ $rv->detail}}
                                                        
                                                     </div>
                                                 </div>
                                             </div>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="t4 clearfix">
                                <h3>—— <span class="addpadding">征稿细则</span> ——</h3>
                                <div class="content">
                                    @if($match->collect_start)
                                    <h4>征稿开始时间：{{date('Y-m-d H:i', $match->collect_start)}}</h4>
                                    @endif
                                    @if($match->collect_end)
                                    <h4>征稿结束时间：{{date('Y-m-d H:i', $match->collect_end)}}</h4>
                                    @endif
                                  @if(count($match->personal))
                                  @foreach($match->personal as $personal)
                                    <h5>{{ $personal->introdution_title}}</h5>
                                    <div class="lh32">{{ $personal->introdution_detail }}</div> 
                                    @endforeach
                                  @endif
                                    <!-- 
                                    <h5>作品要求</h5>
                                    <p>1 . 内容要求 css中如何去掉select边框和小三角,c中如何去掉elect边框和小三角?elect有自己的默认样式,有时一效果</p>
                                      <p>2. 提交要求 css中如何去掉select边框和小三角,c中如何去掉elect边框和小三角?elect有自己的默认样式,有有时候我们需要美化成自己设计的样式,怎么用纯c来实现这一效果</p>
                                       <p>2.特别说明  css中如何去掉select边框和小三角,c中如何去掉elect边框和小三角?elect有自己的默认样式,有有时候我们需要美化成自己设计的样式,怎么用纯c来实现这一效果</p> -->
                                </div>
                            </div>
                            <div class="t5">
                                <h3><span class="addpadding"> —— 奖项设置 —— </span></h3>
                                <div class="content">
                                @if($match->award)
                                @foreach($match->award as $av)
                                    <p class="lh32">{{$av->name}} {{$av->num}}名 &nbsp;&nbsp;{{$av->detail}} </p>
                                @endforeach
                                @endif
                                    <h4 style="font-size:16px">注: 以上奖项为税前....</h4>
                                </div>
                            </div>
                         <!--    <div class="t6">
                            </div> -->
                        </div>
                      <!--   <div class="footer">
                            <a href="{{ url('admin/match/showedit/') }}" class="btn btn-default"> 还原</a>
                            <a href="{{ url('admin/match/edit/') }}" class="btn btn-default"> 返回编辑</a>
                            <button class="btn btn-default">保存 </button>
                            <a href="{{ url('admin/match/push_match/') }}" class="btn btn-default"> 发布比赛</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> 

<!-- 弹出层 -->
<div class="layer clearfix">

    <div class="statement layer-cont">
        <h5>赛事声明</h5>
     <div class="layer-close">
        <i class="glyphicon glyphicon-remove"></i>
    </div>
        <div class="statement-content" width ="500px;">
            <p>
               @if(count($match->personal))
               @foreach($match->personal as $personal)
                     {{ mb_substr($personal->notice,0,700) }}            
                @endforeach
               @endif
            </p>
        </div>
        <div class="statement-div">
            <div class="checkbox"> <input type="checkbox" class="layer-check-input"> 我已阅读本次赛事声明</div>
            <div class="statement-btn"> <input type="button" value="同意声明" class="layer-btn"> </div>
        </div>
    </div>
    <div class="layer-cont regist-info">
        <div class="layer-close">
        <i class="glyphicon glyphicon-remove"></i>
    </div>
       <form class="form-horizontal" method="post">
         <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label info-title">填写报名信息</label>
          </div>
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">报名类型</label>
           <div class="radio col-sm-7">
                <label>
                  <input type="radio" value="personal" name="status" class="layer-check-input">个人
                </label>
                 <label>
                  <input type="radio" value="group" name="status" class="layer-check-input">团体
                </label>
              </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">生日</label>
            <div class="col-sm-7">
              <input type="text" class="form-control" id="date-input" required name="birth" value="1988-02-1">
            </div>
          </div>

         <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">手机号码</label>
            <div class="col-sm-7">
              <input type="number" class="form-control" required name="phone_number" placeholder="请输入手机号码?">
            </div>
          </div>

          <div class="form-group Confirm-msg">
             <div class="checkbox"> <input type="checkbox" class="layer-check-input"> 本人上述信息，一经提交无法修改</div>
            <div class="statement-btn"> <a href="{{url('match/uploadimg/'.$id)}}" value="同意声明" class="layer-btn">同意声明</a> </div>
           
          </div>
        </form>
    </div>
</div>

@endsection

@section('other_js')
    <script src="{{ url('js/admin/match/matchview.js')}}"></script>
@endsection