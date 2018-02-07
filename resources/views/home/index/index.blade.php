@extends('home.layout')   
@section('title', '首页')



@section('other_css') 
    <link href="https://cdn.bootcss.com/owl-carousel/1.32/owl.carousel.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/home/index/index.css') }}"/>
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
                <img src="{{ url('img/images/banner1.jpg') }}" alt="图片1" class="img-fluid" width=100%>
            </div>
            <div class="item">
                <img src="{{ url('img/images/banner2.jpg') }}" alt="图片2" class="img-fluid" width=100%>
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
        <h3>国际展览及影赛服务系统</h3>
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
    <div class="container">
        <div class="owl-carousel owl-theme">
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest1.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest2.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest3.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest4.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest5.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest1.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest2.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest3.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest4.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest5.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest1.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest2.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest3.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest4.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest5.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest1.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest2.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest3.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest4.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('img/images/invest5.jpg') }}" alt=""></div>
        </div>
    </div>
</section>
<!--主内容-->
<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <!--加入我们-->
                <div class="joinus-main">
                    <ul class="joinus">
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
                <!--比赛-->
                <div class="match text-center">
                    <h3>
                        赛事类目
                    </h3>
                    <div class="dropdown">
                        <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            全部赛事
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="#">综合赛事</a></li>
                            <li><a href="#">单项赛事</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            按时间筛选
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li><a href="#">2016</a></li>
                            <li><a href="#">一年内</a></li>
                            <li><a href="#">一个月内</a></li>
                            <li><a href="#">一周内</a></li>
                            <li><a href="#">三天内</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <select class="form-control" onchange="window.location=this.value">
						<option value="./">所有阶段</option>
						<option value="?status=3" {{ $status == 3 ? 'selected' :'' }}>征稿中</option>
						<option value="?status=5" {{ $status == 5 ? 'selected' :'' }}>评审中</option>
						<option value="?status=6" {{ $status == 6 ? 'selected' :'' }}>已结束</option>
					</select>
                    </div>
                    <ul class="match-main text-left clearfix">
						 @if( count($matches) )
                @foreach($matches as $v)
                        <li>
                            <a href="{{ url('match/detail/'.$v->id) }}">
                                <div class="match-img">
                                    <img src="{{ url($v->pic) }}">
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
                                已发布
                                @elseif($v->status==3)
                                征稿中
                                @elseif($v->status==4)
                                征稿结束
                                @elseif($v->status==5)
                                评审中
                                @elseif($v->status==6)
                                结束
                                @endif</span>
                                <p>{{ mb_substr($v->detail,0,50) }}</p>
                                <span class="status-time">征稿期： @if($v->collect_start)
                                {{ date('Y-m-s',$v->collect_start)}}
                                @else
                                未设置
                                @endif
                            -
                                @if($v->collect_end)
                                {{ date('Y-m-s',$v->collect_end)}}
                                @else
                                未设置
                                @endif</span>
                                <span class="share-alt"><i class="fa fa-share-alt"></i></span>
                            </div>
                            <div class="footer">
                                <div class="remain-time">
                                    <i class="fa fa-clock-o"></i>
                                    <span>还剩15天</span>
                                </div>
                                <div class="views">
                                    <i class="fa fa-eye"></i>
                                    <span>25000</span>
                                </div>
                                <div class="users">
                                    <i class="fa fa-user"></i>
                                    <span>4800</span>
                                </div>
                                <div class="images">
                                    <i class="fa fa-image"></i>
                                    <span>3256</span>
                                </div>
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
                        {{ $matches->links()}}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="news">
                    <div class="news-title clearfix">
                        <span class="pull-left">资讯 | 活动</span>
                        <a href="#" class="pull-right">more</a>
                    </div>
                    <div class="news-somlogo">
                        <img src="{{ url('img/images/news-somlogo.jpg') }}" alt="">
                    </div>
                    <div class="news-list">
                        <ul class="clearfix">
                        	@if( count($news) )
                			@foreach($news as $nv)
                            <li>
                                <a href="#">{{$nv->title}}</a>
                                <span>{{   date('m-s',strtotime($nv->created_at)) }}</span>
                            </li>
                            @endforeach
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection





@section('other_js')
    <script src="https://cdn.bootcss.com/owl-carousel/1.32/owl.carousel.min.js"></script>
    <script src="{{ url('js/home/index/index.js') }}"></script>
@endsection