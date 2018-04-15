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
               
            <h2>{{json_decode($match->title)[0]}}</h2>
            <h3>{{@json_decode($match->title)[1]}}</h3>
            </div>
            <div class="rater-nav clearfix">
                <ul class="nav navbar-nav num_times">
                    <li>
                        <a href="?status=1">征稿期</a>
                        <div class="time" style="display:none;">
                            剩下:<span>2天 4:58</span>
                            <span>　</span>
                        </div>
                    </li>
                    @if($status >4  || $status == 1)
                    @for($i=1;$i<$match->sum_round($match->id) + 1;$i++)
                    <li>
                        <a href="?round={{$i}}&status=2">第{{$i}}轮评审</a>
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
                <!-- <div class="progress"></div>
                <div class="time" >
                    剩下:<span>2天 4:58</span>
                    <span>　</span>
                </div> -->
            </div>
        </div>
        <div class="col-xs-12 clearfix">
            <div class="col-xs-1" style="margin-left:-15px;">
                <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="" >团体/个人</option>
                        <option value="" >个人 </option>
                        <option value="" >团体 </option>
                    </select>
                </div>
            </div>

            @if(count($dimension))
            <div class="col-xs-1" style="margin-left:15px;">
                <!-- 综合分排名 -->
                <div class="rater">
                    <select class="form-control dimension"  onchange="window.location.href=this.value">
                          <option value="0" {{ $wdselect == 0 ? 'selected' : '' }}> 综合排名 </option>
                          @foreach($dimension as $dk => $dv)
                          <option value="{{$dk + 1 }}" {{ $wdselect == $dk + 1 ? 'selected' : '' }}> {{$dv}} </option>
                          @endforeach

                      </select>              
                </div>
                

            </div>
            @endif
            <div class="col-xs-1" style="margin-left:15px;">
                <!-- 投票排名 -->
                <div class="rater">
                    <select class="form-control sort"  onchange="window.location=this.value">
                        <option value="0" {{ isset($_GET['sort']) && $_GET['sort'] ? '' : 'selected'}} >由高到低 </option>
                        <option value="1" {{ isset($_GET['sort']) && $_GET['sort'] == 1 ? 'selected' : ''}} >由低到高 </option>
                    </select>
                </div>
            </div>
       <script>
            console.log('{{ $status }}');
       </script>
             <div class="col-xs-12 text-right" style="padding-top:10px;">
                @if($round == $rounding )
                    @if($match->next_able($match->id,$match->round))
                        @if($match->last_round($match->id,$match->round))
                            <a href="{{url('admin/match/end_match/'.$id)}}"type="button" class="btn btn-warning">套用胜出机制</a>
                            <a href="{{url('admin/match/edit_result/'.$id)}}" type="button" class="btn btn-warning">编辑赛果</a>
                        @else
                            <a href="{{url('admin/match/next_round/'.$id)}}" type="button" class="btn btn-warning">进入下一轮</a>
                            <a href="{{url('admin/match/edit_result/'.$id)}}" type="button" class="btn btn-warning">编辑赛果</a>
                        @endif
                    @endif
                @endif
             
                <div class="col-xs-1 fr">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                        操作
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right">
                        @if($status == 2 || $status == 3 || $status == 4)
                        <!--是否征稿期-->
                        <li><a href="#" >清除投稿数据</a></li>
                        <li><a href="#" data-id="1">投稿数据统计</a></li>
                        <li><a href="#" data-id="2">启动初审</a></li>
                        @else
                            @if(!$match->end_able($id))
                            <!--赛事是否结束-->
                                @if($round == $rounding )
                                <!--赛事当前轮次是否和查看的相同-->
                                    @if($match->next_able($match->id,$match->round))
                                    <!--是否可以进入下一轮（计算赛果后才能进入下一轮）-->
                                        <li><a href="#" data-id="4">清除评审数据</a></li>
                                        <li><a href="#" data-id="3">结束本轮评选</a></li>
                                    @else
                                        <li><a href="#" data-id="4">清除评审数据</a></li>
                                        
                                        <li><a href="#"  data-id="3">结束本轮评审</a></li>
                                    @endif
                                @endif
                            @endif

                        @endif
                            <li><a href="{{ url('admin/match/match_pic_pdf/'.$id)}}">批量导出</a></li>
                    </ul>
                </div>
                <!-- 评审进度 -->
                @if(count($rater))
                <div class="col-xs-2 fr">
                    <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                        评审进度
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right tac">
                    @foreach($rater as $rv)
                        <li>{{ $rv->name.' '.$rv->finish.'/'.$rv->total }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
            </div> 
        


        </div>
        <div class="col-xs-12">
            <ul class="rater-main text-left clearfix">
                <!--   foreach start -->
                @if( count($pic) )
                
                @foreach($pic as $v)
               
                @if($type == 2)
                <li>
                    <div class="rater-img2">
                        <img src="{{ url($v->pic) }}" indexPic="{{ $v->pic }}"  data-toggle="modal" data-target="#imgrater{{$type}}">
                    </div>
                    <div class="rater-content">
                        <h4>{{ $v->title }}</h4>
                        <div class="img-Id">{{ $v->id }}</div>
                    </div>
                    <div class="rater-btn text-center rater_score" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$rounding}}" > 
                    @if($wdselect == 'sum')
                        综合分 :<span>{{ $v->sum ? $v->sum / 100 : '未评分'}}</span>
                    @else
                        {{ $dimension[$wdselect - 1] }} : <span><?php $field = 'p'.($wdselect - 1 < 0 ? 0 : $wdselect - 1 );echo $v->$field ?  $v->$field : '未评分';?></span>
                    @endif
                    </div>
                </li>

                @else
                <li>
                    <div class="rater-img2">
                        <img src="{{ url($v->pic) }}" indexPic="{{ $v->pic }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                    </div>
                    <div class="rater-content">
                        <h4>{{ $v->title}}</h4>
                        <div class="img-Id">{{ $v->id }}</div>
                    </div>
                    <div class="rater-content" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$rounding}}" >
                    作者:{{ @$v->author }}
                    @if($status == 2 || $status == 3 || $status == 4)
                    <!-- <div class="right">
                        <i class="fa fa-edit" title="编辑"></i>
                    </div> -->
                    @else
                        <p class="rater_score">

                        票数:<span>{{ $v->sum ? $v->sum : 0}}</span>
                        @endif
                        </p>
                    </div>
                    <!-- <div class="rater-footer">
                        
                    </div> -->
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
        {{ $pic->appends(['kw' => $kw,'status'=>$statusing,'round'=>$round])->links() }}
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
<script src="{{ url('js/home/rater/rater.js?a=a')}}"></script>
<script>
    var clear_result = "{{url('admin/match/clear_result/'.$id)}}", //清除评审
        end_collect = "{{url('admin/match/end_collect/'.$id)}}", //启动初审
        end_result  = "{{url('admin/match/result/'.$id)}}";  //结束本轮评选
    $.ajaxSetup({
         headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
     });

    $(function(){
        var json = JSON.parse('{{ $same}}'); 
        rater_score = $('.rater_score');
        if(json.length>0){   
            for (var j=0;j<json.length; j++) {
                for(var i=0;i<rater_score.length;i++){
                    var rater_score_txt = rater_score.eq(i).children('span').html();
                    if(json[j]==rater_score_txt){
                        rater_score.eq(i).parents('li').css('border','2px solid red')
                    };
                }
            };
        };

            $('.dropdown-menu').on('click','a',function(){
                var _id = $(this).data('id');
                if(_id==0){
                    //清除投稿数据
                     layerFunc({title:"提示",msg:"确定清除投稿数据吗？"},function(flag){
                         if(flag){
                            window.location.href=clear_result;
                        }
                    })
                }else if(_id==1){
                     layerFunc({title:"投稿数据",msg:"共有XXX个人参加了比赛，共有XXXX张作品"})
                }else if(_id==2){
                     layerFunc({title:"提示",msg:"确定启动初审吗？"},function(flag){
                         if(flag){
                            window.location.href=end_collect;
                        }
                    })
                }else  if(_id==3){
                    console.log(_id)
                     layerFunc({title:"提示",msg:"确定结束本轮评选吗？"},function(flag){
                         if(flag){
                            window.location.href=end_result;
                        }
                    })
                 }else  if(_id==4){
                     layerFunc({title:"提示",msg:"确定清除评审数据吗？"},function(flag){
                         if(flag){
                            window.location.href=clear_result;
                        }
                    })
                 }
            })

         })

       url_change('dimension');
       url_change('sort');
    function url_change(ele){
    function changeURLArg(url,arg,arg_val){ 
            var pattern=arg+'=([^&]*)'; 
            var replaceText=arg+'='+arg_val; 
            if(url.match(pattern)){ 
                var tmp='/('+ arg+'=)([^&]*)/gi'; 
                tmp=url.replace(eval(tmp),replaceText); 
                return tmp; 
            }else{ 
                if(url.match('[\?]')){ 
                    return url+'&'+replaceText; 
                }else{ 
                    return url+'?'+replaceText; 
                } 
            } 
            return url+'\n'+arg+'\n'+arg_val; 
        } 

    for(let i=0;i<document.getElementsByClassName(ele)[0].getElementsByTagName('option').length;i++){
        var number = document.getElementsByClassName(ele)[0].getElementsByTagName('option')[i].value;
        var url_num = window.location.search;
        if(url_num == ''|| url_num ==null || url_num ==undefined ){
           document.getElementsByClassName(ele)[0].getElementsByTagName('option')[i].value ='http://'+ window.location.host+ window.location.pathname+'?'+ele+'='+number;
           console.log( document.getElementsByClassName(ele)[0].getElementsByTagName('option')[i].value);
        }else{
           document.getElementsByClassName(ele)[0].getElementsByTagName('option')[i].value = changeURLArg(window.location.href,ele,number);
        }
        
    }
}
 </script>
    
@endsection