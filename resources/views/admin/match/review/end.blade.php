@extends('admin.layout')  
@section('title', '评审室——最后一轮赛果')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/home/rater/rater.css') }}"/>
@endsection


@section('body')
<style>
    @font-face {
        font-family: 'msyh';
        font-style: normal;
        font-weight: normal;
        src: url({{ storage_path('fonts/msyh.ttf') }}) format('truetype');
    }
    body {
        font-family: msyh, DejaVu Sans,sans-serif;
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
                <ul class="nav navbar-nav">
                    <li ><a href="{{url('admin/match/review_room/'.$id)}}">征稿期</a></li>
                    @for($i=1;$i<$match->sum_round($match->id) + 1;$i++)
                    <li><a href="{{url('admin/match/review_room/'.$id.'?round='.$i.'&status=2')}}">第{{$i}}轮评审</a></li>
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
            <div class="col-xs-10 text-right" style="padding-top:10px;">
                @if(!$match->end_able($id))
                <a href="{{ url('admin/match/edit_win/'.$id) }}" class="btn btn-default">返回编辑</a>
                <a href="{{ url('admin/match/end_match/'.$id) }}" class="btn btn-default">结束赛事</a>
                @endif
                <a href="{{ url('admin/match/end_result_pdf/'.$id) }}" class="btn btn-default" target="_blank">导出</a>
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
                        <div class="rater-img">
                            <img src="{{ url($v->pic) }}" data-toggle="modal" data-target="#imgrater{{$type}}">
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
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
    </script>
    <script src="{{ url('js/home/rater/rater.js')}}"></script>
@endsection