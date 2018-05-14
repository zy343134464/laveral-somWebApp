@extends('home.rater.layout')  
@section('title', '评委评审室')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/swiper.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('css/home/rater/rater.css') }}"/>
    <link rel="stylesheet" href="{{ url('lib/commonLsf/css/commonLsf.css') }}"/>
    <style>
      
        #imgrater2 .btnrater{
            padding-top: 20px;
            width: 400px;
            height: 320px;
        }
        #imgrater2 .btnrater>div{
            width:100%;
            height:100%;
        }
        #imgrater2 .btnrater>div>div{
            float:left;
            width:50%;
            height:50px;
            text-align: right;
            line-height:50px;
        }
        #imgrater2 .btnrater>div>div>input{
            line-height:normal;
            width:60px !important;
            height:40px;
            padding-left: 10px;
            border:1px solid #999999;
        }
        .works_message{
            height:150px;
        }
    </style>
@endsection


@section('body')

<!-- 主内容 -->
<section class="content"> 
    <div class="row clearfix" style="margin-top:20px">
       <!--  <div class="col-xs-12">
            搜索框
            <form action="1.php" >
               <div class="search-form">
                  <button class="btn btn-sm btn-default fa fa-search" style="margin-left:-10px;border:none;" type="submit"></button>
                  <input type="text" name="kw" placeholder="请输入手机或用户名" autocomplete="off">
                </div>
           </form>
       </div> -->
        
        <div class="col-xs-12 text-center"  style="margin-top:-30px;">
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

        <input type="hidden" class="number_times" value={{$round - 1}}>

        <div class="col-xs-12 text-center">
            <div class="rater-nav clearfix">
                <ul class="nav navbar-nav qwe">
                    @for($i=1;$i<$match->sum_round($match->id) + 1;$i++)
                    <li class="">
                        <a>第{{$i}}轮评审</a>
                        <div class="time" style="display:none;">
                            剩下:<span>{{ $time }}</span>
                            <span>　</span>
                        </div>
                    </li>
                    @endfor
                </ul>
                <!-- <div class="progress"></div> -->
                <!-- <div class="time" >
                    剩下:<span>2天 4:58</span>
                    <span>　</span>
                </div> -->
            </div>
        </div>
        <div class="col-xs-12 clearfix">
            @if($type == 1)
            <div class="col-xs-2" style="margin-left:-15px;">
                <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="?status=all" {{ isset($status)   ? '' :'selected' }}>全部作品</option>
                        <option value="?status=1" {{ @$status == '1' ? 'selected' :'' }}>入围 {{ $sum[1] }}</option>
                        <option value="?status=2" {{ @$status === '2' ? 'selected' :'' }}>淘汰 {{ $sum[2] }}</option>
                        <option  value="?status=3" {{ @$status === '3' ? 'selected' :'' }}>待定 {{ $sum[3] }}</option>
                        <option  value="?status=0" {{ @$status === '0' ? 'selected' :'' }}>未评 {{ $sum[0] }}</option>
                    </select>
                   
                </div>
            </div>
            @else
             <div class="col-xs-2" style="margin-left:-15px;">
                <div class="rater">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="?status=all" {{ isset($status)   ? '' :'selected' }}>全部作品</option>
                        <option value="?status=1" {{ @$status == '1' ? 'selected' :'' }}>已评 {{ $sum[1] }}</option>
                        <option value="?status=0" {{ @$status == '0' ? 'selected' :'' }}>未评 {{ $sum[0] }}</option>
                    </select>
                </div>
            </div>
            @endif
            <div class="col-xs-10 text-right" style="padding-top:10px;">

              <span style="display:{{ $type == 1 ? 'inline-block' :'none' }}" class="shenyu">  剩余票数 : <i>{{ $promotion - $sum[1] }}</i></span>  <!-- 剩余票数在投票的时候才会显示 -->
               <span style="padding:0 10px;" class="yiping"> 已评: <i>
                @if($type == 1) 
                    {{ $sum[1]+$sum[2]+$sum[3] }}
                @else
                    {{ $sum[1] }}
                @endif
                </i></span>
               <span  class="weiping"> 未评: <i>{{ $sum[0] }}</i></span>
            </div>
        </div>
        
        <div class="col-xs-12">
            <ul class="rater-main text-left clearfix">
                <!--   foreach start -->
                @if( count($pic) )
                @foreach($pic as $v)
                @if($type == 1)
                <li>
                    <div class="rater-img rater-img2" index="{{ $v->id }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                        <img src="" indexpic="{{ $v->pic }}">
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
                    <div class="rater-img rater-img2" index="{{ $v->id }}" data-toggle="modal" data-target="#imgrater{{$type}}">
                        <img src="" index="{{ $v->id }}"  indexpic="{{ $v->pic }}">
                    </div>
                    <div class="rater-content">
                        <h4>{{ $v->title}}</h4>
                        <div class="img-Id">{{ $v->id }}</div>
                    </div>
                    <div class="rater-btn text-center" index="{{ $v->id }}" match="{{ $match->id }}" round="{{$round}}" >
                        综合分:<span>{{ $v->rater_score_sum($match->id,@$round,$v->id) ?  $v->rater_score_sum($match->id,@$round,$v->id) / 100 : '未评分'}}</span>
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
                <div class="col-xs-10 text-right" style="padding-top:10px; text-align: left;">
                    剩余票数: <span style="padding-right:20px;" class="shenyu2">{{ $promotion - $sum[1] }}</span>  <!-- 剩余票数在投票的时候才会显示 -->
                    已评: <span style="padding-right:20px;" class="yiping2">
                    @if($type == 1) 
                    {{ $sum[1]+$sum[2]+$sum[3] }}
                    @else
                        {{ $sum[1] }}
                    @endif
                    </span>
                    未评: <span class="weiping2">{{ $sum[0] }}</span>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
              
            </div>
            <div class="modal-body" style="padding-left:66px;">
                <ul class="clearfix">
                    <li class="wrapperimg">
                        <div class="img">
                            <!-- <img src=""> -->
                            <!--  -->
                            <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="" alt="">
                                    </div>
                                </div>
                                <!-- <div class="swiper-button-next swiper-button-white"></div> -->
                                <!-- <div class="swiper-button-prev swiper-button-white"></div> -->
                            </div>
                            <div class="swiper-container gallery-thumbs">
                                <div class="swiper-wrapper">

                                    <div class="swiper-slide">
                                        <img src="" alt="">
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <span class="prev swiper-button-prev"><i class="fa fa-chevron-left"></i></span>
                            <span class="next swiper-button-next"><i class="fa fa-chevron-right"></i></span>
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
                                <span class="imgDetail" style="width:300px;display:inline-block;vertical-align: top;max-height:300px;min-height:50px;"></span>
                            </li>
                            <li >
                                <div class="btnrater rater-btn" match="{{ $match->id }}" round="{{ $round }}"  type="1">
                                    <button class="passbtn" value='1'>入围</button>
                                    <button class="whilebtn" value='3'>待定</button>
                                    <button class="outbtn" value='2'>淘汰</button>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="dialog_button dialog2_button">
                <button type="button" class="continue_add prevButton">《 上一作品</button>
                <button type="button" class="continue_add nextButton">下一作品 》</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->

