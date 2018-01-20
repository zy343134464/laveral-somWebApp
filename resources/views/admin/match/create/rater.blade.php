@extends('admin.match.create.layout')
@section('title', '评委/嘉宾')

@section('body2')
<div class="match-guest">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">评委</a></li>
			<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">嘉宾</a></li>
		</ul>
		<div class="content">
			<ul class="judgelist">
				<li class="addjudge">
					<a href="{{ url('admin/match/addrater/'.$id) }}">
						<div class="add-button">+</div>
						<p>添加评委</p>
					</a>
				</li>
                
                @if(count($rater))
                @foreach($rater as $v)
				<li>
					<a href="#">
						<div class="judge-img">
							<img src="{{ url('img/images/som-judge1.jpg') }}" alt="">
                            <div class="close"><i class="fa fa-close"></i></div>
						</div>
						 <div class="judge-content text-left">
                            <h4>{{ $v->name}}</h4>
                            <p>{{ $v->tag}}</p>
                            <p>{{ $v->detail}}</p>
                        </div>
                        <div class="footer">
                            <div class="views">
                                <i class="fa fa-eye"></i>
                                <span>25000</span>
                            </div>
                            <div class="users">
                                <i class="fa fa-user"></i>
                                <span>4800</span>
                            </div>
                            <div class="images">
                                <i class="fa fa-image"></i>
                                <span>3256</span>
                            </div>
                        </div>
					</a>
				</li>
                @endforeach
                @endif
			</ul>
		</div>
		<div class="nextPage">
			<a href="{{ url('admin/match/guest/'.$id) }}" class="btn btn-default">下一页</a>
		</div>
	
</div>
@endsection