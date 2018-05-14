@extends('home.layout')   
@section('title', '资讯页')



@section('other_css')
    <link rel="stylesheet" href="{{ url('css/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ url('css/home/rater/rater.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/home/index/new.css') }}"/>
@endsection






@section('body')
<!--主内容-->
<section id="new" class="news_hjy">
    <div class="container">
        <div class="row text-center">
            <h2 style="margin-top: 60px;">{{$news->title}}</h2>
            <h3 style="margin-top: 10px;">
                <span class="title_border">
                    <i>获奖名单</i>
                </span>
            </h3>
            <ul class="awards_list col-md-12 col-sm-12 col-lg-12">
                @if(count($data))
                @foreach($data as $value)
                <li>
                    <h3 class="awards_name">{{ $value['name'] }}</h3>
                    <ul class="works_list rater-main">
                        @if(count($value['pic']))
                        @foreach($value['pic'] as $pv)
                        <li class="works_hjy">
                            <div class="works_img rater-img2" data-toggle="modal" data-target="#imgrater2" index="{{ $pv->id }}">
                                <img src="" alt="" indexpic="{{ $pv->pic }}">
                            </div>
                            <ul class="works_message">
                                <li><span>{{ $pv->title }}</span></li>
                                <li>{{ $pv->author }}</li>
                                <li>
                                    @if($pv->cat==0)
                                    单张<i class="works_Id">{{ $pv->id }}</i></li>
                                    @else
                                    组图<i class="works_Id">{{ $pv->id }}</i></li>
                                    @endif
                            </ul>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </li>
                @endforeach
                @endif
            </ul>
        </div>
    <!-- 查看作品（Modal） -->
    <div class="modal fade" id="imgrater2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal100">
            <div class="modal-content">
                <div class="modal-header" style="padding-left:66px;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>

                </div>
                <div class="modal-body" style="padding-left:66px;">
                    <ul class="clearfix">
                        <li class="wrapperimg">
                            <div class="img">
                                <!-- <img src=""> -->
                                <!--  -->
                                <div class="swiper-container gallery-top">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                    <!-- <div class="swiper-button-next swiper-button-white"></div> -->
                                    <!-- <div class="swiper-button-prev swiper-button-white"></div> -->
                                </div>
                                <div class="swiper-container gallery-thumbs">
                                    <div class="swiper-wrapper">

                                        <div class="swiper-slide">
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <span class="prev swiper-button-prev"><i class="fa fa-chevron-left"></i></span>
                                <span class="next swiper-button-next"><i class="fa fa-chevron-right"></i></span>
                            </div>
                            <div class="btnrater" match="" round="">

                            </div>
                        </li>
                        <li class="wrapperinfro">
                            <ul>
                                <li style="padding-top:0;">
                                    <span>编号</span>
                                    <span class="imgId"></span>
                                </li>
                                <li>
                                    <span>作品标题</span>
                                    <span class="imgTitle"></span>
                                </li>
                                <li>
                                    <span>文字描述</span>
                                    <span class="imgDetail" style="width:300px;display:inline-block;vertical-align: top;"></span>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.modal-content -->
            <div class="dialog_button dialog2_button">
                <button type="button" class="continue_add prevButton">《 上一作品</button>
                <button type="button" class="continue_add nextButton">下一作品 》</button>
            </div>
        </div>
        <!-- /.modal -->
    </div>
</section>
@endsection





@section('other_js')
<script src="{{ url('js/swiper.min.js') }}"></script>
<script src="{{ url('js/home/rater/rater.js')}}"></script>
<script>
    $('header').on('click','.pull-right.personal-center',function(){
        $(this).toggleClass('open');
    })
</script>
@endsection