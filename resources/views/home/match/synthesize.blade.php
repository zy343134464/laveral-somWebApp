@extends('home.layout')   

@section('title', '综合赛事-子赛事列表')

@section('other_css')
    <link rel="stylesheet" href="{{url('css/home/uploadcenter/synthesize.css')}}">
@endsection

@section('body')


<div class="product">
    <div class="row">
        <div class="col-sm-12">
            <div class="synth-cont">
                <h2>综合赛事</h2>
                <div class="tishi">
                    <p class="title">温馨提示</p>
                    <div class="msg">一个综合赛事当中有多个子赛事，你可以投稿一个或多个字赛事</div>
                </div>
                <ul class="match-main text-left clearfix">
                    @if(count($match))
                    @foreach($match as  $v)
                        <li>
                           <div class="match-img">
                                    <img src="{{ url($v->pic) }}" onerror="onerror=null;src='{{url('img/404.jpg')}}'">
                                    <a href="{{ url('match/uploadimg/'.$v->id) }}" class="match-check-mask">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                                <div class="match-content">
                                    <h4  title="">{{json_decode($v->title)[0]}}</h4>
                                    @if($v->production_sum($v->id,user()))
                                    <span class="status status-solicit">已投稿</span>
                                    @else
                                    <span class="status">未投稿</span>
                                    @endif
                                     <p>类别：{{ $v->type }}</p>
                                    <p class="status-time" style="color:#666;">  征稿期：
                                        @if($v->collect_start)
                                        {{ date('Y-m-d',$v->collect_start)}}
                                        @else
                                        未设置
                                        @endif
                                        --
                                        @if($v->collect_end)
                                        {{ date('Y-m-d',$v->collect_end)}}
                                        @else
                                        未设置
                                        @endif
                                    </p>
                                </div>
                        </li>
                    @endforeach
                    @endif
                        
                </ul>
                    <div class="tac"> <a href="" class="btn btn-warning">返回赛事中心</a></div>
            </div>
        </div>
    </div>
</div>

@endsection