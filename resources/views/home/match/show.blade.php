@extends('home.layout')   
@section('title', '赛事预览')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/match/matchview.css') }}"/>
@endsection

@section('body')

<!-- 赛事预览 -->
<!-- 赛事预览 -->
      <main id="matchview" class="main_matchview">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">

              <div class="col-sm-10">
                <!--广告图-->
                <div class="detail_banner">
                  <img src="{{ url($match->pic) }}" alt="" width="960"/>
                </div>
                <div class="detail_cont">
                  <!--标题-->
                  <h2 class="tac">{{json_decode($match->title)[0]}}</h2>

                  <div class="t1 clearfix">
                    <h3 class="tac">大赛简介</h3>
                    <div class="content">
                     {!! str_replace(array("\r\n", "\r", "\n"), "<br/>", $match->detail) !!}
                    </div>
                    <div class="start_time">
                      <p>征稿开始时间：{{ date('Y-m-d H:i',$match->collect_start) }}</p>
                      <p>征稿结束时间：{{ date('Y-m-d H:i',$match->collect_end) }}</p>
                      @if($match->public_time)
                      <p>赛果公布日期：{{ date('Y-m-d H:i',$match->public_time) }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="t2 clearfix tac zuweihui">
                      <h3 class="">组委会信息</h3>
                      <div class="content">
                      <ul>
                        @if($match->partner)
                        @foreach($match->partner as $av)

                          <li>
                            <span class="require_list">{{$av->role}}:</span><span class="require_content">{{$av->name}}</span>
                          </li>
                        @endforeach
                        @endif

                         
                          <li>
                            <span class="require_list">联系方式:</span><span class="require_content">
                            @if($match->connection)
                            @foreach($match->connection as $av)

                            <span class="contact">{{ $av->type }}:{{ $av->value }}</span><br>
                             @endforeach
                             @endif
                          </li>
                        </ul>

                      </div>
                  </div>
                  <div class="t3 clearfix">
                    <h3 class="tac">评委&嘉宾</h3>
                    <div class="content judge_list">
                      <!-- <ul class="judges_ul clearfix">
                        
                        <li class="tac">
                          <img src="" alt="" class="judge_img" />
                          <p class="name">name </p>
                          <p class="title" style="font-size:14px">tag</p>
                          <div class="cont_msg" style="display:none">detail</div>
                        
                        </li>
                        
                      </ul> -->
                    </div>
                  </div>

                  <div class="t4 clearfix tac">
                    <h3 class="tac">奖项细则</h3>
                    <div class="content">
                      <ul class="award_list">
                      @if(count($match->award))
                        @foreach($match->award as $av)
                        <li>
                          <h4 class="award_ranking">{{$av->name.$av->num}}名</h4>
                          <p>{{$av->detail}}</p>
                        </li>
                        @endforeach
                        @endif
                      </ul>

                      <br /> (注：奖金均为税前金额)
                    </div>
                  </div>

                  <div class="t5 clearfix">
                    <h3 class="tac">投稿要求</h3>
                    <div class="content">
                    @if($match->personal)
                      <h4 class="Mintac">个人投稿</h4>
                      <ul>
                        <li>
                          <span class="require_list">收费类型:</span><span class="require_content">
                          @if($match->personal->pay == 1)

                          每张/组收费
                          @elseif($match->personal->pay == 2)
                          报名费
                          @else
                          免费  
                          @endif

                          </span>
                        </li>
                        @if($match->personal->pay != 0)
                        <li>
                          <span class="require_list">单价:</span><span class="require_content">{{ $match->personal->price }} 人民币</span>
                        </li>
                        <li>
                          <span class="require_list">收费说明:</span><span class="require_content">{{$match->personal->pay_detail}}</span>
                        </li>
                        @endif
                       
                          @if($match->personal->pay == 1)
                          <!-- 仅限单张 -->
                        <li>
                          <span class="require_list">单张:</span><span class="require_content"> {{$match->personal->group_min}} 至 {{$match->personal->group_max}} 张</span>
                        </li>
                          @elseif($match->personal->pay == 2)
                          <!-- 仅限组图 -->
                        <li>
                          <span class="require_list">组图:</span><span class="require_content">{{$match->personal->group_min}} 至 {{$match->personal->group_max}} 组</span>
                        </li>
                        <li>
                          <span class="require_list">每组张数:</span><span class="require_content">{{$match->personal->num_min}} 至 {{$match->personal->num_max}} 张</span>
                        </li>
                          @else
                          <!-- 不限 -->
                        <li>
                          <span class="require_list">单张/组图:</span><span class="require_content">{{$match->personal->group_min}} 至 {{$match->personal->group_max}}</span>
                        </li>
                        <li>
                          <span class="require_list">每组张数:</span><span class="require_content">{{$match->personal->num_min}} 至 {{$match->personal->num_max}} 张</span>
                        </li>
                          @endif
                        <li>
                          <span class="require_list">图片大小:</span><span class="require_content">{{ $match->personal->size_min }} 至 {{ $match->personal->size_max }} MB</span>
                        </li>
                        <li>
                          <span class="require_list">最小边长:</span><span class="require_content">{{ $match->personal->length }} px</span>
                        </li>
                       <li>
                          <span class="require_list">补充说明:</span>
                          <div class="require_content bucong">
                            <p class="title">{{ $match->personal->introdution_title }}</p>
                            {!! str_replace(array("\r\n", "\r", "\n"), "<br/>", $match->personal->introdution_detail) !!}
                          </div>
                        </li>
                      </ul>
                      @endif
                      @if($match->team)
                      <h4 class="Mintac">团体投稿</h4>
                      <ul>
                        <li>
                          <span class="require_list">收费类型:</span><span class="require_content">
                          @if($match->team->pay == 1)

                          每张/组收费
                          @elseif($match->team->pay == 2)
                          报名费
                          @else
                          免费  
                          @endif

                          </span>
                        </li>
                        @if($match->team->pay != 0)
                        <li>
                          <span class="require_list">单价:</span><span class="require_content">{{ $match->team->price }} 人民币</span>
                        </li>
                        <li>
                          <span class="require_list">收费说明:</span><span class="require_content">{{$match->team->pay_detail}}</span>
                        </li>
                        @endif
                       
                          @if($match->team->pay == 1)
                          <!-- 仅限单张 -->
                        <li>
                          <span class="require_list">单张:</span><span class="require_content"> {{$match->team->group_min}} 至 {{$match->team->group_max}} 张</span>
                        </li>
                          @elseif($match->team->pay == 2)
                          <!-- 仅限组图 -->
                        <li>
                          <span class="require_list">组图:</span><span class="require_content">{{$match->team->group_min}} 至 {{$match->team->group_max}} 组</span>
                        </li>
                        <li>
                          <span class="require_list">每组张数:</span><span class="require_content">{{$match->team->num_min}} 至 {{$match->team->num_max}} 张</span>
                        </li>
                          @else
                          <!-- 不限 -->
                        <li>
                          <span class="require_list">单张/组图:</span><span class="require_content">{{$match->team->group_min}} 至 {{$match->team->group_max}}</span>
                        </li>
                        <li>
                          <span class="require_list">每组张数:</span><span class="require_content">{{$match->team->num_min}} 至 {{$match->team->num_max}} 张</span>
                        </li>
                          @endif
                        <li>
                          <span class="require_list">图片大小:</span><span class="require_content">{{ $match->team->size_min }} 至 {{ $match->team->size_max }} MB</span>
                        </li>
                        <li>
                          <span class="require_list">最小边长:</span><span class="require_content">{{ $match->team->length }} px</span>
                        </li>
                         <li>
                          <span class="require_list gundan">补充说明:</span>
                          <div class="require_content bucong">
                            <p class="title">{{ $match->team->introdution_title }}</p>
                            {!! str_replace(array("\r\n", "\r", "\n"), "<br/>", $match->team->introdution_detail) !!}
                        </div>
                        </li>
                      </ul>
                      @endif
                    </div>
                  </div>

                 
                  {{--

                      <div class="footer current tac" id="footer_page" style="display:none">
                            <!-- <a href="{{ url('admin/match/showedit/'.$id) }}" class="btn btn-default"> 还原</a> -->
                            <a href="{{ url('admin/match/edit/'.$id) }}" class="btn btn-default"> 返回编辑</a>
                            <button class="btn btn-default">保存 </button>
                            <a href="{{ url('admin/match/push_match/'.$id) }}" class="btn btn-default"> 发布比赛</a>
                        </div> 

                    --}}
                </div>
              </div>

              <!-- 侧边栏 -->
              <div class="col-sm-2 slide_contrains">
                <div class="slide">
                  <div class="slide_btn">
                    @if( $join )
                       <a class="btn" href="{{ url('match/uploadimg/'.$id) }}">继续投稿</a><br />
                    @else
                      <a class="btn" href="{{ url('match/statement/'.$id) }}">我要参赛</a><br />
                    @endif
                    <!-- <a class="btn" href=""> 上传中心</a> -->
                  </div>
                  <div class="slide_div">
                    <ul class="tac slide_ul">
                      <li class="current">大赛简介</li>
                       <li>组委会信息</li>
                      <li>评委&嘉宾</li>
                      <li>奖项细则</li>
                      <li>投稿要求</li>
                      <li class="back_li"><a href="#matchview"></a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- 侧边栏end -->
            </div>
          </div>
        </div>
      </main>

@endsection

@section('other_js')
    <script src="{{ url('js/admin/match/matchview.js')}}"></script> 
    <script>
        var arr = {!!$match->rater!!};
        var www = window.location.protocol+'//'+window.location.host+'/';
        if(arr.length<=5){
          var string = '';
          string+='<ul class="judges_ul clearfix">';
          for(let i=0;i<arr.length;i++){
            string+='<li class="tac"><img src="'+www+arr[i].pic+'" alt="" class="judge_img" />';
            string+='<p class="name">'+arr[i].name+'</p><p class="title" style="font-size:14px">'+arr[i].tag+'</p>';
            string+='<div class="cont_msg" style="display:none;word-wrap:break-word">'+arr[i].detail+'</div></li>';
          }
          string+='</ul>';
          $('.judge_list').append(string)
        }
         $('header').on('click','.pull-right.personal-center',function(){
      $(this).toggleClass('open')
    })
    </script>
@endsection