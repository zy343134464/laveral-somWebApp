@extends('admin.layout')
@if(isset($status))
    @if(@$status == 0)
        @section('title', '筹备中比赛')
    @elseif(@$status == 6)
        @section('title', '历史赛事')
    @else
        @section('title', '进行中比赛')
    @endif
@else
    @section('title', '进行中比赛')
@endif

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/match/matchingblock.css') }}"/>
     <link rel="stylesheet" href="{{ url('lib/commonLsf/css/commonLsf.css') }}"/>
@endsection


@section('body')
<!-- 进行中比赛豆腐块 -->

<!-- 头部 -->

<!-- 主内容 -->
<section class="content">
    <div class="row clearfix">
        <form>
            <div class="search-form">
               <button class="btn btn-sm btn-default fa fa-search" style="margin-left:-10px;border:none;"></button>
               <input type="text" name="kw" placeholder="请输入手机或用户名">
             </div>
        </form>
        <div class="col-xs-12">
        	<div class="col-xs-1" style="margin:0 30px 0 -15px;">
                <div class="matchkind">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="?cat=all{{ isset($_GET['status']) ? '&status='.$_GET['status'] : '' }}" {{ isset($cat)   ? '' :'selected' }}>全部赛事</option>
                        <option value="?cat=1{{ isset($_GET['status']) ? '&status='.$_GET['status'] : '' }}" {{ $cat == 1 ? 'selected' :'' }}>综合赛事</option>
                        <option value="?cat=0{{ isset($_GET['status']) ? '&status='.$_GET['status'] : '' }}" {{ $cat === '0' ? 'selected' :'' }}>单项赛事</option>
                    </select>
                </div>
            </div>
            @if(!isset($status) || $status == 3 || $status == 5)
              <!-- 判断是进行中赛事 -->
            <div class="col-xs-1" style="">
                <div class="matchkind">
                    <select class="form-control"  onchange="window.location=this.value">
                        <option value="?status=all{{ isset($_GET['cat']) ? '&cat='.$_GET['cat'] : '' }}" {{ isset($status)   ? '' :'selected' }}>全部阶段</option>
                        <option value="?status=3{{ isset($_GET['cat']) ? '&cat='.$_GET['cat'] : '' }}" {{ $status == 3 ? 'selected' :'' }}>征稿中</option>
                        <option value="?status=5{{ isset($_GET['cat']) ? '&cat='.$_GET['cat'] : '' }}" {{ $status === 5 ? 'selected' :'' }}>评审中</option>
                    </select>
                </div>
            </div>
            @endif
            @if(isset($status) && $status == 6)
            <!-- 判断是历史赛事 -->
            <div class="col-xs-2" style="padding:0">
                <div class="matchtime">
                    <select class="form-control time" onchange="window.location=this.value">
                        <option  value="all" {{ isset($_GET[ 'time']) && $_GET[ 'time']== 'all' ? 'selected' : ''}}>时间筛选</option>
                        <option   value="0.25" {{ isset($_GET[ 'time']) && $_GET[ 'time']== '0.25' ? 'selected' : ''}}>一周内</option>
                        <option  value="1" {{ isset($_GET[ 'time']) && $_GET[ 'time']== '1' ? 'selected' : ''}}>一个月内</option>
                        <option   value="12" {{ isset($_GET[ 'time']) && $_GET[ 'time']== '12' ? 'selected' : ''}}>一年内</option>
                        <option  value="out" {{ isset($_GET[ 'time']) && $_GET[ 'time']== 'out' ? 'selected' : ''}}>一年以上</option> 
                    </select>
                </div>
             </div> 
            @endif
            <!--批量导出-->
            @if(!isset($status) || $status != 0  )
            <!-- 判断是否是筹备中赛事 -->
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
            <div class="col-xs-3 pull-right" style="padding-right:15px">
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
        <div class="col-xs-12" style="padding:0 0 0 15px;">
            <ul class="match-main text-left clearfix" >
                <!--   foreach start -->
                @if( count($matches) )
                @foreach($matches as $v)
                <li>
                    <div class="match-img">
                        <a href="{{ url('admin/match/showedit/'.$v->id) }}"><img src="{{ show_pic($v->pic) }}"></a>
                    </div>
                    <div class="match-content">
                         <a href="{{ url('/match/detail/'.$v->id) }}"><h4>{{ (json_decode($v->title))[0]}}</h4></a>
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
                        @if($v->cat != 1)
                        <span>
                            <a href="{{ url('admin/match/match_pic_pdf/'.$v->id)}}" title="导出" style="display:inline-block;width:22px;height:22px;background:url({{ url('img/exportIcon.png') }}) 0px 3px no-repeat;background-size: 22px 22px;"></a>
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
                        @endif
                        @if($status == 6)
                        <span>
                            <a href="{{ url('admin/match/copy/'.$v->id) }}"><i class="fa fa-copy"  title="复制"></i></a>
                        </span>
                        @else
                        <span>
                            <a href="{{ url('admin/match/review_room/'.$v->id) }}" target="_blank" title="评审室">评</a>
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
                           {{-- <a href="{{ url('admin/match/del/'.$v->id) }}"><i class="fa fa-times"  title="删除"></i></a> --}}
                            <a href="javascript:void(0)" onclick="show_confirm(this)" data-id="{{$v->id}}" ><i class="fa fa-times"></i></a>
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
         <div class="paging text-center">
        {{ $matches->appends(['kw' => $kw,'status'=>$status])->links() }}
    </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
   
</section>
<!-- /.content -->


@endsection

@section('other_js')
    <script src="{{ url('lib/commonLsf/js/commonLsf.js') }}"></script>
    <script src="{{ url('js/admin/match/matchingblock.js')}}"></script>
    <script>
         commonLsf.search_form(); //搜索
            //删除提示
     function show_confirm(e){
            var www = window.location.protocol+'//'+window.location.host;
             commonLsf.layerFunc({title:'提示',msg:"确认删除吗"},function(flag){
                if(flag){
                     // console.log(e.getAttribute('data-id'))
                   window.location.href =www+'/admin/match/del/'+e.getAttribute('data-id')
                } 
            });
            
          }


          // 获取url？之后的值
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

    function url_change(ele){  //给select下拉框跳转
        if($('.'+ele).find( 'option')){
            for(let i=0;i<$('.'+ele).find( 'option').length;i++){
                var number = $('.'+ele).find( 'option').eq(i).val();
                var url_num = window.location.search;
                if(url_num == ''|| url_num ==null || url_num ==undefined ){
                  $('.'+ele).find( 'option').eq(i).val( 'http://'+ window.location.host+ window.location.pathname+'?'+ele+'='+number);
                //    console.log( document.getElementsByClassName(ele)[0].getElementsByTagName('option')[i].value);
                }else{
                    $('.'+ele).find( 'option').eq(i).val(  changeURLArg(window.location.href,ele,number));
                }
                
            }
    }
}

url_change('time');
//左侧移动效果--------------------------------------
window.onscroll = function(){
		var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
		// console.log(scrollTop)
		document.getElementsByClassName('sidebar')[0].style.paddingTop = (scrollTop+20)+'px';
	}
    </script>

@endsection