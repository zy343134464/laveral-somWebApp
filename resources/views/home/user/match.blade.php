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

<div class="product">
    <div class="row">
        <div class="col-sm-12">
            <ul class="match-main text-left clearfix">
                <!-- 原作品是的标签 -->

                    @if( count($match) )
                    @foreach($match as $v)
                        <!-- <li>
                            <a href="#" style="background: url('{{ url($v->pic) }}') no-repeat center center;"></a>
                            <div class="match-content">
                                <h4 class="line-limit-length" style="width:150px;">{{ $v->title }}</h4>
                                <br>
                                <p class="line-limit-length"><a href="{{ url('match/detail/'.$v->match_id)}}">{{ (@json_decode($v->match->title))[0] }}</a></p>
                            </div>
                            <div class="footer">
                                <a href="#"><i class="fa fa-eye"></i> 0</a>
                                <a href="#"><i class="fa fa-thumbs-o-up"></i> 0</a>
                                <a href="#"><i class="fa fa-comment-o"></i> 0</a>
                            </div>
                        </li>
                         -->
                        <li>
                            <a href="{{ url('user/match/'.$v->id) }}">
                                <div class="match-img">
                                    <img src="{{ url($v->pic) }}" width="355" onerror="onerror=null;src='{{url('img/404.jpg')}}'">
                                </div>
                            </a>
                            <div class="match-content">
                                <h4>{{ (json_decode($v->title))[0]}}</h4>
                                <span class="status status-solicit">
                                
                                已投稿

                                </span>
                                <span class="status-time" style="color:#666;">
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
                                
                                </span>
                            </div>
                            <div class="footer">
                                <a href="#"><i class="fa fa-eye"></i> 0</a>
                                <a href="#"><i class="fa fa-thumbs-o-up"></i> 0</a>
                                <a href="#"><i class="fa fa-comment-o"></i> 0</a>
                            </div>
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
