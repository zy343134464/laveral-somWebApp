@extends('home.layout')   


@section('other_css')
	<link rel="stylesheet" href="{{url('css/AdminLTE.min.css')}}">
	<link rel="stylesheet" href="{{url('css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{url('css/home/user/personalcenter.css')}}">
        
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="{{url('css/home/user/cropper.css')}}">
    <link rel="stylesheet" href="{{url('css/home/user/capture.css')}}">
@section('more_css')

@show
@endsection

@section('body')
	<header id="users">
	    <div class="users-intro text-center">
	        <h4>
	            <img src="{{url(user('pic'))}}" style="width: 100px;height: 100px;border-radius:50%;" onclick="popShow('popCapture')">
	        </h4>
	        <p>{{ user('name')}}</p>
	    </div>
	</header>
	<section id="personal">
    <div class="container">
        <div class="row">
            <div class="col-xs-2">
                <div class="personal-tabs">
                    <ul class="personalUl text-center">
                        <li>
                            <a href="{{ url('user/match') }}">我的赛事</a>
                        </li>
                        <li>
                            <a href="{{ url('user/award') }}">获奖记录</a>
                        </li>
                        <li>
                            <a href="{{ url('user/info') }}">个人信息</a>
                        </li>
                        <li>
                            <a href="{{ url('user/organ') }}">机构资料</a>
                        </li>
                        <li>
                            <a href="{{ url('user/consumes') }}">消费记录</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-xs-10">
				@section('body2')
			            
			    @show
            </div>
        </div>
    </div>
    <!-- 图片上传弹窗 -->
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

    <!-- 提示弹窗 -->
    <div id="popPrompt" class="pop-prompt fade">
        <h1 class="prompt-title"></h1>
        <p class="prompt-text"></p>
        <div class="prompt-btn">
            <a href="javascript:void(0)" class="btn-succeed">确定</a>
            <a href="javascript:$('#popPrompt').hide().removeClass('in'); $('.pop-mask').hide()" class="btn-close">取消</a>
        </div>

        <a href="javascript:$('#popPrompt').hide().removeClass('in'); $('.pop-mask').hide()" class="pop-close">&times;</a>
    </div>

</section>

<script>
    window.onload = function(){
        $('.personalUl li a').each(function(){
            if($($(this))[0].href==String(window.location)){
                $(this).parent().parent().find('li').removeClass('active')
                $(this).parent().addClass('active');
            }
        });  
    }

    function popShow(id) {
        $('.pop-mask').show();
        $('#'+id).show().addClass('in');
    }

    function promptShow(title, text, fun) {
        var promptObj = $('#popPrompt');
        if(title) {
            promptObj.find('.prompt-title').html(title)
        }
        if(text) {
            promptObj.find('.prompt-text').html(text)
        }
        if(fun && typeof fun === 'function') {
            promptObj.find('.prompt-btn').show();
            promptObj.find('.prompt-btn .btn-succeed').unbind().bind('click', fun);
        } else {
            promptObj.find('.prompt-btn').hide();
        }
        popShow('popPrompt');
    }
</script>

@endsection

@section('other_js')
    <script src="{{url('lib/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script src="{{url('lib/fastclick/lib/fastclick.js')}}"></script>
	<script src="{{url('js/adminlte.min.js')}}"></script>
	<script src="{{url('js/demo.js')}}"></script>
	
    <script src="{{url('js/cropper.js')}}"></script>
    <script src="{{url('js/jquery-cropper.js')}}"></script>
    <script src="{{url('js/home/capture/capture-user.js?a=a')}}"></script>
@endsection
