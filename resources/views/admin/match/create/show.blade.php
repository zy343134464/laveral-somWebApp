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
                            <li class="current">
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
                        <div class="footer fix">
                            <a href="{{ url('admin/match/showedit/') }}" class="btn btn-default"> 还原</a>
                            <a href="{{ url('admin/match/edit/') }}" class="btn btn-default"> 返回编辑</a>
                            <button class="btn btn-defult">保存 </button>
                            <a href="{{ url('admin/match/push_match/') }}" class="btn btn-default"> 发布比赛</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> 


@endsection

@section('other_js')
    <script src="{{ url('js/admin/match/matchview.js')}}"></script>
@endsection