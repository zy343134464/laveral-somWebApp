@extends('home.layout')   
@section('title', '上传中心')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/home/uploadcenter/synthesize.css') }}"/>
@endsection


@section('body')
<!-- 上传中心 -->
<main id="imgdetail">
    <div class="container">
        <div class="row">
         
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