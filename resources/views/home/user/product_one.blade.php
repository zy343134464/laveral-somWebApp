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
            <form role="form" action="{{ url('user/pic/'.$product->id) }}" method="post">
            {{ csrf_field() }}
            <div class="col-sm-12">
                    <div class="imgdetail-content clearfix">
                        <form role="form">
                        <div class="col-sm-4">
                            <div class="img">
                                <img src="{{ url($product->pic) }}" alt="">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="detail">
                                <div class="form-group">
                                    <label for="title">标题<span>*</span></label>
                                    <input type="text" class="form-control info-title" data-title="title" placeholder="标题" style="width:350px;" name="title" value="{{$product->title}}">
                                    <input type="hidden" id="imgdetailId" name="id[]" value="{{$product->id}}">
                                </div>
                                <div class="form-group">
                                    <label for="name">作者<span>*</span></label>
                                    <input type="text" class="form-control info-author" data-title="name" placeholder="标题" style="width:350px;" name="author"  value="{{$product->author}}">
                                </div>
                                <div class="form-group">
                                    <label for="describe">文字描述<span>*</span></label>
                                    <textarea class="form-control info-detail" data-title="detail" rows="4" placeholder="文字描述" style="width:700px;" name="detail" >{{$product->detail}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="apply">
                                <a class="btn btn-default" href="javascript:void(0)" id="copyInfoBtn">把本栏目信息应用到其他</a>
                            </div>
                        </div>
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
    <script>
    $(function() {
        // 把本栏目信息应用到其他
        $('#copyInfoBtn').on('click', function() {
            var _this = $(this);
            var parents = _this.parents('.imgdetail-content');
            var infoObj = parents.find('.form-control');
            var infoId = parents.find('#imgdetailId').val();
            var infoArr = [];
            for(var i=0; i<infoObj.length; i++) {
                var items = {title: infoObj.eq(i).attr('data-title'), value: infoObj.eq(i).val()};
                infoArr.push(items);
            }

            var imgConObj = $('.imgdetail-content');
            for(var i=0; i<imgConObj.length; i++) {
                var imgInfoObj = imgConObj.eq(i).find('.form-control');
                for(var j=0; j<imgInfoObj.length; j++) {
                    var imgTitle = imgInfoObj.eq(j).attr('data-title');
                    for(var k=0; k<infoArr.length; k++) {
                        if(infoArr[k].title === imgTitle) {
                            imgInfoObj.eq(j).val(infoArr[k].value);
                        }
                    }
                }
            }
        })
    })
    </script>
@endsection