@extends('admin.layout')

@section('other_css')
    <link rel="stylesheet" href="{{ url('css/admin/match/matchcreate.css') }}">

    <link rel="stylesheet" href="{{url('css/home/user/cropper.css')}}">
    <link rel="stylesheet" href="{{url('css/home/user/capture-16-9.css')}}">
@endsection


@section('body')
<!-- 新建比赛导航 -->
<div class="match-nav">
    <div class="collapse navbar-collapse" id="matchcreate">
        <ul class="nav navbar-nav">
            @if(isset($id))
                @if(match($id,'cat') == 0)
                <li class="active"><a href="{{ url ('admin/match/edit/'.$id) }}">赛事主题</a></li>
                <li><a href="{{ url('admin/match/partner/'.$id) }}">组委会信息</a></li>
                <li><a href="{{ url('admin/match/rater/'.$id) }}">评委/嘉宾</a></li>
                <li><a href="{{ url('admin/match/award/'.$id) }}">奖项设置</a></li>
                <li><a href="{{ url('admin/match/require_personal/'.$id) }}">投稿要求</a></li>
                <li><a href="{{ url('admin/match/review/'.$id) }}">评选设定</a></li>
                @endif
                @if(match($id,'cat') == 1)
                <li class="active"><a href="{{ url ('admin/match/edit/'.$id) }}">赛事主题</a></li>
                <li><a href="{{ url('admin/match/partner/'.$id) }}">组委会信息</a></li>
                <li><a href="{{ url('admin/match/rater/'.$id) }}">评委/嘉宾</a></li>
                <li><a href="{{ url('admin/match/award/'.$id) }}">奖项设置</a></li>
                <li><a href="{{ url('admin/match/require_personal/'.$id) }}">投稿要求</a></li>
                <li><a href="{{ url('admin/match/son/'.$id) }}">综合赛事编辑</a></li>

                @endif
                @if(match($id,'cat') == 2)
                <li class="active"><a href="{{ url ('admin/match/edit/'.$id) }}">赛事主题</a></li>
                <li><a href="{{ url('admin/match/review/'.$id) }}">评选设定</a></li>
                <li><a href="{{ url('admin/match/son/'.match($id,'pid')) }}">返回</a></li>
                @endif
                
            @else
                @if(@$_GET['pid'])
                    <li class="active"><a >赛事主题</a></li>
                    <li><a >评选设定</a></li>
                    <li><a href="{{ url('admin/match/son/'.$_GET['pid']) }}">返回</a></li>
                @else

                    <li class="active"><a href="#">赛事主题</a></li>
                    <li><a href="#">组委会信息</a></li>
                    <li><a href="#">评委/嘉宾</a></li>
                    <li><a href="#">奖项设置</a></li>
                    <li><a href="#">投稿要求</a></li>
                    @if(@$type != 1)
                    <li><a href="#">评选设定</a></li>
                    @endif
                @endif
            @endif
        </ul>
    </div>
</div>
 <div class="pop-mask" style="display: none;"></div>
    <div id="popCapture" class="pop-capture pop-info" style="display: none;">
        <a href="javascript:void:void(0)" class="pop-close pop-hide"></a>
        <h1 class="capture-title">上传头像</h1>
        <!-- Content -->
        <div class="capture-container">
            <div class="capture-info">
                <!-- <h3>Demo:</h3> -->
                <div class="img-container">
                    <img src="" id="image" alt="">
                    <label id="upload" for="inputImage">点击添加图片<br>只支持JPG、PNG、GIF，大小不超过2M</label>
                </div>

                <div class="manage-btn-box">
                    <label class="manage-btn btn-upload" for="inputImage">重新上传</label>
                    <a href="javascript:void(0)" class="manage-btn btn-plus">＋</a>
                    <a href="javascript:void(0)" class="manage-btn btn-minus">－</a>
                </div>
                <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
            </div>
            <div class="capture-show">
                <!-- <h3>Preview:</h3> -->
                <div class="docs-preview clearfix">
                    <div class="img-preview preview-lg"></div>
                </div>
                <p class="preview-title">头像预览</p>
                <a href="javascript:void(0)" class="capture-btn btn-confirm">确定</a>
                <a href="javascript:void(0)" class="capture-btn btn-cancel pop-hide">取消</a>
            </div>
        </div>
    </div>
<!-- 新建比赛内容 -->
@section('body2')

@show

@endsection

@section('other_js')
    <script src="{{ url('js/admin/match/matchcreate.js')}}"></script>
    <script>        
        $('.navbar-nav li a').each(function(){
            if($($(this))[0].href==String(window.location)){
                $(this).parent().parent().find('li').removeClass('active')
                $(this).parent().addClass('active');
            }
        });
        function popShow(id) {
            $('.pop-mask').show();
            $('#'+id).show();
        }
    </script>

    <script src="{{url('js/cropper.js')}}"></script>
    <script src="{{url('js/jquery-cropper.js')}}"></script>
    <script src="{{url('js/home/capture/capture-16-9.js')}}"></script>
@endsection
