@extends('home.layout')   
@section('title', '赛事预览')

@section('other_css')
    <link rel="stylesheet" href="{{ url('lib/commonLsf/css/commonLsf.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/admin/match/matchview.css') }}"/>
@endsection

@section('body')

<!-- 赛事预览 -->
      <main id="matchview" class="main_matchview"  data-spy="scroll" data-target="#navbar">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">

             <div class="col-sm-10">
                <!--广告图-->
                <div class="detail_banner">
                  <img src="{{ url($match->pic) }}" alt="" width="1095"/>
                </div>
                <div class="detail_cont">
                  <!--标题-->
                  <h2 class="tac">{{json_decode($match->title)[0]}}</h2>

                  <div class="t1 clearfix"  id="intro">
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

                  <div class="t2 clearfix tac zuweihui"  id="organizing_committee">
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

                            <span class="contact">{{ $av->type }} : {{ $av->value }}</span><br>
                             @endforeach
                             @endif
                          </li>
                        </ul>

                      </div>
                  </div>

                  <div class="t3 clearfix" id="distinguished_guest">
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

                 @if( count ( $match->son) )
                   <div class="t4 clearfix tac" id="son_Match">
                    <h3 class="tac">赛事简介</h3>
                    <div class="content">
                      <ul class="Event_Info_ul">
                        @foreach($match->son as $svalue)
                        <li class="Event_Info_li">
                          <img src="{{ url($svalue->pic) }}" alt="" class="li-img">
                          <p class="title">{{json_decode($svalue->title)[0]}}</p>
                          <p>类别 : <span class="type">{{$svalue->type}}</span></p>
                          <p class="msg" style="display:none">{{$svalue->detail}}</p>
                          <!-- <div class="Event_Info_div">
                            <img src="{{ url($match->pic) }}" alt="">
                            <div class="Event_Info_r">
                                <p class="title">子赛事类别</p>
                                <p>类别 : <span class="type">风景</span></p>
                                <div class="Event_Info_msg">
                                  子赛事类别子赛事类别子赛事类别子赛事类别子赛事类别子赛事类别子赛事类别子赛事类别子赛事类别子赛事类别子赛事类别子赛事类别
                                </div>
                            </div>
                          </div> -->
                        </li>
                         @endforeach
                      </ul>
                    </div>
                  </div>
                  @endif


                  <div class="t5 clearfix tac" id="awards_rule">
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
                       (注：奖金均为税前金额)
                    </div>
                  </div>

                  <div class="t6 clearfix" id="contribute_demand">
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
                  
                  <div class="footer current tac" id="footer_page">
                           <!--  <a href="{{ url('admin/match/showedit/'.$id) }}" class="btn btn-default"> 还原</a> -->
                            <a href="{{ url('admin/match/edit/'.$id) }}" class="btn btn-default"> 返回编辑</a>
                            <!-- <button class="btn btn-default">保存 </button> -->
                            <a href="{{ url('admin/match/push_match/'.$id) }}" class="btn btn-default issue"> 发布比赛</a>
                    </div>
                
              </div>
              </div>
              
              <!-- 侧边栏 -->
              <div class="col-sm-2 slide_contrains" id="scrollspy">
                <div class="slide">
                <div class="slide_btn">
                    @if( $match->status>4 )
                      <button class="btn slideBtn">我要参赛</button>
                    @else
                      <a class="btn" href="{{ url('match/statement/'.$id) }}">我要参赛</a><br />
                    @endif 
                                                         
                    <!-- <a class="btn" href=""> 上传中心</a> -->
                  </div>
                 <div class="slide_div" id="navbar">
                    <ul class="tac slide_ul nav" role="tablist">
                      <li class=""><a href="#intro">大赛简介</a></li>
                       <li><a href="#organizing_committee">组委会信息</a></li>
                      <li><a href="#distinguished_guest">评委&嘉宾</a></li>
                        @if( count ( $match->son) )
                      <li><a href="#son_Match">赛事简介</a></li>
                      @endif
                      <li><a href="#awards_rule">奖项细则</a></li>
                      <li><a href="#contribute_demand">投稿要求</a></li>
                      <li class="back_li"><a href="javascript:;" onclick="scroll_Top()"></a></li>
                    </ul>
                  </div>
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
     <script src="{{ url('lib/bootstrap/js/scrollspy.js') }}"></script>
     <script src="{{ url('lib/commonLsf/js/commonLsf.js') }}"></script>
    <script>
    $('#scrollspy').on('click','.slideBtn',function(){
      commonLsf.layerFunc({title:'提示',msg:'当前赛事不是征稿期'})
    })
    setTimeout(function(){
       $('#navbar li').removeClass('active');
     },10)
   
        var arr = {!!$match->rater!!};
        function scroll_Top(){
         $('body,html').animate(
            {scrollTop: '0px'},500);
        }

          $('#scrollspy').DynamicScrollspy({
            genIDs: true,
            testing: false
            
          });


		var arr = {!!$match->rater!!};
		var www = window.location.protocol+'//'+window.location.host+'/';
		if(arr.length<=5){
			var string = '';
			string+='<ul class="judges_ul clearfix">';
			for(let i=0;i<arr.length;i++){
			string+='<li class="tac"><img src="'+www+arr[i].pic+'" alt="" class="judge_img" />';
			string+='<p class="name">'+arr[i].name+'</p><p class="title" style="font-size:14px">'+arr[i].tag+'</p>';
			string+='<div class="cont_msg" style="display:none;word-wrap:break-word;">'+arr[i].detail+'</div><span class="role" style="display:none">评委</span></li>';
			}
			string+='</ul>';
			$('.judge_list').append(string);
		}else{
      console.log(arr.length)
      var string = '';
      for(let j=0;j<Math.ceil(arr.length/5);j++){
        string+='<ul class="judges_ul clearfix">';
        for(let i=(j*5);i<(j*5+5);i++){
              if(arr[i]){
              string+='<li class="tac"><img src="'+www+arr[i].pic+'" alt="" class="judge_img" />';
              string+='<p class="name">'+arr[i].name+'</p><p class="title" style="font-size:14px">'+arr[i].tag+'</p>';
              string+='<div class="cont_msg" style="display:none;word-wrap:break-word">'+arr[i].detail+'</div><span class="role" style="display:none">'+(arr[i].type == '1' ? '评委' : '嘉宾')+'</span></li>';
              }
        }
        string+='</ul>';
      }
      $('.judge_list').append(string);
    }
    $('header').on('click','.pull-right.personal-center',function(){
      $(this).toggleClass('open')
    })
    
    
    $('.issue').click(function(){
      var time2 = Date.parse("{{ date('Y-m-d H:i',$match->collect_start) }}");  //征稿开始时间
      console.log("{{ date('Y-m-d H:i',$match->collect_start) }}")
      var time = new Date();                                                    //当前时间
      // console.log(parseInt(time2)<parseInt(Date.parse(time)))
      if({{ $match->status }}==0){                                               //未发布状态
        if(parseInt(time2)<parseInt(Date.parse(time))){                           //当前时间超过征稿时间
          alert('当前时间超过征稿时间!');
          return false;
        }
      }
      // return false;
    })
	</script>
@endsection