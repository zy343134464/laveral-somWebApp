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
            <div class="search-form">
                <i class="fa fa-search"></i>
                <input type="text" placeholder="关键字搜索" style="min-width:none;" name="kw">
            </div>
        </div>
        <div class="col-xs-12 text-center">
            <div class="rater-title">
               
            <h3>{{json_decode($match->title)[0]}}</h3>
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
            评审中 轮次:{{$round}}
            @endif
            </div>
        </div>
        
        <div class="col-xs-12">
            <ul class="rater-main text-left clearfix">
                <!--   foreach start -->
                @if( count($pic) )
                @foreach($pic as $v)
                @if($type == 2)
                <li>
                    <div class="rater-img">
                        <img src="{{ url($v->pic) }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                    </div>
                    <div class="rater-content">
                        <h4>{{ $v->title}}</h4>
                        <div class="img-Id">{{ $v->id }}</div>
                    </div>
                    <div class="rater-btn text-center" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$round}}" >
                        评分
                    </div>
                </li>
                @else
                <li>
                    <div class="rater-img">
                        <img src="{{ url($v->pic) }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                    </div>
                    <div class="rater-content">
                        <h4>{{ $v->title}}</h4>
                        <div class="img-Id">{{ $v->id }}</div>
                    </div>
                    <div class="rater-content" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$round}}" >
                    作者:{{ @$v->author }}  <br>
                    票数:{{ @$v->sum_score->sum }}
                    </div>
                    <div class="rater-footer">
                        <a href="#"><span><i class="fa fa-search"></i></span></a>
                        <a href="#"><span><i class="fa fa-edit"></i></span></a>
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
        {{ $pic->appends(['kw' => $kw,'status'=>@$status])->links() }}
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
                        <div class="btnrater" match="{{ $match->id }}" round="{{ $round }}">
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