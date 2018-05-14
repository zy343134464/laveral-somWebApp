@extends('admin.layout')
@section('title', '评审室——编辑每一轮') 
@section('other_css')
<link rel="stylesheet" href="{{ url('lib/commonLsf/css/commonLsf.css') }}" />
<link rel="stylesheet" href="{{ url('css/home/rater/rater.css') }}" /> @endsection @section('body')
<style>
    .rater-main>li {
        width: 263px;
    }
    
    .content .btn-warning,
    .content .btn-primary {
        width: 100px;
        height: 30px;
    }
    
    .btn-cont {
        margin-top: 42px;
    }
    
    .tar {
        text-align: right;
    }
    
    .mr15 {
        margin-right: 15px;
    }
    p{
        padding: 0;
        margin: 0;
    }
    .active.on a {
        color: #d0a45d !important;
    }
</style>
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
                <ul class="nav navbar-nav num_times qwe">
                    <li>
                        <a href="?status=1">征稿期</a>
                        <div class="time" style="display:none;">
                            剩下:<span>2天 4:58</span>
                            <span>　</span>
                        </div>
                    </li>
                    @if($match->status >4 || $match->status == 1)
                     @for($i=1;$i<$match->sum_round($match->id) + 1;$i++)
                        <li>
                            <a href="{{ $match->round >= $i ? '?round='.$i.'&status=2' : 'javascript:;'}}">第{{$i}}轮评审</a>
                            <div class="time" style="display:none;">
                                剩下:<span>{{$time}}</span>
                                <span>　</span>
                            </div>
                        </li>
                        @endfor
                        <li>
                            <a href="?status=3">赛事结束</a>
                            <div class="time" style="display:none;">
                                剩下:<span>2天 4:58</span>
                                <span>　</span>
                            </div>
                        </li>
                        @endif
                </ul>
            </div>
        </div>

      

        <div class="col-xs-12 clearfix" style="padding-top:30px;">
            <div class="col-xs-1" style="margin:0 30px 0 -15px;">
                <div class="rater">
                    <select class="form-control cat" onchange="window.location=this.value">
                        <option value="all" {{ isset($_GET[ 'cat']) && $_GET[ 'cat']=='all' ? 'selected' : ''}}>团体/个人</option>
                        <option value="1" {{ isset($_GET[ 'cat']) && $_GET[ 'cat']==1 ? 'selected' : ''}}>个人 </option>
                        <option value="2" {{ isset($_GET[ 'cat']) && $_GET[ 'cat']==2 ? 'selected' : ''}}>团体 </option>
                    </select>
                </div>
            </div>
             <div class="col-xs-1">
                <div class="rater">
                    <select class="form-control select" onchange="window.location=this.value">
                        <option value="all" {{ isset($_GET[ 'select']) && $_GET[ 'select']=='all' ? 'selected' : ''}}>全部</option>
                        <option value="1" {{ isset($_GET[ 'select']) && $_GET[ 'select']==1 ? 'selected' : ''}}>入围 </option>
                        <option value="2" {{ isset($_GET[ 'select']) && $_GET[ 'select']==2 ? 'selected' : ''}}>淘汰 </option>
                    </select>
                </div>
            </div>
            <div class="col-xs-9 text-right layerbtn mr15 tar fr" style="margin-right:45px;">
                <span class=" mr15 fr">入围人数：{{$in}}/{{$promotion}}</span>
                <a href="#" type="button" class="btn btn-warning mr15 fr"  data-id="1">恢复评审数据</a>

                <a href="#" type="button" class="btn btn-warning mr15 fr" data-id="0">下一轮                                 </a>
                <div class="col-xs-1 fr">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> 操作 <span class="caret"></span></button>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="{{ url('admin/match/match_pic_pdf/'.$id.(isset($_GET['round']) ? '?round='.$_GET['round'] : ''))}}">批量导出</a>
                        </li>
                        <li>
                            <a href="#" data-id="3">套用胜出机制</a>
                        </li>
                    </ul>
                </div>
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
                ?> @if($type == 2)
                    <li>
                        <div class="rater-img rater-img2" index="{{ $v->id }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                            <img src="" indexpic="{{ $v->pic }}">
                        </div>
                        <div class="rater-content">
                            <h4>{{ $v->title}}</h4>
                            <div class="img-Id">{{ $v->id }}</div>
                        </div>
                        <div class="rater-content" style="position:relative;" index="{{ $v->id }}" match="{{ $match->id }}">
                            <p style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block;width:150px;">
                            作者: {{ @$v->author }}</p>
                            <p style="position:absolute;right:3px;bottom:6px;">
                            综合分 : <span class="rater_score">{{$v->admin_score_sum($v->id,$round) ? $v->admin_score_sum($v->id,$round)/100 : '未评分'}}</span>
                        </p>
                        </div>
                        <div class="edit-btn text-center" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$round}}">
                            <button class="editpassbtn <?php if(in_array($v->id,$win)) {echo 'active';} ?>" value='1' style="width:120px;margin-left:4px;">入围</button>
                            <button class="editoutbtn <?php if(!in_array($v->id,$win)) {echo 'active';} ?>" value='2' style="width:120px;">淘汰</button>
                        </div>
                    </li>
                    @else
                    <li>
                        <div class="rater-img rater-img2" index="{{ $v->id }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                            <img src="" indexpic="{{ $v->pic }}">
                        </div>
                        <div class="rater-content">
                            <h4>{{ $v->title}}</h4>
                            <div class="img-Id">{{ $v->id }}</div>
                        </div>
                        <div class="rater-content" style="position:relative;" index="{{ $v->id }}" match="{{ $match->id }}">
                           <p style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block;width:150px;">
                             作者:  {{ @$v->author }} </p>
                            <p style="position:absolute;right:3px;bottom:6px;">
                            票数: <span class="rater_score">{{ (@$v->sum_score($v->id,$round) ) ? @$v->sum_score($v->id,$round) :0}}</span>
                        </p>
                        </div>
                        <div class="edit-btn text-center" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$round}}">
                            <button class="editpassbtn <?php if(in_array($v->id,$win)) {echo 'active';} ?>" value='1' style="width:120px;margin-left:4px;">入围</button>
                            <button class="editoutbtn <?php if(!in_array($v->id,$win)) {echo 'active';} ?>" value='2' style="width:120px;">淘汰</button>
                        </div>
                    </li>
                    @endif @endforeach @else
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

