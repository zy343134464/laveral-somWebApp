@extends('admin.layout')  
@section('title', '评审室——编辑每一轮')

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
               
            <h2>{{json_decode($match->title)[0]}}</h2>
            <h3>{{@json_decode($match->title)[1]}}</h3>
            </div>
            <div class="rater-nav clearfix">
                <ul class="nav navbar-nav">
                    <li ><a >征稿期</a></li>
                    @for($i=1;$i<$match->sum_round($match->id) + 1;$i++)
                    <li><a >第{{$i}}轮评审</a></li>
                    @endfor
                    <li><a >赛事结束</a></li>
                </ul>
                <div class="progress"></div>
                <div class="time" >
                    <!-- 剩下:<span>2天 4:58</span> -->
                    <span>　</span>
                </div>
            </div>
        </div>
        <div class="col-xs-12 clearfix">
            <div class="col-xs-1" style="margin-left:-15px;">
                <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="" >全部作品</option>
                        <option value="" >个人 </option>
                        <option value="" >团体 </option>
                    </select>
                </div>
            </div>

            <!--  <div class="col-xs-1" style="margin-left:15px;">
                <!-- 投票排名
           <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="" >入围/淘汰</option>
                        <option value="" >入围 </option>
                        <option value="" >淘汰 </option>
                    </select>
                </div>
            </div> -->
 <!-- 分数维度排名 -->
        <!--<div class="col-xs-1" style="margin-left:15px;">
               
                <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="" >综合</option>
                        <option value="" >分数维度 </option>
                        <option value="" >分数维度 </option>
                    </select>
                </div>
            </div>
             <div class="col-xs-1" style="margin-left:15px;">
                 <div class="rater">
                      <select class="form-control"  onchange="window.location=this.value">
                            <option value="" selected>入围/淘汰</option>
                            <option value="" >入围 </option>
                            <option value="" >淘汰 </option>
                      </select>
                </div>
             </div> -->
<!-- 维度end -->

            <div class="col-xs-12 text-right" style="padding-top:10px;">
            <!-- 赛事: -->
            </div>
            <div class="col-xs-12 text-right" style="padding-top:10px;">
                <span>入围人数：1/30</span>
                <a href="{{url('admin/match/reset_result/'.$id)}}"type="button" class="btn btn-warning">恢复评审数据</a>
               
                <a href="{{url('admin/match/next_round/'.$id)}}" type="button" class="btn btn-warning">下一轮</a>
              
            </div>
        </div>
        
        <div class="col-xs-12">
            <ul class="rater-main text-left clearfix">
                <!--   foreach start -->
                @if( count($pic) )
                <?php
                    $arr = [];
                ?>
                @foreach($pic as $v)
                <?php 
                
                   if(in_array($v->id, $arr)) {

                        continue;
                   } else {
                        $arr[] = $v->id;
                   }
                ?>
                @if($type == 2)
                <li>
                    <div class="rater-img">
                        <img src="{{ url($v->pic) }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                    </div>
                    <div class="rater-content">
                        <h4>{{ $v->title}}</h4>
                        <div class="img-Id">{{ $v->id }}</div>
                    </div>
                    <div class="rater-content" style="position:relative;" index="{{ $v->id }}" match="{{ $match->id }}" >
                        <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block;width:150px;">
                            作者: {{ @$v->author }}</span>
                        <span style="position:absolute;right:0;bottom:6px;">
                            综合分 :{{$v->admin_score_sum($v->id,$round) ? $v->admin_score_sum($v->id,$round)/100 : '未评分'}}
                        </span>
                    </div>
                    <div class="edit-btn text-center" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$round}}" >
                        <button class="editpassbtn <?php if(in_array($v->id,$win)) {echo 'active';} ?>" value='1' style="width:120px;margin-left:4px;">入围</button>
                        <button class="editoutbtn <?php if(!in_array($v->id,$win)) {echo 'active';} ?>" value='2' style="width:120px;">淘汰</button>
                    </div>
                </li>
                @else
                <li>
                    <div class="rater-img">
                        <img src="{{ url($v->pic) }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                    </div>
                    <div class="rater-content">
                        <h4>{{ $v->title}}</h4>
                        <div class="img-Id">{{ $v->id }}</div>
                    </div>
                    <div class="rater-content" style="position:relative;" index="{{ $v->id }}" match="{{ $match->id }}" >
                        <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block;width:150px;">
                            作者: {{ @$v->author }}</span>
                        <span style="position:absolute;right:0;bottom:6px;">
                            票数:{{ (@$v->sum_score($v->id,$round) ) ? @$v->sum_score($v->id,$round) :0}}
                        </span>
                    </div>
                    <div class="edit-btn text-center" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$round}}" >
                        <button class="editpassbtn <?php if(in_array($v->id,$win)) {echo 'active';} ?>" value='1' style="width:120px;margin-left:4px;">入围</button>
                        <button class="editoutbtn <?php if(!in_array($v->id,$win)) {echo 'active';} ?>" value='2' style="width:120px;">淘汰</button>
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

@endsection

@section('other_js')
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
    </script>
    <script src="{{ url('js/home/rater/rater.js')}}"></script>
@endsection