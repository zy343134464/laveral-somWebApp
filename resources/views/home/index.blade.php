<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOM SYSTEM</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('webFront/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('webFront/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('webFront/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="{{ url('webFront/dist/css/custom/index.css') }}"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!--导航条-->
<header id="header">
    <div class="topbar clearfix">
        <div class="col-sm-2">
            <img class="som-logo" src="{{ url('webFront/dist/img/images/som-index-logo.jpg') }}" alt="首页图片">
        </div>
        <div class="col-xs-6 som-nav">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">关于SOM</a></li>
                    <li><a href="#">导师</a></li>
                    <li><a href="#">活动</a></li>
                    <li><a href="#">赛事</a></li>
                    <li><a href="#">展览</a></li>
                    <li><a href="#">会员</a></li>
                </ul>
            </div>
        </div>
        <div class="col-xs-4 clearfix som">
            <div class="dropdown pull-right personal-center">
                <img class="users-logo" src="{{ url('webFront/dist/img/user2-160x160.jpg') }}" alt="头像">
                <button type="button" class="btn dropdown-toggle" id="dropdownMenu1"
                        data-toggle="dropdown">
                    @name()
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="#">个人中心</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="#">我的关注</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="#">修改密码</a>
                    </li>
                    <li role="presentation" class="divider"></li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="{{ url('logout') }}">退出</a>
                    </li>
                </ul>
            </div>
            <div class="dropdown pull-right language-switch">
                <img class="chinese-logo" src="{{ url('webFront/dist/img/images/chinese.jpg') }}" alt="中国图标">
                <button type="button" class="btn dropdown-toggle" id="dropdownMenu1"
                        data-toggle="dropdown">
                    中文
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="#">中文版</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="#">国际版</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!--banner 轮播-->
<section id="advertisement">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="{{ url('webFront/dist/img/images/banner1.jpg') }}" alt="图片1" class="img-fluid" width=100%>
            </div>
            <div class="item">
                <img src="{{ url('webFront/dist/img/images/banner2.jpg') }}" alt="图片2" class="img-fluid" width=100%>
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
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest1.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest2.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest3.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest4.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest5.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest1.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest2.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest3.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest4.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest5.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest1.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest2.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest3.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest4.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest5.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest1.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest2.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest3.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest4.jpg') }}" alt=""></div>
            <div class="item" style="width: 40px"><img src="{{ url('webFront/dist/img/images/invest5.jpg') }}" alt=""></div>
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
                            <a href="#"><img src="{{ url('webFront/dist/img/images/joneus.jpg') }}" alt=""></a>
                        </li>
                        <li>
                            <a href="#"><img src="{{ url('webFront/dist/img/images/tutor.jpg') }}" alt=""></a>
                        </li>
                        <li>
                            <a href="#"><img src="{{ url('webFront/dist/img/images/food.jpg') }}" alt=""></a>
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
                                <img src="{{ url('webFront/dist/img/images/match-img1.jpg') }}" alt="">
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
                                <img src="{{ url('webFront/dist/img/images/match-img2.jpg') }}" alt="">
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
                                <img src="{{ url('webFront/dist/img/images/match-img3.png') }}" alt="">
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
                                <img src="{{ url('webFront/dist/img/images/match-img4.jpg') }}" alt="">
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
                                <img src="{{ url('webFront/dist/img/images/match-img5.jpg') }}" alt="">
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
                                <img src="{{ url('webFront/dist/img/images/match-img6.jpg') }}" alt="">
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
                        <img src="{{ url('webFront/dist/img/images/news-somlogo.jpg') }}" alt="">
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
<!--尾部-->
<footer id="footer">
    <div class="about">
        <ul class="aboutus text-center">
            <li class="footer-logo">
                <a href="#"><img src="{{ url('webFront/dist/img/images/som-footerlogo.jpg') }}" alt=""></a>
            </li>
            <li class="contactus">
                <ul>
                    <li>
                        <h4>关于我们</h4>
                        <p>案例精选</p>
                        <p>团队介绍</p>
                    </li>
                    <li>
                        <h4>联系我们</h4>
                        <p>上海</p>
                        <p>北京</p>
                        <p>广州</p>
                        <p>杭州</p>
                    </li>
                    <li>
                        <h4>美学动态</h4>
                        <p>美学世界</p>
                        <p>新品鉴赏</p>
                        <p>大师灵感</p>
                    </li>
                    <li>
                        <h4>用户协议</h4>
                        <p>服务说明</p>
                        <p>用户行为</p>
                        <p>禁止事项</p>
                    </li>
                    <li>
                        <h4>企业服务</h4>
                        <p>文化推广</p>
                        <p>媒体友人</p>
                        <p>项目合作</p>
                    </li>
                </ul>
            </li>
            <li class="blogroll">
                <span><i class="fa fa-facebook"></i></span>
                <span><i class="fa fa-twitter"></i></span>
                <span><i class="fa fa-qq"></i></span>
                <span><i class="fa fa-weibo"></i></span>
            </li>
        </ul>
    </div>
    <div class="som-message">
        <div class="licence">
            <span>网络文化经营许可证 京网文[2016]6173-844号</span>
            <span>网络文化经营许可证 京网文[2016]6173-844号</span>
            <span>网络文化经营许可证 京网文[2016]6173-844号</span>
        </div>
        <div class="som-name">
            <span>公司名称:SOM特想有限文化公司</span>
            <span>电话:020-123456</span>
        </div>
        <div class="address">
            <span>公司地址:广州天河区科韵中路</span>
        </div>
    </div>
</footer>
<!-- jQuery 3 -->
<script src="{{ url('webFront/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('webFront/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ url('webFront/dist/js/custom/index.js') }}"></script>
</body>
</html>