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
                <input type="text" placeholder="关键字搜索" style="min-width:none;">
            </div>
        </div>
        <div class="col-xs-12 text-center">
            <div class="rater-title">
                <h3>SOM2018摄影年度大赛之魅影少女</h3>
                <h3>少女.瞳</h3>
            </div>
            <div class="rater-nav clearfix">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">征稿期</a></li>
                    <li><a href="#">第1轮评审</a></li>
                    <li><a href="#">第2轮评审</a></li>
                    <li><a href="#">赛事结束</a></li>
                </ul>
                <div class="progress"></div>
                <div class="time">
                    剩下:<span>2天 4:58</span>
                </div>
            </div>
        </div>
        <div class="col-xs-12 clearfix">
            <div class="col-xs-2" style="margin-left:-15px;">
                <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="?cat=" {{ isset($cat)   ? '' :'selected' }}>全部作品</option>
                        <option value="?cat=1" {{ $cat == 1 ? 'selected' :'' }}>入围 <span>100</span></option>
                        <option value="?cat=0" {{ $cat === '0' ? 'selected' :'' }}>待定 <span>600</span></option>
                        <option value="">淘汰 <span>1000</span></option>
                        <option value="">未评 <span>2000</span></option>
                    </select>
                </div>
            </div>
            <div class="col-xs-10 text-right" style="padding-top:10px;">
                已评: <span style="padding-right:20px;">1000</span>
                未评: <span>2000</span>
            </div>
        </div>
        <div class="col-xs-12">
            <ul class="rater-main text-left clearfix">
                <!--   foreach start -->
                @if( count($matches) )
                @foreach($matches as $v)
                <li>
                    <div class="rater-img">
                        <img src="{{ url($v->pic) }}">
                    </div>
                    <div class="rater-content">
                        <h4>眼睛里的宇宙</h4>
                        <div class="img-Id">00124</div>
                    </div>
                    <div class="rater-btn text-center">
                        <input type="submit" class="passbtn" value="入围">
                        <input type="submit" class="whilebtn" value="待定">
                        <input type="submit" class="outbtn" value="淘汰">
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