@extends('home.rater.layout')  
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
            <div class="search-form"> 
                <i class="fa fa-search"></i>
                <input type="text" placeholder="关键字搜索" style="min-width:none;" name="kw">
            </div>
        </div>
        <div class="col-xs-12 text-center" style="margin-top:-70px;">
            <div class="rater-title">
            @if(count(json_decode($match->title)) > 1)
            @foreach(json_decode($match->title) as $tk =>$tv)
            @if($tk == 0)
            <h3>{{ $tv }}</h3>
            @else
            <h3>{{ $tv }}</h3>
            @endif
            @endforeach
            @else
            <h3>{{json_decode($match->title)[0]}}</h3>
            @endif
            </div>
        </div>
        <div class="col-xs-12 clearfix">
            <div class="col-xs-2" style="margin-left:-15px;">
                <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="?status=" {{ isset($status)   ? '' :'selected' }}>全部作品</option>
                        <option value="?status=1" {{ @$status == '1' ? 'selected' :'' }}>入围 </option>
                        <option value="?status=3" {{ @$status === '3' ? 'selected' :'' }}>待定 </option>
                        <option value="?status=2" {{ @$status === '2' ? 'selected' :'' }}>淘汰 </option>
                        <option  value="?status=0" {{ @$status === '0' ? 'selected' :'' }}>未评 </option>
                    </select>
                </div>
            </div>
            <div class="col-xs-10 text-right" style="padding-top:10px;">
                已评: <span style="padding-right:20px;">{{ $secure->finish }}</span>
                未评: <span>{{ $secure->total - $secure->finish }}</span>
            </div>
        </div>
        
        <div class="col-xs-12">
            <ul class="rater-main text-left clearfix">
                <!--   foreach start -->
                @if( count($pic) )
                @foreach($pic as $v)
                @if($type == 1)
                <li>
                    <div class="rater-img">
                        <img src="{{ url($v->pic) }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                    </div>
                    <div class="rater-content">
                        <h4>{{ $v->title}}</h4>
                        <div class="img-Id">{{ $v->id }}</div>
                    </div>
                    <div class="rater-btn text-center" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$round}}" >
                        <button class="passbtn {{ ($v->score($match->id,@$round,$v->id)) == 1 ? 'active':'' }}" value='1' >入围</button>
                        <button class="whilebtn {{ ($v->score($match->id,@$round,$v->id)) == 3 ? 'active':'' }}" value='3' >待定</button>
                        <button class="outbtn {{ ($v->score($match->id,@$round,$v->id)) == 2 ? 'active':'' }}" value='2'>淘汰</button>
                    </div>
                </li>
                @else
                <li>
                    <div class="rater-img">
                        <img src="{{ url($v->pic) }}" data-toggle="modal" data-target="#imgrater{{$type}}" index="{{ $v->id }}">
                    </div>
                    <div class="rater-content">
                        <h4>{{ $v->title}}</h4>
                        <div class="img-Id">{{ $v->id }}</div>
                    </div>
                    <div class="rater-btn text-center" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$round}}" >
                        综合分:{{ $v->rater_score_sum($match->id,@$round,$v->id) ?  $v->rater_score_sum($match->id,@$round,$v->id) / 100 : '未评分'}}
                    </div>
                </li>
                @endif
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
        {{ $pic->appends(['kw' => $kw,'status'=>@$status])->links() }}
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
                        <div class="btnrater" match="{{ $match->id }}" round="{{ $round }}"  type="1">
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

<!-- 评委评分（Modal） -->
<div class="modal fade" id="imgrater2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                        <div class="btnrater" match="{{ $match->id }}" round="{{ $round }}" type="2">
                            <div>
                            @if($type == 2)
                            @foreach((json_decode($review->setting,true))['dimension'] as $rk=>$rv)
                                {{$rv}}: <input type="text" class="score_input"
                                min="{{(json_decode($review->setting))->min }}" 
                                max="{{ (json_decode($review->setting))->min }}" 
                                index="{{ ((json_decode($review->setting,true)))['percent'][$rk] }}" style="width:40px;margin:5px 4px">
                            @endforeach
                            @endif
                            </div>
                            <div class="text-right" style="margin-top:10px;">
                                <a class="btn btn-warning sure">确认</a>
                            </div>
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
    <script src="{{ url('js/home/rater/rater.js')}}">
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
    </script>
    <script>
    var setting = "{{$review->setting}}";
    var type = "{{$type}}";
    </script>
@endsection