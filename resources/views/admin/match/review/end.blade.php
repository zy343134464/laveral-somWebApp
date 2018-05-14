@extends('admin.layout')  
@section('title', '评审室——最后一轮赛果')

@section('other_css')

    <link rel="stylesheet" href="{{ url('css/home/rater/rater.css') }}"/>
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
            p{
                padding: 0;
                margin: 0;
            }
        .rater-main > li {
            height: 360px;
        }
        .num_tims li{
            border-bottom:4px solid #d0a45d;
        }
        .layerbtn{
            padding-top: 20px;
        }
        .active.on a {
        color: #d0a45d !important;
        }
    </style>
@endsection


@section('body')

<!-- 主内容 -->
<section class="content">
    <div class="row clearfix">
       {{--
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
                            剩下:<span>2天 4:58</span>
                            <span>　</span>
                        </div>
                    </li>
                    @if($match->status >4 || $match->status == 1)
                     @for($i=1;$i<$match->sum_round($match->id) + 1;$i++)
                        <li>
                            <a href="{{ $match->round >= $i ? '?round='.$i.'&status=2' : 'javascript:;'}}">第{{$i}}轮评审</a>
                            <div class="time" style="display:none;">
                                剩下:<span>{{$time}}</span>
                                <span>　</span>
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
       --}}
        <div class="col-xs-12 text-center">
            <div class="rater-title">
            <h2>{{@json_decode($match->title)[0]}}</h2>
            <h3>{{@json_decode($match->title)[1]}}</h3>
            </div>
            <div class="rater-nav clearfix">
                <ul class="nav navbar-nav">
                    <li ><a href="{{url('admin/match/review_room/'.$id)}}" style="color: #323232;">征稿期</a></li>
                    @for($i=1;$i<$match->sum_round($match->id) + 1;$i++)
                    <li><a href="{{url('admin/match/review_room/'.$id.'?round='.$i.'&status=2')}}" style="color: #323232;">第{{$i}}轮评审</a></li>
                    @endfor
                    <li><a href="?status=3" style="color: #323232;">赛事结束</a></li>
                </ul>
                <div class="progress" style="width: 100%;"></div>
                <div class="time" >
                    <!-- 剩下:<span>2天 4:58</span> -->
                    <span>　</span>
                </div>
            </div>
        </div>
        
        <div class="col-xs-12 layerbtn clearfix">
            <!--  <div class="col-xs-1" style="margin:0 10px 0 -15px;">
                <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="" >所有奖项</option>
                    </select>
                </div>
            </div> -->
            <div class="col-xs-10 text-right fr" style="padding-top:10px;">
                @if(!$match->end_able($id))
                <a href="#" class="btn btn-warning" data-id="0">返回编辑</a>
                <a href="#" class="btn btn-warning" data-id="1">结束赛事</a>
                @endif
                <!-- <a href="{{ url('admin/match/end_result_pdf/'.$id) }}" class="btn btn-primary" target="_blank">导出</a> -->
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                        操作
                                        <span class="caret"></span>
                                    </button>
                <ul class="dropdown-menu pull-right">
                     <li>
                        <a href="javescript:;" data-id="2">公布赛果</a>
                    </li>
                    <li>
                        <a href="{{url('admin/match/match_pic_pdf/'.$id . (isset($_GET['round']) ? '?round='.$_GET['round'] : ''))}}">导出参赛作品</a>
                    </li>
                   
                    <li>
                        <a href="{{url('admin/match/match_user_excel/'.$id . (isset($_GET['round']) ? '?round='.$_GET['round'] : ''))}}">导出用户数据</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="col-xs-12">
                <!--   foreach start -->
                @if( count($pic) )
               
                @foreach($win as $kk => $wv)
                
                 <ul class="rater-main text-left clearfix">
                 <h2>{{ $wv->name}}</h2>
                    @if(count($pic[@$wv->no]))
                   @foreach($pic[$wv->no] as $v)
                
                    <li>
                        <div class="rater-img rater-img2">
                            <img src="" data-toggle="modal" data-target="#imgrater{{$type}}" indexpic="{{ $v->pic }}">
                        </div>
                        <div class="rater-content">
                            <h4>{{ $v->title }}</h4>
                            <div class="img-Id">{{ $v->id }}</div>
                        </div>
                        <div class="rater-btn" style="padding-left:20px;">
                        作者:{{ $v->author }}
                        </div>
                    </li>
                    
                    @endforeach
                    @else
                    <li>
                    <div style="color:red;">暂无数据</div>
                </li>
                    @endif
                    </ul>
                @endforeach
               @else
                <li>
                    <div style="color:red;">暂无数据</div>
                </li>
                @endif
            
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="paging text-center">
    </div>
</section>
<!-- /.content -->

@endsection

@section('other_js')
<script src="{{ url('lib/commonLsf/js/commonLsf.js') }}"></script>
<script src="{{ url('js/home/rater/rater.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
    });

     //判断当前第几轮
    for(let i = 0; i < parseInt('{{$match->round}}') + 1; i++) {
        $('.qwe li').eq(i).addClass('on');
    }
    // 根据赛事进度给第几轮显示时间
    var timeNum = $('.num_times li.on').length - 1;
    $('.num_times li').eq(timeNum).find('.time').show();
    $('.on').eq($('.number_times').val()).find('.time').show();

     
    var edit_win = "{{ url('admin/match/edit_win/'.$id) }}",//返回编辑 0
       end_match =  "{{ url('admin/match/end_match/'.$id) }}", //公布赛果 1
       gongbu_match =  "{{ url('admin/match/push_result/'.$id) }}"; //公布赛果 1
         $('body').on('click', '.layerbtn a', function() {
            var _id = $(this).data('id');
            if(_id == 0) {
                //清除投稿数据
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定返回编辑吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = edit_win;
                    }
                })
            } else if(_id == 1) {
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定结束赛事吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = end_match;
                    }
                })
           }else if(_id == 2){
             commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定公布赛果吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = gongbu_match;
                    }
               })
             }
         })
</script>
@endsection