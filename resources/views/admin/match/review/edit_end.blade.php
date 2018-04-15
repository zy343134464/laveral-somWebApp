@extends('admin.layout')  
@section('title', '评审室_最后一轮编辑')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/home/rater/rater.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/home/rater/test.css') }}"/>
    <meta name="_token" content="{{ csrf_token() }}"/>
@endsection


@section('body')
<style>
    .rater-main > li {
        height: 360px;
    }
    .num_tims li{
        border-bottom:4px solid #d0a45d;
    }
</style>
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
            <h2>{{@json_decode($match->title)[0]}}</h2>
            <h3>{{@json_decode($match->title)[1]}}</h3>
            </div>
            <div class="rater-nav clearfix">
                <ul class="nav navbar-nav num_tims">
                    <li >
                        <a href="{{url('admin/match/review_room/'.$id)}}">征稿期</a>
                        <div class="time"  style="display:none;">
                            剩下:<span>2天 4:58</span>
                            <span>　</span>
                        </div>    
                    </li>
                    @for($i=1;$i<$match->sum_round($match->id) + 1;$i++)
                    <li>
                        <a href="{{url('admin/match/review_room/'.$id.'?round='.$i.'&status=2')}}">第{{$i}}轮评审</a>
                        <div class="time" style="display:none;">
                            剩下:<span>2天 4:58</span>
                            <span>　</span>
                        </div>
                    </li>
                    @endfor
                    <li>
                        <a href="?status=3">赛事结束</a>
                        <div class="time"  style="display:block;">
                            剩下:<span>2天 4:58</span>
                            <span>　</span>
                        </div>
                    </li>
                </ul>
                <!-- <div class="progress"></div> -->
                
            </div>
        </div>
        <div class="col-xs-12 clearfix">
            <div class="col-xs-2" style="margin-left:-15px;">
                <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="" >所有奖项</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-10 text-right" style="padding-top:10px;">
            
            </div>
            <div class="col-xs-10 text-right" style="padding-top:10px;">
           
                @if(!$match->end_able($id))
                <a href="{{ url('admin/match/get_end_result/'.$id) }}" class="btn btn-default">还原赛果</a>
                @endif
                <a href="{{ url('admin/match/show_end/'.$id) }}" class="btn btn-default">预览赛果</a>
               
            </div>
        </div>
        
        <div class="col-xs-12">

            <!--   foreach start -->
            <ul class="rater-main text-left clearfix">

            @if( count($pic) )
                @foreach($pic as $pv)
                    <li>
                        <div>
                            <div class="rater-img">
                                <img src="{{ url($pv->pic) }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                            </div>
                            <div class="rater-content">
                                <h4>{{ $pv->title }}</h4>
                                <div class="img-Id">{{ $pv->id }}</div>
                            </div>
                            <div class="rater-btn" style="padding: 0 20px;" index="{{ $pv->id }}" match="{{ $match->id }}">
                                <p>{{ $pv->author }}</p>
                                <p class="testeli">{{$pv->win($pv->id)}}</p>
                            </div>
                            <button class="textbutton">奖项编辑</button>
                        </div>
                        <div class="choosebox" index="{{ $pv->id }}">
                            <div><span style="float:left" class="cancel">取消</span><span style="float:right" class="sure">确认</span><div style="clear:both"></div></div>
                            <ul id="ul_num">
                                @if(count($win))
                                @foreach($win as $wv)
                                <li data-id='{{$wv->id}}'>{{$wv->name}}</li>
                                @endforeach
                                @else
                                <li>未设置胜出</li>
                                @endif
                            </ul>
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
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
    </script>
    <script src="{{ url('js/home/rater/rater.js')}}"></script>
@endsection
