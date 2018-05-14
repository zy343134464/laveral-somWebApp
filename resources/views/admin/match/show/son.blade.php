@extends('admin.layout')  

@section('title', json_decode($match->title)[0])


@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/match/matchingblock.css') }}"/>
@endsection


@section('body')
<!-- 进行中比赛豆腐块 -->
<!-- 主内容 -->
<section class="content">
    <div class="row clearfix">
       <br>
        <div class="col-xs-12">
            <!--批量导出-->
           <!--  <div class="col-xs-3 pull-right" style="padding-right:0">
                <div class="batch-export pull-right">
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle toggle-vis" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            批量导出
                            <i class="fa fa-share-square-o"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                            <li><a href="#">仅数据</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="#">仅缩略图</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="#">仅大图</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="#">数据+缩略图</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="#">所有</a></li>
                        </ul>
                    </div>
                </div>
            </div> -->
       <h2>{{json_decode($match->title)[0]}}</h2>
           
        </div>
        <div class="col-xs-12">
            <ul class="match-main text-left clearfix">
                <!--   foreach start -->
                @if( count($son) )
                @foreach($son as $v)
                <li>
                    <div class="match-img">
                        <img src="{{ url($v->pic) }}">
                    </div>
                    <div class="match-content">
                        <h4>{{ (json_decode($v->title))[0]}}</h4>
                        <p>
                            类别: <span>{{ $v->type }}</span>
                        </p>
                        <p>
                            阶段: <span>@if($v->status==0)
                                未发布 
                                @elseif($v->status==1)
                                赛事暂停
                                @elseif($v->status==2)
                                    征稿中
                                    
                                @elseif($v->status==3)
                                征稿中
                                @elseif($v->status==4)
                                征稿结束
                                @elseif($v->status==5)
                                评审中
                                @elseif($v->status==6)
                                结束
                                @endif
                        </span>
                        </p>
                        <p>
                            征稿期: <span>
                                @if($v->collect_start)
                                {{ date('Y-m-d',$v->collect_start)}}
                                @else
                                未设置
                                @endif
                            -
                                @if($v->collect_end)
                                {{ date('Y-m-d',$v->collect_end)}}
                                @else
                                未设置
                                @endif
                            </span>
                        </p>
                        <p>
                            公布期: <span>
                                @if($v->public_time)
                                {{ date('Y-m-d',$v->public_time)}}
                                @else
                                未设置
                                @endif
                            </span>
                        <p>
                            参与人数: <span>
                                {{ $v->author_sum($v->id) }}
                            </span>
                        </p>
                        <p>
                            作品数量: <span>
                                {{ $v->production_sum($v->id) }}
                            </span>
                        </p>
                    </div>
                    <div class="footer">
                        <span>
                            <a href="{{ url('admin/match/match_pic_pdf/'.$v->id)}}" title="导出" style="display:inline-block;width:20px;height:15px;"><img src="{{ url('img/exportIcon.png') }}" style="width:100%;height:100%;display:block;"></a>
                        </span>
                        <span>
                            <a href="{{ url('admin/match/review_room/'.$v->id) }}">评</a>
                        </span>
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
    </div>
</section>
<!-- /.content -->


@endsection

@section('other_js')
    <script src="{{ url('js/admin/match/matchingblock.js')}}"></script>
   
@endsection