@extends('home.layout')   
@section('title', '首页')



@section('other_css') 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css"/>
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
                        <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu3"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            按状态筛选
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                            <li><a href="#">征稿中</a></li>
                            <li><a href="#">即将截稿</a></li>
                            <li><a href="#">评审中</a></li>
                            <li><a href="#">已结束</a></li>
                            <li><a href="#">所有</a></li>
                        </ul>
                    </div>
                    <ul class="match-main text-left clearfix">
                        <li>
                            <div class="match-img">
                                <img src="{{ url('img/images/match-img1.jpg') }}" alt="">
                            </div>
                            <div class="match-content">
                                <h4>SOM2018人物摄影年度大赛</h4>
                                <span class="status status-solicit">征稿中</span>
                                <p>此次赛事云集摄影界权威评委强强阻阵，将于三月底广州艺术馆开帷幕</p>
                                <span class="status-time">征稿期：2018年1月5日——2月5日</span>
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
                        <li>
                            <div class="match-img">
                                <img src="{{ url('img/images/match-img2.jpg') }}" alt="">
                            </div>
                            <div class="match-content">
                                <h4>海底摄影大赛</h4>
                                <span class="status status-endsoon">即将结束</span>
                                <p>此次赛事云集摄影界权威评委强强阻阵，将于三月底广州艺术馆开帷幕</p>
                                <span class="status-time">征稿期：2018年1月5日——2月5日</span>
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
                        <li>
                            <div class="match-img">
                                <img src="{{ url('img/images/match-img3.png') }}" alt="">
                            </div>
                            <div class="match-content">
                                <h4>SOM2018人物摄影年度大赛</h4>
                                <span class="status status-review">评审中</span>
                                <p>此次赛事云集摄影界权威评委强强阻阵，将于三月底广州艺术馆开帷幕</p>
                                <span class="status-time">征稿期：2018年1月5日——2月5日</span>
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
                        <li>
                            <div class="match-img">
                                <img src="{{ url('img/images/match-img4.jpg') }}" alt="">
                            </div>
                            <div class="match-content">
                                <h4>SOM2018人物摄影年度大赛</h4>
                                <span class="status status-end">已结束</span>
                                <p>此次赛事云集摄影界权威评委强强阻阵，将于三月底广州艺术馆开帷幕</p>
                                <span class="status-time">征稿期：2018年1月5日——2月5日</span>
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
                        <li>
                            <div class="match-img">
                                <img src="{{ url('img/images/match-img5.jpg') }}" alt="">
                            </div>
                            <div class="match-content">
                                <h4>SOM2018人物摄影年度大赛</h4>
                                <span class="status status-end">已结束</span>
                                <p>此次赛事云集摄影界权威评委强强阻阵，将于三月底广州艺术馆开帷幕</p>
                                <span class="status-time">征稿期：2018年1月5日——2月5日</span>
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
                        <li>
                            <div class="match-img">
                                <img src="{{ url('img/images/match-img6.jpg') }}" alt="">
                            </div>
                            <div class="match-content">
                                <h4>SOM2018人物摄影年度大赛</h4>
                                <span class="status status-end">已结束</span>
                                <p>此次赛事云集摄影界权威评委强强阻阵，将于三月底广州艺术馆开帷幕</p>
                                <span class="status-time">征稿期：2018年1月5日——2月5日</span>
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
                    </ul>
                    <div class="paging text-center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li>
                                    <a href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">6</a></li>
                                <li><a href="#">7</a></li>
                                <li><a href="#">...</a></li>
                                <li><a href="#">99</a></li>
                                <li><a href="#">100</a></li>
                                <li>
                                    <a href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
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
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                            <li>
                                <a href="#">XX摄影大赛于2018年完美落幕</a>
                                <span>11-20</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection





@section('other_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
    <script src="{{ url('js/home/index/index.js') }}"></script>
@endsection