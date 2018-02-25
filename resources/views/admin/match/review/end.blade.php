@extends('admin.layout')  
@section('title', '评审室')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/home/rater/rater.css') }}"/>
@endsection


@section('body')

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
            <div class="col-xs-2" style="margin-left:-15px;">
                <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="" >所有奖项</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-10 text-right" style="padding-top:10px;">
            
            </div>
            <div class="col-xs-10 text-right" style="padding-top:10px;">
           
                
                    <a href="{{ url('admin/match/review_room/'.$id) }}" class="btn btn-default">返回评审室</a>
                    <a href="#" class="btn btn-default">赛事已结束</a>
               
            </div>
        </div>
        
        <div class="col-xs-12">
           
                <!--   foreach start -->
                @if( count($pic) )
                <?php
                    $arr = [];
                ?>
                @foreach($pic as $kk => $vv)
                
                 <ul class="rater-main text-left clearfix">
                 <h2>{{ @$win[$kk]->name}}</h2>
                   @foreach($vv as $v)
                <?php
                    if(!$v) continue;
                    if(in_array($v->id, $arr)) {

                        continue;
                   } else {
                        $arr[] = $v->id;
                   }
                ?>
                    <li>
                        <div class="rater-img">
                            <img src="{{ url($v->pic) }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                        </div>
                        <div class="rater-content">
                            <h4>{{ $v->title }}</h4>
                            <div class="img-Id">{{ $v->id }}</div>
                        </div>
                        <div class="rater-btn text-center" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$rounding}}" >
                        </div>
                    </li>
                    
                    @endforeach
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

<!-- 评委投票（Modal） -->
<div class="modal fade" id="imgrater1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal100">
        <div class="modal-content">
            <div class="modal-header" style="padding-left:66px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
              
            </div>
            <div class="modal-body" style="padding-left:66px;">
                <ul class="clearfix">
                    <li class="wrapperimg">
                        <div class="img">
                            <img src="">
                            <span class="prev"><i class="fa fa-chevron-left"></i></span>
                            <span class="next"><i class="fa fa-chevron-right"></i></span>
                        </div>
                        <div class="btnrater" match="{{ $match->id }}" round="{{ $rounding }}">
                            <button class="passbtn" value='1'>入围</button>
                            <button class="whilebtn" value='3'>待定</button>
                            <button class="outbtn" value='2'>淘汰</button>
                        </div>
                    </li>
                    <li class="wrapperinfro">
                        <ul>
                            <li style="padding-top:0;">
                                <span>编号</span>
                                <span class="imgId"></span>
                            </li>
                            <li>
                                <span>作品标题</span>
                                <span class="imgTitle"></span>
                            </li>
                            <li>
                                <span>文字描述</span>
                                <span class="imgDetail" style="width:300px;display:inline-block;vertical-align: top;"></span>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

@endsection

@section('other_js')
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
    </script>
    <script src="{{ url('js/home/rater/rater.js')}}"></script>
@endsection