@extends('admin.layout')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/match/matchcreate.css') }}">
@endsection


@section('body')
<!-- 新建比赛导航 -->
<div class="match-nav">
    <div class="collapse navbar-collapse" id="matchcreate">
        <ul class="nav navbar-nav">
            @if(isset($id))
                @if(match($id,'cat') != 2)
                <li class="active"><a href="{{ url ('admin/match/edit/'.$id) }}">赛事主题</a></li>
                <li><a href="{{ url('admin/match/partner/'.$id) }}">组委会信息</a></li>
                <li><a href="{{ url('admin/match/rater/'.$id) }}">评委/嘉宾</a></li>
                <li><a href="{{ url('admin/match/award/'.$id) }}">奖项设置</a></li>
                <li><a href="{{ url('admin/match/require_personal/'.$id) }}">投稿要求</a></li>
                @endif
                @if(match($id,'cat') != 1)
                <li><a href="{{ url('admin/match/review/'.$id) }}">评选设定</a></li>
                @endif
            @else
                <li class="active"><a href="#">赛事主题</a></li>
                <li><a href="#">组委会信息</a></li>
                <li><a href="#">评委/嘉宾</a></li>
                <li><a href="#">奖项设置</a></li>
                <li><a href="#">投稿要求</a></li>
                @if(@$type != 1)
                <li><a href="#">评选设定</a></li>
                @endif
            @endif
        </ul>
    </div>
</div>
<!-- 新建比赛内容 -->
@section('body2')

@show

@endsection

@section('other_js')
    <script src="{{ url('js/admin/match/matchcreate.js')}}"></script>
    <script>        
        $('.navbar-nav li a').each(function(){
            if($($(this))[0].href==String(window.location)){
                $(this).parent().parent().find('li').removeClass('active')
                $(this).parent().addClass('active');
            }
        });
    </script>
@endsection
