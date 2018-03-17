@extends('home.layout')   
@section('title', '资讯页')



@section('other_css')
    <link rel="stylesheet" href="{{ url('css/home/index/new.css') }}"/>
@endsection






@section('body')
<!--主内容-->
<section id="new">
    <div class="container">
        <div class="row text-center">
            <h2>{{$news->title}}</h2>
            <p class="title">{{$news->sec_title}}</p>
            <div style="background-color: rgb(255, 255, 255);">
            	 <?php echo $news->detail;?>

            </div>
        </div>
    </div>
</section>
@endsection





@section('other_js')
    
@endsection