@endsection @section('other_js')
<script src="{{ url('lib/commonLsf/js/commonLsf.js') }}"></script>
<script src="{{ url('js/home/rater/rater.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    //判断当前第几轮
    for(let i = 0; i < parseInt('{{$match->round}}') + 1; i++) {
        $('.qwe li').eq(i).addClass('on');
    }
    // 根据赛事进度给第几轮显示时间
    var timeNum = $('.num_times li.on').length - 1;
    $('.num_times li').eq(timeNum).find('.time').show();
    $('.on').eq($('.number_times').val()).find('.time').show();


    //同分显示框------------------
    var json =JSON.parse('{!!$same !!}');
    console.log(json);
  //  json = JSON.parse(json[0]);
    rater_score = $('.rater_score');
    if(json.length > 0) {
        for(var j = 0; j < json.length; j++) {
            for(var i = 0; i < rater_score.length; i++) {
                //获取页面中评分
                var rater_score_txt = rater_score.eq(i).html();
                if(json[j] == rater_score_txt) {
                    rater_score.eq(i).parents('li').css('border', '2px solid red')
                };
            }
        };
    };

 

    var Save_and_return="{{url('admin/match/next_round/'.$id)}}", //下一页 0
        recovery_data = "{{url('admin/match/reset_result/'.$id)}}",//恢复评审数据 1
        win= "{{url('admin/match/end_match/'.$id)}}"; //套用胜出机制 3
         $('body').on('click', '.layerbtn a', function() {
            var _id = $(this).data('id');
            if(_id == 0) {
                //清除投稿数据
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定到下一轮吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = Save_and_return;
                    }
                })
            } else if(_id == 1) {
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定恢复评审数据吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = recovery_data;
                    }
                })
            } else if(_id == 3) {
                commonLsf.layerFunc({
                    title: "提示",
                    msg: "确定恢复套用胜出机制吗？"
                }, function(flag) {
                    if(flag) {
                        window.location.href = win;
                    }
                })
            } 
        })
url_change('cat');
url_change('select');


</script>

@endsection