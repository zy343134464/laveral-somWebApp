@extends('home.rater.layout') 

@section('title', '评委室')

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
                <input type="text" placeholder="关键字搜索">
            </div>
        </div>
        <div class="col-xs-12">
            
            <div class="col-xs-2">
                <div class="matchtime">
                    <select class="form-control">
                        <option>时间筛选</option>
                        <option>2016</option>
                        <option>一年内</option>
                        <option>一个月内</option>
                        <option>一周内</option>
                        <option>三天内</option>
                    </select>
                </div>
            </div>
            
        </div>
        <div class="col-xs-12">
            <ul class="match-main text-left clearfix">
                <!--   foreach start -->
                @if( count($matches) )
                @foreach($matches as $v)
                <li>
                    <div class="match-img">
                        <a href="{{ url('rater/review/'.$v->match->id.'/'.$v->round) }}"><img src="{{ url($v->match->pic) }}"></a>
                    </div>
                    <div class="match-content">
                        <h4>{{ (json_decode($v->match->title))[0]}}</h4>
                        <p>
                            赛事阶段: <span> 第{{ $v->round}}轮</span>
                        </p>
                        <p class="nostart" style="margin-top: 4px;">
                            评选状态: <span style="padding-right:40px;">
                             @if($v->match->round < $v->round)
                            未开始
                            @elseif($v->match->round == $v->round)
                            评审中 
                            @else
                            终审
                            @endif
                            </span>
                            <span>评审时间：<strong>{{date('Y-m-d', $v->rater_time($v->match->id, $v->round))}}</strong></span>
                            <span>
                                
                            </span>
                        </p>
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
        {{ $matches->appends(['kw' => $kw,'status'=>@$status])->links() }}
    </div>
</section>
<!-- /.content -->


@endsection

@section('other_js')
    <script src="{{ url('js/home/rater/rater.js')}}"></script>
@endsection