</div>

<!-- 评委评分（Modal） -->
<div class="modal fade" id="imgrater2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal100">
        <div class="modal-content">
            <div class="modal-header" style="padding-left:30px;">
                  <div class="col-xs-10 text-right" style="padding-top:10px; text-align: left;">
                    最高：<span class="max_score" style="padding-right:20px;">{{ $tiptop / 100 }}</span>
                    最低：<span class="min_score" style="padding-right:20px;">{{ $lowest / 100 }}</span>
                    已评: <span style="padding-right:20px;">{{ $sum[1] }}</span>
                    未评: <span>{{ $sum[0] }}</span>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
              
            </div>
            <div class="modal-body" style="padding-left:66px;">
                <ul class="clearfix">
                    <li class="wrapperimg">
                         <div class="img">
                            <!-- <img src=""> -->
                            <!--  -->
                            <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="" alt="">
                                    </div>
                                </div>
                                <!-- <div class="swiper-button-next swiper-button-white"></div> -->
                                <!-- <div class="swiper-button-prev swiper-button-white"></div> -->
                            </div>
                            <div class="swiper-container gallery-thumbs">
                                <div class="swiper-wrapper">

                                    <div class="swiper-slide">
                                        <img src="" alt="">
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <span class="prev swiper-button-prev"><i class="fa fa-chevron-left"></i></span>
                            <span class="next swiper-button-next"><i class="fa fa-chevron-right"></i></span>
                        </div>
                        
                    </li>
                    <li class="wrapperinfro">
                        <ul>
                            <div class="works_message">
                                <li style="padding-top:0;">
                                    <span>编号</span>
                                    <span class="imgId" index=""></span>
                                </li>
                                <li>
                                    <span>作品标题</span>
                                    <span class="imgTitle"></span>
                                </li>
                                <li style="">
                                    <span>文字描述</span>
                                    <span class="imgDetail" style="width:300px;display:inline-block;vertical-align: top;max-height:300px;min-height:50px;">
                                    
                                    </span>
                                </li>
                            </div>
                            <li class="dimensionality_list">
                                <div class="btnrater" match="{{ $match->id }}" round="{{ $round }}" type="2">
                                    <div class="dimensionality_data">
                                    @if($type == 2)
                                    @foreach((json_decode($review->setting,true))['dimension'] as $rk=>$rv)

                                        <div><span title="{{$rv}}" style="cursor:pointer;">{{$rv}}</span>: <input type="number" class="score_input"
                                        min="{{(json_decode($review->setting))->min }}" 
                                        max="{{ (json_decode($review->setting))->max }}" 
                                        ratio="{{ ((json_decode($review->setting,true)))['percent'][$rk] }}" style="width:40px;margin:5px 4px"></div>
                                    @endforeach
                                    <div style="width:100%;text-align: left;"><span style="color:red;text-align: right;">*</span><span>评分区间在{{(json_decode($review->setting))->min }}到{{ (json_decode($review->setting))->max }}之间</span></div>
                                    @endif
                                    </div>
                                    <!-- <div class="text-right" style="margin-top:10px;">
                                        <a class="btn btn-warning sure">确认</a>
                                    </div> -->
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="dialog_button dialog2_button">
                <button type="button" class="continue_add prevButton">《 上一作品</button>
                <button type="button" class="continue_add nextButton">下一作品 》</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
  
