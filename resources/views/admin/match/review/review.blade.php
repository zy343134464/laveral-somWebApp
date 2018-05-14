@extends('admin.layout')
@section('title', '管理员评审室')
@section('other_css')
<link rel="stylesheet" href="{{ url('css/swiper.min.css') }}" />
<link rel="stylesheet" href="{{ url('css/home/rater/rater.css') }}" />
<link rel="stylesheet" href="{{ url('lib/commonLsf/css/commonLsf.css') }}" />
<style>
    .rater-main>li {
        width: 263px;
    }
    
    .content .btn-warning,
    .content .btn-primary {
        width: 100px;
        height: 30px;
    }
    
    .btn-cont {
        margin-top: 42px;
    }
    
    .tar {
        text-align: right;
    }
    
    .mr15 {
        margin-right: 15px;
    }
    .wrapper{
        background-color: #f1f1f1;
    }
    .active.on a {
        color: #d0a45d !important;
    }
</style>
@endsection @section('body')
<!-- 主内容 -->
<section class="content">
    
    <div class="row clearfix">
        <div class="col-xs-12 text-center">
            <div class="rater-title">
                <h2>{{json_decode($match->title)[0]}}</h2>
                <h3>{{@json_decode($match->title)[1]}}</h3>
            </div>
            <div class="rater-nav clearfix">
                <ul class="nav navbar-nav num_times qwe">
                    <li>
                        <a href="?status=1">征稿期</a>
                        <div class="time" style="display:none;">
                            剩下:<span>{{$time}}</span>
                        </div>
                    </li>

                    @if($status >4 || $status == 1) 
                    @for($i=1;$i<$match->sum_round($match->id) + 1;$i++)
                        <li>
                            <a href="{{ $match->round >= $i ? '?round='.$i.'&status=2' : 'javascript:;'}}">第{{$i}}轮评审</a>
                            <div class="time" style="display:none;">
                                剩下:<span>{{$time}}</span>
                            </div>
                        </li>
                        @endfor
                        <li>
                            <a href="?status=3">赛事结束</a>
                            <div class="time" style="display:none;">
                                剩下:<span>2天 4:58</span>
                                <span>　</span>
                            </div>
                        </li>
                        @endif
                </ul>
            </div>
        </div>

        @if($status==3)
        <!--征稿期-->
        <div class="col-xs-12 btn-cont layerbtn">
            <div class="col-xs-1" style="margin-left:-15px;">
                <div class="rater">
                   <select class="form-control cat"  onchange="window.location=this.value">
                        <option value="0" selected>团体/个人</option>
                        <option value="1" {{ $cat === 0 ? 'selected' : '' }}>个人 </option>
                        <option value="2" {{ $cat == 1 ? 'selected' : '' }}>团体 </option>
                    </select>
                </div>
            </div>

            <div class="col-xs-1 fr">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                        操作
                                        <span class="caret"></span>
                                    </button>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="#" data-id="6">清除投稿数据</a>
                    </li>
                    <li>
                        <a href="#" data-id="7">投稿数据统计</a>
                    </li>
                    <li>
                    <a href="{{url('admin/match/match_pic_pdf/'.$id . (isset($_GET['round']) ? '?round='.$_GET['round'] : ''))}}">导出参赛作品</a>
                    </li>
                    {{-- <!--<li>
                        <a href="{{url('admin/match/match_user_excel/'.$id . (isset($_GET['round']) ? '?round='.$_GET['round'] : ''))}}">导出用户数据</a>
                    </li> -->--}}
                    <li>
                        <a href="#" data-id="1">启动初审</a>
                    </li>
                </ul>
            </div>
        </div>

        @elseif($status==5)

        <!--编辑赛果之后-->
        @if($match->next_able($match->id,$match->round))
        <div class="col-xs-12 layerbtn btn-cont">
            <div class="col-xs-1" style="margin-left:-15px;">
                <div class="rater">
                    <select class="form-control cat"  onchange="window.location=this.value">
                        <option value="0" selected>团体/个人</option>
                        <option value="1" {{ $cat === 0 ? 'selected' : '' }}>个人 </option>
                        <option value="2" {{ $cat == 1 ? 'selected' : '' }}>团体 </option>
                    </select>
                </div>
            </div>

            @if($type==1)
            <div class="col-xs-1" style="margin-left:15px;">
                <!-- 投票排名 -->
                <div class="rater">
                    <select class="form-control sort" onchange="window.location=this.value">
                        <option value="0" {{ isset($_GET[ 'sort']) && $_GET[ 'sort']==0 ? '' : 'selected'}}>由高到低 </option>
                        <option value="1" {{ isset($_GET[ 'sort']) && $_GET[ 'sort']==1 ? 'selected' : ''}}>由低到高 </option>
                    </select>
                </div>
            </div>
            @else @if(count($dimension))
            <div class="col-xs-1" style="margin-left:15px;">
                <!-- 分数排名 -->
                <div class="rater">
                    <select class="form-control dimension" onchange="window.location.href=this.value">
                        <option value="0" {{ $wdselect==0 ? 'selected' : '' }}> 综合排名 </option>
                        @foreach($dimension as $dk => $dv)
                        <option value="{{$dk + 1 }}" {{ $wdselect==$dk + 1 ? 'selected' : '' }}> {{$dv}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif @endif
            <div class="col-xs-1 fr">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">操作<span class="caret"></span></button>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="#" data-id="0">清除评审数据</a>
                    </li>

                    <li>
                        <a href="{{url('admin/match/match_pic_pdf/'.$id . (isset($_GET['round']) ? '?round='.$_GET['round'] : ''))}}">导出参赛作品</a>
                    </li>
                    {{--  <!--<li>
                        <a href="{{url('admin/match/match_user_excel/'.$id . (isset($_GET['round']) ? '?round='.$_GET['round'] : ''))}}">导出用户数据</a>
                    </li> -->--}}
                    <li>
                        <a href="#" data-id="2">结束本轮评审</a>
                    </li> 
                    <li>
                        <a href="#" data-id="2">恢复本轮评审</a>
                    </li>

                </ul>
            </div>
            <div class="col-xs-3 fr tar" style="">
                <a href="#" type="button" class="btn btn-warning" data-id="5">进入下一轮</a>
                <a href="#" type="button" class="btn btn-warning" data-id="4">编辑赛果</a>
            </div>
        </div>
        @else
        <!--结束本轮评审前-->
        <div class="col-xs-12 layerbtn btn-cont">
            <div class="col-xs-1" style="margin-left:-15px;">
                <div class="rater">
                    <select class="form-control cat"  onchange="window.location=this.value">
                        <option value="0" selected>团体/个人</option>
                        <option value="1" {{ $cat === 0 ? 'selected' : '' }}>个人 </option>
                        <option value="2" {{ $cat == 1 ? 'selected' : '' }}>团体 </option>
                    </select>
                </div>
            </div>

            @if($type==1)
            <div class="col-xs-1" style="margin-left:15px;">
                <!-- 投票排名 -->
                <div class="rater">
                    <select class="form-control sort" onchange="window.location=this.value">
                        <option value="0" {{ isset($_GET[ 'sort']) && $_GET[ 'sort']==0 ? '' : 'selected'}}>由高到低 </option>
                        <option value="1" {{ isset($_GET[ 'sort']) && $_GET[ 'sort']==1 ? 'selected' : ''}}>由低到高 </option>
                    </select>
                </div>
            </div>
            @else @if(count($dimension))
            <div class="col-xs-1" style="margin-left:15px;">
                <!-- 分数排名 -->
                <div class="rater">
                    <select class="form-control dimension" onchange="window.location.href=this.value">
                        <option value="0" {{ $wdselect==0 ? 'selected' : '' }}> 综合排名 </option>
                        @foreach($dimension as $dk => $dv)
                        <option value="{{$dk + 1 }}" {{ $wdselect==$dk + 1 ? 'selected' : '' }}> {{$dv}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif @endif


            <div class="col-xs-1 fr">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">操作<span class="caret"></span></button>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="#" data-id="0">清除评审数据</a>
                    </li>

                    <li>
                        <a href="{{url('admin/match/match_pic_pdf/'.$id . (isset($_GET['round']) ? '?round='.$_GET['round'] : ''))}}">导出参赛作品</a>
                    </li>
                    {{--<!-- <li>
                        <a href="{{url('admin/match/match_user_excel/'.$id . (isset($_GET['round']) ? '?round='.$_GET['round'] : ''))}}">导出用户数据</a>
                    </li> -->--}}
                    <li>
                        <a href="#" data-id="2">结束本轮评审</a>
                    </li>

                </ul>
            </div>
            <!-- 评审进度 -->
            @if(count($rater))
                <div class="col-xs-1 mr15 fr">
                    <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                        评审进度
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right tac">
                    @foreach($rater as $rv)
                        <li>{{ $rv->name.' '.$rv->finish.'/'.$rv->total }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
        </div>
        @endif @endif
    </div>
   
    <div class="col-xs-12">
        <ul class="rater-main text-left clearfix">
            <!--   foreach start -->
            @if( count($pic) ) @foreach($pic as $v) @if($type == 2)
            <li>
                <div class="rater-img2" data-toggle="modal" data-target="#imgrater2" index="{{ $v->id }}">
                    <img src="" indexPic="{{ $v->pic }}">
                </div>
                <div class="rater-content">
                    <h4>{{ $v->title }}</h4>
                    <div class="img-Id">{{ $v->id }}</div>
                </div>
                <div class="rater-btn text-center rater_score" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$rounding}}">
                    @if($wdselect == 'sum') 综合分 :<span>{{ $v->sum ? $v->sum / 100 : '未评分'}}</span> @else {{ $dimension[$wdselect - 1] }} : <span><?php $field = 'p'.($wdselect - 1 < 0 ? 0 : $wdselect - 1 );echo $v->$field ?  $v->$field : '未评分';?></span> @endif
                </div>
            </li>

            @else
            <li>
                <div class="rater-img2" data-toggle="modal" data-target="#imgrater2" index="{{ $v->id }}">
                    <img src="" indexPic="{{ $v->pic }}">
                </div>
                <div class="rater-content">
                    <h4>{{ $v->title}}</h4>
                    <div class="img-Id">{{ $v->id }}</div>
                </div>
                <div class="rater-content" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$rounding}}">
                    作者:{{ @$v->author }} @if($status == 2 || $status == 3 || $status == 4)
                    <!-- <div class="right">
                        <i class="fa fa-edit" title="编辑"></i>
                    </div> -->
                    @else
                    <p class="rater_score">

                        票数:<span>{{ $v->sum ? $v->sum : 0}}</span> @endif
                    </p>
                </div>
                <!-- <div class="rater-footer">
                        
                    </div> -->
            </li>
            @endif @endforeach @else
            <li>
                <div style="color:red;">暂无数据</div>
            </li>
            @endif
        </ul>
    </div>
    <!-- /.col -->
  
    <!-- /.row -->
    <div class="paging text-center">
        {{ $pic->appends(['kw' => $kw,'status'=>$statusing,'round'=>$round])->links() }}
    </div>

