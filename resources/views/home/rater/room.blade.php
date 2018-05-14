@extends('home.rater.layout') 

@section('title', '评委室')

@section('other_css')
    <script src="{{ url('js/vue.js') }}"></script>
    <link rel="stylesheet" href="{{ url('css/home/rater/rater.css') }}"/>
    <link rel="stylesheet" href="{{ url('lib/commonLsf/css/commonLsf.css') }}"/>
    <style>
        .content{
            top:-2px;
        }
 
    </style>
@endsection


@section('body')

<!-- 主内容 -->
<section class="content" id="app">
    <div class="row clearfix">
        <div class="col-xs-12">
              <!--搜索框-->
             <form action="" >
                <div class="search-form">
                   <button class="btn btn-sm btn-default fa fa-search" style="margin-left:-10px;border:none;" type="submit"></button>
                   <input type="text" name="kw" placeholder="请输入手机或用户名" autocomplete="off">
                 </div>
            </form>
        </div>
        <div class="col-xs-12">
            
           <div class="col-xs-2" style="padding:0">
                <div class="matchtime">
                    <select class="form-control time" onchange="window.location=this.value">
                        <option name="type" value="all" >时间筛选</option>
                        <option name="type" value="0.25" {{ isset($_GET['time']) && $_GET['time'] == 0.25 ? 'selected' : ''  }}>一周内</option>
                        <option name="type" value="1" {{ isset($_GET['time']) && $_GET['time'] == 1 ? 'selected' : ''  }}>一个月内</option>
                        <option name="type" value="12" {{ isset($_GET['time']) && $_GET['time'] == 12 ? 'selected' : ''  }}>一年内</option>
                        <option name="type" value="out" {{ isset($_GET['time']) && $_GET['time'] == 'out' ? 'selected' : ''  }}>一年以上</option> 
                    </select>
                </div>
             </div> 
            
        </div>
        <div class="col-xs-12">
            <ul class="match-main text-left clearfix">
                <!--   foreach start -->
                @if( count($matches) )
                @foreach($matches as $v)
                <li>
                    <div class="match-img">
                        <a href="{{ url('rater/review/'.$v->id.'/'.$v->round) }}"><img src="{{ url($v->pic) }}"></a>
                    </div>
                    <div class="match-content">
                        <a href="{{ url('/match/detail/'.$v->id) }}"><h4>{{ (json_decode($v->title))[0]}}</h4></a>
                        <p>
                            赛事阶段: <span> 第{{ $v->round}}轮</span>
                        </p>
                        <p class="nostart" style="margin-top: 4px;">
                            评选状态: <span style="padding-right:40px;">
                             @if($v->mround < $v->round)
                            未开始
                            @elseif($v->mround == $v->round)
                            评审中 
                            @else
                            终审
                            @endif
                            </span>
                            <span>评审时间：<strong>{{date('Y-m-d', $v->rater_time($v->id, $v->round))}}</strong></span>
                            <span>
                                
                            </span>
                        </p>
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

<script>
    var app = new Vue({
			el: '#app',
			data: {
				tabs:['时间筛选','一个月内','三个月内','半年内','一年内','一年外'],
            }
    })
</script>
<script>
     $('header').on('click','.user.user-menu',function(){
       $(this).toggleClass('open');
    })
</script>
@endsection

@section('other_js')
    <script src="{{ url('lib/commonLsf/js/commonLsf.js') }}"></script>
    <script src="{{ url('js/home/rater/rater.js')}}"></script>
    <script>
         commonLsf.search_form(); //搜索
         url_change('time');
    </script>
@endsection