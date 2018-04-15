@extends('home.user.layout')   

@section('title', '我的赛事')

@section('more_css')
    
@endsection

@section('body2')
<div class="personal-search">
    <!--搜索框-->
    <i class="fa fa-search"></i>
    <form method="get">
        <input type="text" placeholder="关键字搜索" name="search">
    </form>
</div>
 {{-- dd($match) --}}

<div class="product">
    <div class="row">
        <div class="col-sm-12">
            <ul class="match-main text-left clearfix">
                <!-- 原作品是的标签 -->

                    @if( count($match) )
                    @foreach($match as $v)
                        <li>
                            <div class="match-img">
                                <img src="{{ url($v->pic) }}" onerror="onerror=null;src='{{url('img/404.jpg')}}'">
                                @if($v->cat == 1)
                                <a href="{{ url('user/son/'.$v->id) }}" class="match-check-mask">
                                @else
                                <a href="{{ url('user/match/'.$v->id) }}" class="match-check-mask">
                                @endif

                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                            <div class="match-content">
                                <a href="{{ url('match/detail/'.$v->id) }}"><h4  title="{{ (json_decode($v->title))[0]}}">{{ (json_decode($v->title))[0]}}</h4></a>
                                @if( $v->production_sum($v->id,user()) )
                                <span class="status status-solicit">已投稿</span>
                                @else
                                <span class="status">未投稿</span>
                                 @endif
                                <p class="status-time" style="color:#666;">
                                征稿期： @if($v->collect_start)
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
                            <div class="footer">
                                <a href="javascript:void(0)" class="del-btn"><i class="fa fa-close"></i></a>
                            </div>
                            <!-- <div class="footer">
                                <a href="#"><i class="fa fa-eye"></i> 0</a>
                                <a href="#"><i class="fa fa-thumbs-o-up"></i> 0</a>
                                <a href="#"><i class="fa fa-comment-o"></i> 0</a>
                            </div> -->
                        </li>
                         @endforeach
                         
                    @else
                    <li>
                        <div style="color:red;">暂无数据</div>
                    </li>
                    @endif
                             
            
            </ul>
            <div class="page text-center">
                {{ $match->links() }}
                <!-- <ul class="pagination" style="margin-bottom:100px;">
                    <li><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul> -->
            
            </div>
        </div>
    </div>
</div>

@endsection
