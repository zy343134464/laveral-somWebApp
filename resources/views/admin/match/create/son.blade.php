@extends('admin.match.create.layout')
@section('title', '综合赛事编辑')

@section('body2')
<div class="match-guest" id="synthesize_match_son">
	
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
				<a href="{{ url('admin/match/create/2?pid='.$id) }}">
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
						<img src="{{ url($v->pic)}}" class="rater-img">
					</div>
          <div class="judge-content text-left">
            <h4 class="name">{{json_decode($v->title)[0]}}</h4>
            <p class="tag">{{ $v->tag}}</p>
            <p class="detail" style="display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;overflow: hidden;">{{ mb_substr($v->detail,0,30)}}</p>
           
          </div>
          <div class="judge-edit">
            <a href="{{ url('admin/match/edit/'.$v->id)}}" class="btn" style="right:76px;"><i class="fa fa-edit"></i></a>
            <a href="{{ url('admin/match/copy_son/'.$v->id)}}" class="btn" style="right:36px;"><i class="fa fa-copy"></i></a>
            <a href="{{ url('admin/match/del/'.$v->id)}}" class="btn" style="right:0px;"><i class="fa fa-close"></i></a>
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
