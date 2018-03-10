@extends('home.user.layout')   

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
                @if( count($match) )
                    @foreach($match as $v)
                        <li>
                            <a>
                                <div class="match-img">
                                    <img src="{{ url($v->pic) }}">
                                </div>
                            </a>
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

@section('other_js')
    
@endsection