</div>
@endsection

@section('other_js')
<script src="{{ url('js/swiper.min.js') }}"></script>
    <script>
        
        for(let i=0;i<parseInt('{{$round}}');i++){
            $('.qwe li').eq(i).addClass('on');
        }
   //-------------------------------------------------------------------------------------------------------------------     
        var max = $('.max_score');                           //最高分节点
        var min = $('.min_score');                           //最低分节点
       function ajaxShow(id,round){                                //当前显示的维度分数ajax
        return $.ajax({
                url:'/rater/rater_pic/'+id,
                type: 'get',
                data: {
                    "round": ""+round+"",                    //轮次
                },
                success: function(data){
                    console.log(data)
                    if(data){
                        if(data.score!=null){
                            for(let i=0;i<$('.dimensionality_data').find('input').length;i++){
                                $('.dimensionality_data').find('input').eq(i).val(data.score['p'+i])
                            }
                        }else{
                            for(let i=0;i<$('.dimensionality_data').find('input').length;i++){
                                $('.dimensionality_data').find('input').eq(i).val('')
                            }
                        }
                        
                    }  
                }
            })
       }
        function ajaxFunc(worksId,type,round,matchId,arr){          //分数上传ajax
         return $.ajax({
                    url:'/rater/pic',
                    type: 'post',
                    data: {
                        "id": ""+worksId+"",                     //作品id
                        "type": ""+type+"",                      //评分类别
                        "round": ""+round+"",                    //轮次
                        "match_id": ""+matchId+"",               //赛事id
                        "res": ""+JSON.stringify(arr)+""        //维度分数数组
                    },
                    success: function(data){
                        console.log(JSON.parse(data))
                        if(JSON.parse(data).data){
                            var synthetical = 0;                                 //综合分
                            for(let i=0;i<$('.dimensionality_data').find('input').length;i++){
                                if($('.dimensionality_data').find('input').eq(i).val()!=''){
                                    synthetical +=parseInt($('.dimensionality_data').find('input').eq(i).val())*parseInt($('.dimensionality_data').find('input').eq(i).attr('ratio'))/100;
                                }else{
                                    synthetical +=0;
                                }
                            }
                            if($('.max_score').text()==0&&$('.min_score').text()==0){   //第一个评分的作品
                                max.text(synthetical);
                                min.text(synthetical);
                            }else if(synthetical>parseInt(max.text())){       //最高分
                                max.text(synthetical);
                            }else if(synthetical<parseInt(min.text())){     //最低分
                                min.text(synthetical);
                            }
                            for(let j=0;j<$('.img-Id').length;j++){         //修改页面作品的综合分
                                if($('.img-Id').eq(j).text()==worksId){
                                    $('.img-Id').eq(j).parent().next().find('span').text(synthetical);
                                }
                            }
                        }else{
                            alert(JSON.parse(data).msg)
                        }
                    }
                })
        }
        $('.rater-main').on('click','.rater-img',function(){                 //点击显示模态框的内容
            var showId = $(this).next().find('.img-Id').text();              //当前显示的作品id
            $('.btnrater').eq(0).attr('index',showId)
            var round = $('.btnrater').eq(1).attr('round');     //当前轮次
            var idList = [];
            for(let i=0;i<$('.img-Id').length;i++){                          //获取当前作品列表的id
                idList.push($('.img-Id').eq(i).text());
            }
            var index = idList.indexOf(showId);                              //当前作品在作品列表中的索引
            if('{{ $type }}'==1){   //投票
                var tankuanBtn = $('.btnrater').eq(0);                      //弹框中的按钮
                var showBtn = $(this).next().next().find('button');         //页面上的按钮
                for(let i=0;i<showBtn.length;i++){
                    if(showBtn.eq(i).hasClass('active')){
                        tankuanBtn.find('button').removeClass('active');
                        for(let j=0;j<tankuanBtn.find('button').length;j++){
                            if(tankuanBtn.find('button').eq(j).val()==showBtn.eq(i).val()){
                                tankuanBtn.find('button').eq(j).addClass('active');
                            }
                        }
                    }
                }
            }else{                  //评分
                ajaxShow(showId,round);
            }
            //上个作品并保存分数
            document.getElementsByClassName('prevButton')[1].onclick = function(){
                var worksId = $('.imgId').eq(1).text();             //当前作品id
                var type = $('.btnrater').eq(1).attr('type');       //当前评分类别
                var round = $('.btnrater').eq(1).attr('round');     //当前轮次
                var matchId = $('.btnrater').eq(1).attr('match');   //当前赛事id
                var arr = [];                                       //维度分数数组
                
                for(let i=0;i<$('.dimensionality_data').find('input').length;i++){
                    if($('.dimensionality_data').find('input').eq(i).val()==''){
                        alert('有未填维度分数！');
                        arr.length = 0;
                        return false;
                    }else{
                        arr.push($('.dimensionality_data').find('input').eq(i).val());
                    }
                }
                if(index>=1){
                    index--;
                    ajaxFunc(worksId,type,round,matchId,arr).then(function(){
                        ajaxShow(idList[index],round);
                    })
                    
                }else{
                    ajaxFunc(worksId,type,round,matchId,arr);
                }
            }
            //下个作品并保存分数
            document.getElementsByClassName('nextButton')[1].onclick = function(){
                var worksId = $('.imgId').eq(1).text();             //当前作品id
                var type = $('.btnrater').eq(1).attr('type');       //当前评分类别
                var round = $('.btnrater').eq(1).attr('round');     //当前轮次
                var matchId = $('.btnrater').eq(1).attr('match');   //当前赛事id
                var arr = [];                                       //维度分数数组
                
                for(let i=0;i<$('.dimensionality_data').find('input').length;i++){
                    if($('.dimensionality_data').find('input').eq(i).val()==''){
                        alert('有未填维度分数！');
                        arr.length = 0;
                        return false;
                    }else{
                        arr.push($('.dimensionality_data').find('input').eq(i).val());
                    }
                }
                console.log(index,idList.length)
                if(idList.length-1>index){
                    index++;
                    ajaxFunc(worksId,type,round,matchId,arr).then(function(){
                        ajaxShow(idList[index],round);
                    })
                }else{
                    ajaxFunc(worksId,type,round,matchId,arr);
                }
            }
            var Btn_list = [];
            if('{{ $type }}'==1){           //投票时获取页面按钮状态数组
                for(let i=0;i<$('.rater-btn').length-1;i++){
                    if($('.rater-btn').eq(i).find('button').eq(0).hasClass('active')){
                        var Btn_val = $('.rater-btn').eq(i).find('button').eq(0).val();
                        Btn_list.push(Btn_val);
                    }else if($('.rater-btn').eq(i).find('button').eq(1).hasClass('active')){
                        var Btn_val = $('.rater-btn').eq(i).find('button').eq(1).val();
                        Btn_list.push(Btn_val);
                    }else if($('.rater-btn').eq(i).find('button').eq(2).hasClass('active')){
                        var Btn_val = $('.rater-btn').eq(i).find('button').eq(2).val();
                        Btn_list.push(Btn_val);
                    }else{
                        Btn_list.push('');
                    }
                }
                // console.log(Btn_list,showId,idList)
            }
            var numbers = idList.indexOf(showId);
            document.getElementsByClassName('nextButton')[0].onclick = function(){          //投票下一个作品按钮点击事件
                // $('.btnrater').eq(0).attr('index',worksId);
                // console.log(worksId)
                tankuanBtn.find('button').removeClass('active');
                if(numbers<idList.length-1){
                    numbers++;
                    $('.btnrater').eq(0).attr('index',idList[numbers]);
                    if(Btn_list[numbers]!=''){
                        for(let i=0;i<$('.btnrater').eq(0).find('button').length;i++){
                            if($('.btnrater').eq(0).find('button').eq(i).val()==Btn_list[numbers]){
                                $('.btnrater').eq(0).find('button').eq(i).addClass('active');
                            }
                        }
                    }else{
                        tankuanBtn.find('button').removeClass('active');
                    }
                }
            }
            document.getElementsByClassName('prevButton')[0].onclick = function(){          //投票上一个作品按钮点击事件
                tankuanBtn.find('button').removeClass('active');
                if(numbers>=1){
                    numbers--;
                    $('.btnrater').eq(0).attr('index',idList[numbers]);
                    if(Btn_list[numbers]!=''){
                        for(let i=0;i<$('.btnrater').eq(0).find('button').length;i++){
                            if($('.btnrater').eq(0).find('button').eq(i).val()==Btn_list[numbers]){
                                $('.btnrater').eq(0).find('button').eq(i).addClass('active');
                            }
                        }
                    }else{
                        tankuanBtn.find('button').removeClass('active');
                    }
                }
            }   
        })
//-------------------------------------------------------------------------------------------------------------------     
    </script>
    
    <script src="{{ url('lib/commonLsf/js/commonLsf.js') }}"></script>
    <script src="{{ url('js/home/rater/rater.js')}}"></script>
    <script>
           $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
           $(function(){
             
               var setting = "{{$review->setting}}";
               var type = "{{$type}}",tip='{{ $tip }}',url = window.location.href;
              
               if(tip && !(url.indexOf("status") >= 0)){  //判断是否是第一次进入当前页面
                    commonLsf.layerFunc({title:'评审说明',msg:tip,closeBtn:1});
               } ;

                commonLsf.search_form(); //搜索
                 
           })
           
           
            
    </script>
    
@endsection