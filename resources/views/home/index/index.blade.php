@extends('home.layout')   
@section('title', '首页')



@section('other_css') 
    <link href="{{url('lib/owl.carousel/dist/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/home/index/index.css') }}"/>
@endsection


@section('body')
    <!--banner 轮播-->
       <section id="advertisement" class="pd-t">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="{{ url('img/images/banner1.jpg') }}" alt="图片1" class="img-responsive" height="630">
                </div>
                <div class="item">
                    <img src="{{ url('img/images/banner2.jpg') }}" alt="图片2" class="img-responsive" height="630">
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
        <div class="advertisement-text">
            <h2>SOM</h2>
            <h3>广告位</h3>
            <p>International exhibitions and.</p>
            <p class="lastP">Film game service system</p>
            <a href="#" class="btn btn-default">
                点击进入
                <i class="fa fa-caret-right"></i>
            </a>
        </div>
    </section>


<!--投资方轮播-->
<section id="collaborate">
    <div class="container" style="width:1094px;">
        <div class="row">
            <div class="col-md-12">
                <img src="{{ url('img/images/som-member.jpg') }}" alt="">
            </div>
        </div>
    </div>
</section>
<!--主内容-->
<section id="main">
    <div class="container" style="">
        <div class="row">
            <div class="col-md-12">
                <!--加入我们-->
                <div class="joinus-main">
                    <ul class="joinus clearfix">
                        <li>
                            <a href="#"><img src="{{ url('img/images/joneus.jpg') }}" alt=""></a>
                        </li>
                        <li>
                            <a href="#"><img src="{{ url('img/images/tutor.jpg') }}" alt=""></a>
                        </li>
                        <li>
                            <a href="#"><img src="{{ url('img/images/food.jpg') }}" alt=""></a>
                        </li>
                    </ul>
                </div>
                <div class="slideshow">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8" style="position: relative;left:0px;margin-top:20px;">
                                <section id="advertisement">
                                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                        </ol>
                                        <div class="carousel-inner" role="listbox">
                                            <div class="item active">
                                                <img src="{{ url('img/images/banner1.jpg') }}" alt="图片1" class="img-responsive" height="330">
                                            </div>
                                            <div class="item">
                                                <img src="{{ url('img/images/banner2.jpg') }}" alt="图片2" class="img-responsive" height="330">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="zixun">
                                <div class="news">
                                    <div class="news-title clearfix">
                                        <span class="pull-left">资讯 | 活动</span>
                                        <a href="#" class="pull-right">more</a>
                                    </div>
                                    <div class="news-list">
                                        <ul class="news-list-ul">
                                            @if( count($news) )
                                            @foreach($news as $nv)
                                            <li>
                                                <!-- <a href="{{ url('news/'.$nv->id) }}">{{$nv->title}}</a> -->
                                                <a href="">{{$nv->title}}</a>
                                                <span>{{ date('m-d',strtotime($nv->created_at)) }}</span>
                                            </li>
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--比赛-->
                <div class="match text-center">
                    <h3>
                        <span class="active">赛事资讯</span>
                        <span>展览资讯</span>
                        <span>活动专区</span>
                    </h3>
                    <ul class="match-main text-left clearfix">
						 @if( count($matches) )
                @foreach($matches as $v)
                        <li>
                            <a href="{{ url('match/detail/'.$v->id) }}">
                                <div class="match-img">
                                    <img src="{{ show_pic($v->pic) }}" width="355" onerror="onerror=null;src='{{url('img/404.jpg')}}'">
                                </div>
                            </a>
                            <div class="match-content">
                                <h4>{{ (json_decode($v->title))[0]}}</h4>
                                <span class="status status-solicit">
                                @if($v->status==0)
                                未发布 
                                @elseif($v->status==1)
                                赛事暂停
                                @elseif($v->status==2)
                                征稿中
                                @elseif($v->status==3)
                                征稿中
                                @elseif($v->status==4)
                                征稿结束
                                @elseif($v->status==5)
                                评审中
                                @elseif($v->status==6)
                                结束
                                @endif</span>
                                <p style="color:#666;" class="impose">{{ mb_substr($v->detail,0,50) }}</p>
                                <span class="status-time" style="color:#666;">征稿期： @if($v->collect_start)
                                {{ date('Y-m-d',$v->collect_start)}}
                                @else
                                未设置
                                @endif
                            -
                                @if($v->collect_end)
                                {{ date('Y-m-d',$v->collect_end)}}
                                @else
                                未设置
                                @endif</span>
                                <span class="share-alt"><i class="fa fa-share-alt"></i></span>
                            </div>
                        </li>
            			 @endforeach
            			 
	                @else
	                <li>
	                    <div style="color:red;">暂无数据</div>
	                </li>
	                @endif
                    </ul>
                    <div class="paging text-center">
                        {{ $matches->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('other_js')
    <script src="{{ url('lib/owl.carousel/dist/owl.carousel.min.js')}}"></script>
    <script src="{{ url('js/home/index/index.js') }}"></script>
@endsection