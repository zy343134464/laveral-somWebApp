@extends('admin.layout')  
@section('title', '评审室')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/home/rater/rater.css') }}"/>
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
                <ul class="nav navbar-nav">
                    <li ><a href="?status=1">征稿期</a></li>
                    @for($i=1;$i<$match->sum_round($match->id) + 1;$i++)
                    <li><a href="?round={{$i}}&status=2">第{{$i}}轮评审</a></li>
                    @endfor
                    <li><a href="?status=3">赛事结束</a></li>
                </ul>
                <div class="progress"></div>
                <div class="time" >
                    <!-- 剩下:<span>2天 4:58</span> -->
                    <span>　</span>
                </div>
            </div>
        </div>
        <div class="col-xs-12 clearfix">
            <div class="col-xs-2" style="margin-left:-15px;">
                <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="" >全部作品</option>
                        <option value="" >个人 </option>
                        <option value="" >团体 </option>
                    </select>
                </div>
            </div>
            <div class="col-xs-10 text-right" style="padding-top:10px;">
            赛事:
            @if($status < 5 && $status != 1)
            投稿中
            @elseif($status == 1)
            暂停中
            @elseif($status ==6)
            已结束
            @else
            评审中 轮次:{{$rounding}}
            @endif
            </div>
            <div class="col-xs-10 text-right" style="padding-top:10px;">
            @if($round == $rounding )
                @if($match->next_able($match->id,$match->round))
                @if($match->last_round($match->id,$match->round))
                <a href="{{url('admin/match/end_match/'.$id)}}"type="button" class="btn btn-warning">套用胜出机制</a>
                @else
                <a href="{{url('admin/match/next_round/'.$id)}}" type="button" class="btn btn-warning">下一轮</a>
                <a href="{{url('admin/match/edit_result/'.$id)}}" type="button" class="btn btn-warning">编辑赛果</a>
                @endif
                <!-- <a href="{{url('admin/match/edit_result/'.$id)}}" type="button" class="btn btn-warning">编辑赛果</a> -->
                @endif
            @endif
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                    操作
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right">
                    @if($status == 2 || $status == 3 || $status == 4)
                    <li><a href="{{url('admin/match/end_collect/'.$id)}}">启动初审</a></li>
                    @else
                        @if(!$match->end_able($id))
                            @if($round == $rounding )
                            @if($match->next_able($match->id,$match->round))
                                <li><a href="{{url('admin/match/re_review/'.$id)}}">恢复本轮评审</a></li>
                                <li><a href="{{url('admin/match/get_end_result/'.$id)}}">套用胜出机制</a></li>
                            @else
                                <li><a href="{{url('admin/match/clear_result/'.$id)}}">清除评审数据</a></li>
                                @if($match->last_round($id))
                                <li><a href="{{url('admin/match/get_end_result/'.$id)}}">套用胜出机制</a></li>
                                @else
                                <li><a href="{{url('admin/match/result/'.$id)}}">结束本轮评审</a></li>
                                @endif
                            @endif
                            @endif
                        @endif

                    @endif
                        <li><a href="{{ url('admin/match/match_pic_pdf/'.$id)}}">导出</a></li>
                </ul>
            </div>
        </div>
        
        <div class="col-xs-12">
            <ul class="rater-main text-left clearfix">
                <!--   foreach start -->
                @if( count($pic) )
                <?php
                    $arr = [];
                ?>
                @foreach($pic as $v)
                <?php 
                
                   if(in_array($v->id, $arr)) {

                        continue;
                   } else {
                        $arr[] = $v->id;
                   }
                ?>
                @if($type == 2)
                <li>
                    <div class="rater-img2">
                        <img src="{{ url($v->pic) }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                    </div>
                    <div class="rater-content">
                        <h4>{{ $v->title }}</h4>
                        <div class="img-Id">{{ $v->id }}</div>
                    </div>
                    <div class="rater-btn text-center" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$rounding}}" >
                        综合分 :{{$v->admin_score_sum($v->id,($round ? $round : $rounding)) ? $v->admin_score_sum($v->id,($round ? $round : $rounding))/100 : '未评分'}}
                    </div>
                </li>
                @else
                <li>
                    <div class="rater-img2">
                        <img src="{{ url($v->pic) }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                    </div>
                    <div class="rater-content">
                        <h4>{{ $v->title}}</h4>
                        <div class="img-Id">{{ $v->id }}</div>
                    </div>
                    <div class="rater-content" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$rounding}}" >
                    作者:{{ @$v->author }}  <br>
                    @if($status == 2 || $status == 3 || $status == 4)
                    
                    <div class="right">
                        
                        <i class="fa fa-edit" title="编辑"></i>
                    </div>
                    @else
                    票数:{{ (@$v->sum_score($v->id,($round ? $round : $rounding)) ) ? @$v->sum_score($v->id,($round ? $round : $rounding)) :0}}
                    @endif
                    </div>
                    <div class="rater-footer">
                        
                    </div>
                </li>
                @endif
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
        {{ $pic->appends(['kw' => $kw,'status'=>$status])->links() }}
    </div>
</section>
<!-- /.content -->

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
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

@endsection

@section('other_js')
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
    </script>
    <script src="{{ url('js/home/rater/rater.js?a=a')}}"></script>
@endsection