</section>
<!-- /.content -->

<!-- 评委投票（Modal） -->
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
                        <div class="btnrater" match="{{ $match->id }}" round="{{ $rounding }}">

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

@endsection @section('other_js')
<script src="{{ url('js/swiper.min.js') }}"></script>
<script src="{{ url('js/home/rater/rater.js')}}"></script>
<script src="{{ url('lib/commonLsf/js/commonLsf.js') }}"></script>
<script>
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    // 模态框显示图片

    $(function() {

        var clear_result = "{{url('admin/match/clear_result/'.$id)}}", //清除评审 0
            end_collect = "{{url('admin/match/end_collect/'.$id)}}", //启动初审 1
            end_match_jieshu = "{{url('admin/match/result/'.$id)}}", //结束本轮评选 2
            end_match = "{{url('admin/match/end_match/'.$id)}}", //套用胜出机制  3
            edit_result = "{{url('admin/match/edit_result/'.$id)}}", //编辑赛果  4
            next_round = "{{url('admin/match/next_round/'.$id)}}", //进入下一轮  5
            clear_data = "{{url('admin/match/back_all_pic/'.$id)}}", //清除投稿数据     6
            data_statistics = ''; //投稿数据统计 7
            recover_match = ''; //恢复本轮评选 8

        $('body').on('click', '.layerbtn a', function() {
            var _id = $(this).data('id');
            if(_id == 0) {
                //清除投稿数据
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定清除评审数据吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = clear_result;
                    }
                })
            } else if(_id == 1) {
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定启动初审吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = end_collect;
                    }
                })
            } else if(_id == 2) {
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定结束本轮评选吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = end_match_jieshu;
                    }
                })
            } else if(_id == 3) {
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定套用胜出机制吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = end_match;
                    }
                })
            } else if(_id == 4) {
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定编辑赛果吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = edit_result;
                    }
                })
            } else if(_id == 5) {
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定进入下一轮吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = next_round;
                    }
                })
            } else if(_id == 6) {
                commonLsf.layerFunc({
                    title: "投稿数据",
                    msg: "确定进入清除投稿数据吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = clear_data;
                    }
                })
            } else if(_id == 7) {
                commonLsf.layerFunc({
                    title: "投稿数据",
                    msg: "共有{{$man_sum ? $man_sum : 0}}个人参加了比赛，共有{{$pic_sum ? $pic_sum : 0}}张作品",
                    closeBtn: 1
                })
            }
            else if(_id == 8) {
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定恢复本轮评选吗？",
                    closeBtn: 1
                },function(flag){
                    if(flag) {
                        window.location.href = recover_match;
                    }
                })
            }
        })

        //判断当前第几轮
        for(let i = 0; i < parseInt('{{$match->round}}') + 1; i++) {
            $('.qwe li').eq(i).addClass('on');
        }
        // 根据赛事进度给第几轮显示时间
        var timeNum = $('.num_times li.on').length - 1;
        console.log(timeNum);
        $('.num_times li').eq(timeNum).find('.time').show();
        $('.on').eq($('.number_times').val()).find('.time').show();
    })

    url_change('dimension');
    url_change('sort');
    url_change('cat'); 
    var status = '{{$statusing}}',round="{{$round}}";
    if(status==1){
        $('.qwe li').eq(0).addClass('active');
    }else{
         $('.qwe li').eq(round).addClass('active');
    }
</script>

@endsection