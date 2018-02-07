@extends('home.layout')   
@section('title', '上传中心')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/home/uploadcenter/uploadimg.css') }}"/>
@endsection


@section('body')
<!-- 上传中心 -->
<main id="imgdetail">
    <div class="container">
        <div class="row">
            <form role="form" action="{{ url('match/doeditimg/'.@$id) }}" method="post">
            {{ csrf_field() }}
                <div class="col-sm-12">
                    <div class="imgdetail-content clearfix">
                        <form role="form">
                        <div class="col-sm-4">
                            <div class="img">
                                <img src="{{ url(@$pic->pic) }}" alt="">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="detail">
                                <div class="form-group">
                                    <label for="title">标题<span>*</span></label>
                                    <input type="text" class="form-control" id="title" placeholder="标题" style="width:350px;" name="title" value="{{@$pic->title}}">
                                </div>
                                <div class="form-group">
                                    <label for="name">作者<span>*</span></label>
                                    <input type="text" class="form-control" id="name" placeholder="标题" style="width:350px;" name="author"  value="{{@$pic->author}}">
                                </div>
                                <div class="form-group">
                                    <label for="describe">文字描述<span>*</span></label>
                                    <textarea class="form-control" id="describe" rows="4" placeholder="文字描述" style="width:700px;" name="detail" >{{@$pic->detail}}</textarea>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-sm-12">
                            <div class="apply">
                                <a class="btn btn-default" href="#">把本栏目信息应用到其他</a>
                            </div>
                        </div> -->
                    </div>
                    <div class="nextPage">
                        <a class="btn btn-default" href="#">返回</a>
                        <input type="submit" class="btn btn-default" value="保存">
                    </div>
                </div>
            </form>
        </div>
    </div>
</main> 

@endsection

@section('other_js')
    <script src="{{ url('js/home/uploadcenter/uploadimg.js')}}"></script>
@endsection