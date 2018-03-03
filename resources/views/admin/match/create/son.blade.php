@extends('admin.match.create.layout')
@section('title', '评委/嘉宾')

@section('body2')
<div class="match-guest">
	
	<div class="content">
		<ul class="judgelist">
    <li>
        <a href="">
          <div class="judge-img">
            <img src="{{ url($match->pic)}}"  index="{{$match->pic}}" class="rater-img">
                        <a href="{{ url('admin/match/delrater/'.$match->id)}}"><div class="close"><i class="fa fa-close"></i></div></a>
          </div>
          <div class="judge-content text-left">
            <h4 class="name">{{json_decode($match->title)[0]}}</h4><br>
            <p class="detail" style="display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;overflow: hidden;">{{ $match->detail}}</p>
            <p>征稿期: 
                                @if($match->collect_start)
                                {{ date('Y-m-d',$match->collect_start)}}
                                @else
                                未设置
                                @endif
                            -
                                @if($match->collect_end)
                                {{ date('Y-m-d',$match->collect_end)}}
                                @else
                                未设置
                                @endif
           </p>
          </div>
          
        </a>
      </li>
			<li class="addjudge">
				<a href="{{ url('admin/match/findrater/'.$id) }}">
					<div class="add-button">+</div>
					<p>添加子赛事</p>
				</a>
			</li>
      <br>
            @if(count($son))
            @foreach($son as $v)
			<li>
        <a href="">
					<div class="judge-img">
						<img src="{{ url($v->pic)}}"  index="{{$v->pic}}" class="rater-img">
                        <a href="{{ url('admin/match/delrater/'.$v->id)}}"><div class="close"><i class="fa fa-close"></i></div></a>
					</div>
          <div class="judge-content text-left">
            <h4 class="name">{{json_decode($v->title)[0]}}</h4>
            <p class="tag">{{ $v->tag}}</p>
            <p class="detail" style="display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;overflow: hidden;">{{ mb_substr($v->detail,0,30)}}</p>
            <p>征稿期: 
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
           </p>
          </div>
          <div class="judge-edit">
            <a href="{{ url('admin/match/edit/'.$v->id)}}" class="btn editraterBtn" ><i class="fa fa-edit"></i></a>
          </div>
        </a>
			</li>
            @endforeach
            @endif
		</ul>
	</div>
	
	<div class="nextPage">
		<a href="{{ url('admin/match/showedit/'.$id) }}" class="btn btn-default">预览</a>
	</div>
	
</div>
@endsection
