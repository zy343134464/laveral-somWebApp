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
    <link rel="stylesheet" href="{{ url('css/admin/match/matchingblock.css') }}"/>
@endsection


@section('body')
<!-- 进行中比赛豆腐块 -->

<!-- 头部 -->

<!-- 主内容 -->
<section class="content">
    <div class="row clearfix">
    <form method="get">
        <div class="col-xs-12">
            <!--搜索框-->
            <div class="search-form">
                <i class="fa fa-search"></i>
                <input type="text" placeholder="请输入赛事标题" name="kw" value="{{$kw ? $kw : ''}}">
            </div>
        </div>
    </form>
        <div class="col-xs-12">
        	<div class="col-xs-2" style="margin-left:-15px;">
                <div class="matchkind">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="?cat={{ isset($_GET['status']) ? '&status='.$_GET['status'] : '' }}" {{ isset($cat)   ? '' :'selected' }}>全部赛事</option>
                        <option value="?cat=1{{ isset($_GET['status']) ? '&status='.$_GET['status'] : '' }}" {{ $cat == 1 ? 'selected' :'' }}>综合赛事</option>
                        <option value="?cat=0{{ isset($_GET['status']) ? '&status='.$_GET['status'] : '' }}" {{ $cat === '0' ? 'selected' :'' }}>单项赛事</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-2" style="margin-left:-75px;">
                <div class="matchkind">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="?status={{ isset($_GET['cat']) ? '&cat='.$_GET['cat'] : '' }}" {{ isset($status)   ? '' :'selected' }}>全部阶段</option>
                        <option value="?status=1{{ isset($_GET['cat']) ? '&cat='.$_GET['cat'] : '' }}" {{ $status == 1 ? 'selected' :'' }}>征稿中</option>
                        <option value="?status=2{{ isset($_GET['cat']) ? '&cat='.$_GET['cat'] : '' }}" {{ $status === 2 ? 'selected' :'' }}>评审中</option>
                    </select>
                </div>
            </div>

            <!--批量导出-->
            @if(!isset($status) || $status != 0  )
            <div class="col-xs-3 pull-right" style="padding-right:0">
                <div class="batch-export pull-right">
                    <div class="dropdown">
                        <!-- 
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
                        </ul> -->
                    </div>
                </div>
            </div>
            @else
            <div class="col-xs-3 pull-right" style="padding-right:0">
                <div class="batch-export pull-right">
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle toggle-vis" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            新建赛事
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                            <li><a href="{{ url('admin/match/create/0') }}">单项</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="{{ url('admin/match/create/1') }}">综合</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-xs-12">
            <ul class="match-main text-left clearfix">
                <!--   foreach start -->
                @if( count($matches) )
                @foreach($matches as $v)
                <li>
                    <div class="match-img">
                        <a href="{{ url('match/detail/'.$v->id) }}"><img src="{{ url($v->pic) }}"></a>
                    </div>
                    <div class="match-content">
                        <h4>{{ (json_decode($v->title))[0]}}</h4>
                        <p>
                            类别: <span>
                            @if($v->cat == 0)
                            {{ $v->type }}
                            @else
                                    综合赛事
                            @endif
                            </span>
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
                        </p>
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
                     @if(!isset($status) || $status != 0  )
                        <span>
                            <a href="{{ url('admin/match/edit/'.$v->id) }}"><i class="fa fa-edit" title="编辑"></i></a>
                        </span>
                        <span>
                            <a href="{{ url('admin/match/match_pic_pdf/'.$v->id)}}" title="导出">导</a>
                            <!-- 
                            <a href="#" class="dropdown-toggle toggle-vis" data-toggle="dropdown" id="dropdownMenu4" aria-haspopup="true" aria-expanded="true">导</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu4">
                                <li><a href="{{ url('admin/match/match_pic_pdf/'.$v->id)}}">仅数据</a></li>
                                <li role="presentation" class="divider"></li>
                                <li><a href="{{ url('admin/match/match_pic_pdf/'.$v->id)}}">仅缩略图</a></li>
                                <li role="presentation" class="divider"></li>
                                <li><a href="{{ url('admin/match/match_pic_pdf/'.$v->id)}}">仅大图</a></li>
                                <li role="presentation" class="divider"></li>
                                <li><a href="{{ url('admin/match/match_pic_pdf/'.$v->id)}}">数据+缩略图</a></li>
                                <li role="presentation" class="divider"></li>
                                <li><a href="{{ url('admin/match/match_pic_pdf/'.$v->id)}}">所有</a></li>
                            </ul> -->
                        </span>
                        @if($status == 6)
                        <span>
                            <a href="{{ url('admin/match/copy/'.$v->id) }}"><i class="fa fa-copy"  title="复制"></i></a>
                        </span>
                        @else
                        <span>
                            <a href="{{ url('admin/match/review_room/'.$v->id) }}" title="评审室">评</a>
                        </span>

                        @endif

                        @else
                         <span>
                            <a href="{{ url('admin/match/edit/'.$v->id) }}"><i class="fa fa-edit" title="编辑"></i></a>
                        </span>
                        <span>
                            <a href="{{ url('admin/match/copy/'.$v->id) }}"><i class="fa fa-copy"  title="复制"></i></a>
                        </span>
                        <span>
                            <a href="{{ url('admin/match/del/'.$v->id) }}"><i class="fa fa-times"  title="删除"></i></a>
                        </span>
                        @endif
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
        {{ $matches->appends(['kw' => $kw,'status'=>$status])->links() }}
    </div>
</section>
<!-- /.content -->


@endsection

@section('other_js')
    <script src="{{ url('js/admin/match/matchingblock.js')}}"></script>

@endsection