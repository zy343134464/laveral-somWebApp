@extends('admin.layout')  
@if(isset($status)) 
    @if(@$status == 0)
        @section('title', '筹备中比赛')
    @elseif(@$status == 6)
        @section('title', '历史记录')
    @else
        @section('title', '进行中比赛')
    @endif
@else
    @section('title', '进行中比赛')
@endif

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
            <div class="col-xs-2" style="margin-left:-15px;">
                <div class="matchkind">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="?cat=" {{ isset($cat)   ? '' :'selected' }}>全部赛事</option>
                        <option value="?cat=1" {{ $cat == 1 ? 'selected' :'' }}>综合赛事</option>
                        <option value="?cat=0" {{ $cat === '0' ? 'selected' :'' }}>单项赛事</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-2" style="margin-left:-72px;">
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
            <div class="col-xs-2" style="margin-left:-72px;">
                <div class="matchstate">
                    <select class="form-control" onchange="window.location=this.value">
                        <option value="./block">进行中</option>
                        <option value="?status=3" {{ $status == 3 ? 'selected' :'' }}>征稿中</option>
                        <option value="?status=5" {{ $status == 5 ? 'selected' :'' }}>评审中</option>
                        <option value="?status=6" {{ $status == 6 ? 'selected' :'' }}>已结束</option>
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
                        <img src="{{ url($v->pic) }}">
                    </div>
                    <div class="match-content">
                        <h4>{{ (json_decode($v->title))[0]}}</h4>
                        <p>
                            赛事阶段: <span>征稿中 第1轮 终审</span>
                        </p>
                        <p class="nostart">
                            评选状态: <span style="padding-right:40px;">未开始 未完成 已完成</span>
                            <span>剩下<strong>2天 4:58</strong></span>
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