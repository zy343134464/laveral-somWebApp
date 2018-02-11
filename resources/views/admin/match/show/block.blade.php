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
            @if(!isset($status) || ( $status != 0 && $status != 6) )
	        <div class="col-xs-2" style="margin-left:-72px;">
		        <div class="matchstate">
		       	 	<select class="form-control" onchange="window.location=this.value">
						<option value="./block">进行中</option>
						<option value="?status=3" {{ $status == 3 ? 'selected' :'' }}>征稿中</option>
						<option value="?status=5" {{ $status == 5 ? 'selected' :'' }}>评审中</option>
					</select>
		        </div>
	        </div>
            @endif
	      
             <!--批量导出-->
            @if(!isset($status) || $status != 0  )
            <div class="col-xs-3 pull-right" style="padding-right:0">
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
                                已发布
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
                            人数: <span>1000</span>
                        </p>
                        <p>
                            作品: <span>1000</span>
                        </p>
                    </div>
                    <div class="footer">
                     @if(!isset($status) || $status != 0  )
                        <span>
                            <a href="{{ url('admin/match/edit/'.$v->id) }}"><i class="fa fa-search"></i></a>
                        </span>
                        <span>
                            <a href="#" class="dropdown-toggle toggle-vis" data-toggle="dropdown" id="dropdownMenu4" aria-haspopup="true" aria-expanded="true">导</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu4">
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
                        </span>
                        @if($status == 6)
                        <span>
                            <a href="{{ url('admin/match/copy/'.$v->id) }}"><i class="fa fa-copy"></i></a>
                        </span>
                        @else
                        <span>
                            <a href="{{ url('admin/match/review_room/'.$v->id) }}">评</a>
                        </span>

                        @endif

                        @else
                         <span>
                            <a href="{{ url('admin/match/edit/'.$v->id) }}"><i class="fa fa-edit"></i></a>
                        </span>
                        <span>
                            <a href="{{ url('admin/match/copy/'.$v->id) }}"><i class="fa fa-copy"></i></a>
                        </span>
                        <span>
                            <a href="{{ url('admin/match/del/'.$v->id) }}"><i class="fa fa-times"></i></a>
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
        {{ $matches->appends(['kw' => $kw,'status'=>@$status])->links() }}
    </div>
</section>
<!-- /.content -->


@endsection

@section('other_js')
    <script src="{{ url('js/admin/match/matchingblock.js')}}"></script>
   
@endsection