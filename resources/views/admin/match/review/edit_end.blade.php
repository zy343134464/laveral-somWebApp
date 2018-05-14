@extends('admin.layout')  
@section('title', '评审室_最后一轮编辑')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/home/rater/rater.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/home/rater/test.css') }}"/>
    <meta name="_token" content="{{ csrf_token() }}"/>
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
    .rater_list_li.border_2{
        border:2px solid red; 
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
        <div class="col-xs-12">
            <!--搜索框-->
            <!-- <div class="search-form">
                <i class="fa fa-search"></i>
                <input type="text" placeholder="关键字搜索" style="min-width:none;" name="kw">
            </div> -->
        </div>
          <div class="col-xs-12 text-center">
            <div class="rater-title">

                <h2>{{json_decode($match->title)[0]}}</h2>
                <h3>{{@json_decode($match->title)[1]}}</h3>
            </div>
            <div class="rater-nav clearfix">
                <ul class="nav navbar-nav num_times qwe">
                    <li>
                        <a href="{{url('admin/match/review_room/'.$id)}}">征稿期</a>
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

        <div class="col-xs-12 clearfix layerbtn">
            <div class="col-xs-1" style="margin:0 10px 0 -15px;">
                <div class="rater">
                    <select class="form-control no"  onchange="window.location=this.value">

                        <option value="all" {{ isset($_GET[ 'no']) && $_GET[ 'no']== 'all' ? 'selected' : ''}}>所有奖项</option>
                        @if(count($win))
                        @foreach($win as $wvalue)
                        <option value="{{$wvalue->id}}" {{ isset($_GET[ 'no']) && $_GET[ 'no']== $wvalue->id ? 'selected' : ''}}>{{ $wvalue->name }}</option>
                        @endforeach
                        @endif

                    </select>
                </div>
            </div>

            <!--  <div class="col-xs-1" style="margin-left: 15px;">
                <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="" >综合分</option>
                    </select>
                </div>
            </div> -->
         
            <div class="col-xs-9 text-right fr" style="padding-top:10px;">
           
                @if(!$match->end_able($id))
                <a href="#" data-id="0" class="btn btn-warning mr15">还原赛果</a>
                @endif
                <a href="#" data-id="1" class="btn btn-warning mr15">预览赛果</a>
                
               <!--  <div class="col-xs-1 fr mr15">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> 操作 <span class="caret"></span></button>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="{{ url('admin/match/match_pic_pdf/'.$id.(isset($_GET['round']) ? '?round='.$_GET['round'] : ''))}}">批量导出</a>
                        </li>
                        <li>
                            <a href="#" data-id="3">向评委展示赛果</a>
                        </li>
                         <li>
                            <a href="#" data-id="4">公布赛果</a>
                        </li>
                    </ul>
                </div> -->
            
            </div>
        </div>
        
        <div class="col-xs-12">

            <!--   foreach start -->
            <ul class="rater-main text-left clearfix">

            @if( count($pic) )
                @foreach($pic as $pv)
                    <li class="rater_list_li">
                        <div>
                            <div class="rater-img rater-img2">
                                <img src="" data-toggle="modal" data-target="#imgrater{{$type}}" indexpic="{{ $pv->pic }}">
                            </div>
                            <div class="rater-content">
                                <h4>{{ $pv->title }}</h4>
                                <div class="img-Id">{{ $pv->id }}</div>
                            </div>
                            <div class="rater-btn" style="padding: 0 20px;" index="{{ $pv->id }}" match="{{ $match->id }}">
                                <p>{{ $pv->author }}</p>
                                <p class="testeli" style=" min-hight:20px;">{{$pv->win($pv->id)}}</p>
                            </div>
                            <button class="textbutton" Competition-id='{{ $match->id }}'>奖项编辑</button>
                        </div>
                        <div class="choosebox" index="{{ $pv->id }}">
                            <ul id="ul_num" class="ul_num" style="max-height:216px;overflow-y: auto;">
                                @if(count($win))
                                @foreach($win as $wv)
                                <li data-id='{{$wv->id}}'><i class="SelectBtn"></i><span>{{$wv->name}}</span></li>
                                @endforeach
                                @else
                                <li>未设置胜出</li>
                                @endif
                            </ul>
                            <span class="else"><i class="SelectBtn"></i><span>其他</span><input type="text" placeholder="其他" style="display:none;" autofocus="autofocus"></span>
                            <div><span class="sure">确认</span><span class="cancel">取消</span></div>
                        </div>
                    </li>
                @endforeach
            @else
                <li>
                <div style="color:red;">暂无数据</div>
                </li>
            @endif
            </ul>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="paging text-center">
        {{ $pic->appends(['kw' => $kw,'status'=>@$status])->links() }}
    </div>
</section>
<!-- /.content -->
<!-- <div>
    <ul>
        <li><input type="checkbox" index="1" >金</li>
        <li><input type="checkbox"  index="2" >银</li>
        <li><input type="checkbox"  index="3">铜</li>
    </ul>
</div> -->
<!-- 评委投票（Modal） -->
<div class="modal fade" id="imgrater1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                            <img src="">
                            <span class="prev"><i class="fa fa-chevron-left"></i></span>
                            <span class="next"><i class="fa fa-chevron-right"></i></span>
                        </div>
                        <div class="btnrater" match="{{ $match->id }}" round="">
                            <button class="passbtn" value='1'>入围</button>
                            <button class="whilebtn" value='3'>待定</button>
                            <button class="outbtn" value='2'>淘汰</button>
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
    
</div>
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

    // 提示框----------------------------------
        var Reduction_result = "{{ url('admin/match/get_end_result/'.$id) }}", //还原赛果0
            Preview_result ="{{ url('admin/match/show_end/'.$id) }}", //预览赛果1
            show_result="{{ url('admin/match/edit_win/'.$id) }}",//向评委展示赛果3
            announce_results="{{ url('admin/match/end_match/'.$id) }}";//公布赛果4
        $('body').on('click', '.layerbtn a', function() {
            var _id = $(this).data('id');
            if(_id == 0) {
                //清除投稿数据
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定还原赛果吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = Reduction_result;
                    }
                })
            } else if(_id == 1) {
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定预览赛果吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = Preview_result;
                    }
                })
            }else if(_id == 3) {
                 commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定向评委展示赛果吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = show_result;
                    }
                })
            }  else if(_id == 4) {
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定公布赛果吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = announce_results;
                    }
                })
            }  
        })

    url_change('no');

   
     //同分显示框------------------
   {{-- var json =JSON.parse('{!!$same !!}'),
          rater_arr = [],
          rater_score = $('.testeli');
          if(json.length > 0) {
              for(var j = 0; j < json.length; j++) {
                  for(var i = 0; i < rater_score.length; i++) {
                      //获取页面中奖项名称
                         rater_arr=rater_score.eq(i).text().split(' ');
                         if(rater_arr.length>0){
                               for(var v = 0; v < rater_arr.length; v++) {
                                  if(json[j] === rater_arr[v]) {
                                      rater_score.eq(i).parents('.rater_list_li').addClass('border_2');
                                  };
                               }
                           }
                      
                  }
                    
              };
          };
          --}}
    </script>
   
@endsection
