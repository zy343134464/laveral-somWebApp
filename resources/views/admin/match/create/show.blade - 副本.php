@extends('home.layout')   
@section('title', '赛事预览')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/match/matchview.css') }}"/>
@endsection

@section('body')
<!-- 赛事预览 -->
<main id="matchview">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-4">
                    <div class="side">
                        <ul class="side-up">
                            <li>
                                <input type="checkbox">
                                <span class="introduce">大赛简介</span>
                                <a href="#"><i class="fa fa-close"></i></a>
                                <a href="#"><i class="fa fa-arrow-up"></i></a>
                                <a href="#"><i class="fa fa-arrow-down"></i></a>
                            </li>
                            <li>
                                <input type="checkbox" class="ifview">
                                <span class="introduce">征稿时间</span>
                                <a href="#"><i class="fa fa-close"></i></a>
                                <a href="#"><i class="fa fa-arrow-up"></i></a>
                                <a href="#"><i class="fa fa-arrow-down"></i></a>
                            </li>
                            <li>
                                <input type="checkbox">
                                <span class="introduce">大赛评委</span>
                                <a href="#"><i class="fa fa-close"></i></a>
                                <a href="#"><i class="fa fa-arrow-up"></i></a>
                                <a href="#"><i class="fa fa-arrow-down"></i></a>
                            </li>
                            <li>
                                <input type="checkbox">
                                <span class="introduce">征稿细则</span>
                                <a href="#"><i class="fa fa-close"></i></a>
                                <a href="#"><i class="fa fa-arrow-up"></i></a>
                                <a href="#"><i class="fa fa-arrow-down"></i></a>
                            </li>
                            <li>
                                <input type="checkbox">
                                <span class="introduce">奖项设置</span>
                                <a href="#"><i class="fa fa-close"></i></a>
                                <a href="#"><i class="fa fa-arrow-up"></i></a>
                                <a href="#"><i class="fa fa-arrow-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="edit text-center">
                        <div class="bigtitle">
                            <h2>—— <span class="addpadding">{{json_decode($match->title)[0]}}</span> ——</h2>
                        </div>
                        <div class="lift-target">
                            <div class="t1"> 
                                <div class="content">
                                    <img src="{{ url($match->pic) }}" alt="">
                                    @if(count(json_decode($match->title)) > 1)
                                        @foreach(json_decode($match->title) as $tk =>$tv)
                                            @if($tk == 0)
                                                <h4>{{ $tv }}</h4>
                                            @else
                                                <h5>{{ $tv }}</h5>
                                            @endif
                                        @endforeach
                                    @else
                                        <h4>{{json_decode($match->title)[0]}}</h4>
                                    @endif
                                    <p>
                                        {{ $match->detail }}
                                    </p>
                                </div>
                            </div>
                            <div class="t2">
                                <h3>—— <span class="addpadding">征稿时间</span> ——</h3>
                                <div class="content">
                                    @if($match->collect_start)
                                    <p>征稿开始时间：{{date('Y-m-d H:i', $match->collect_start)}}</p>
                                    @endif
                                    @if($match->collect_end)
                                    <p>征稿结束时间：{{date('Y-m-d H:i', $match->collect_end)}}</p>
                                    @endif
                                    @if($match->public_time)
                                    <p>公布日期：{{date('Y-m-d H:i', $match->public_time)}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="t3">
                                <h3>—— <span class="addpadding">大赛评委</span> ——</h3>
                                <div class="content">
                                    <ul class="clearfix">
                                        @if($match->rater)
                                        @foreach($match->rater as $rv)
                                        <li>
                                            <img src="{{ url($rv->pic) }}" title="{{ $rv->detail}}">
                                            <p>{{ $rv->name}}</p>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="t4">
                                <h3>—— <span class="addpadding">征稿细则</span> ——</h3>
                                <div class="content">
                                @if($match->personal)
                                    <h5>{{ ($match->personal)[0]->introdution_title }}</h5>
                                    <p>
                                        {{ ($match->personal)[0]->introdution_detail }}
                                    </p>
                                    <div class="trigon"></div>
                                @endif
                                </div>
                            </div>
                            <div class="t5">
                                <h3>—— 奖项设置 ——</h3>
                                <div class="content">
                                @if($match->award)
                                @foreach($match->award as $av)
                                    <p>{{$av->name}} {{$av->num}}名 &nbsp;&nbsp;{{$av->detail}} </p>
                                @endforeach
                                @endif  
                                </div>
                            </div>
                            <div class="t6">
                            </div>
                        </div>
                        <div class="footer">
                            <a href="{{ url('admin/match/showedit/'.$id) }}" class="btn btn-default"> 还原</a>
                            <a href="{{ url('admin/match/edit/'.$id) }}" class="btn btn-default"> 返回编辑</a>
                            <button class="btn btn-default">保存 </button>
                            <a href="{{ url('admin/match/push_match/'.$id) }}" class="btn btn-default"> 发布比赛</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> 

@endsection

@section('other_js')
    <script src="{{ url('js/admin/match/matchview.js')}}"></script>
@endsection