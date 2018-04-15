@extends('home.layout')   
@section('title', '赛事声明')

@section('other_css')
    <script src="{{ url('js/vue.js') }}"></script>
    <link rel="stylesheet" href="{{ url('css/home/uploadcenter/statement.css') }}"/>
@endsection


@section('body')
<!-- 上传中心 -->
<div id="app">
    <div class="container">
      <div class="row">
          <div class="col-sm-12">
            <!-- 顶部进展 -->
            <div class="body_top">
              <ul>
                <li>
                  <i class="top_num">1</i>
                  <span>阅读声明</span>
                </li>
                <li>
                  <i class="top_num">2</i>
                  <i class="top_border"></i>
                  <span>报名表单</span>
                </li>
                <li>
                  <i class="top_num">3</i>
                  <i class="top_border"></i>
                  <span>上传作品</span>
                </li>
                <li>
                  <i class="top_num">4</i>
                  <i class="top_border"></i>
                  <span>支付</span>
                </li>
              </ul>
            </div>
            <!-- 主体 -->
            <div class="main">
              <div class="statement layer-cont">
                <h5>赛事声明</h5>
                 
                <div class="statement-content" >
                  <p>
                    @if(count($match->personal)) 
                     {!! str_replace(array("\r\n", "\r", "\n"), "<br/>", mb_substr($match->personal->notice,0,500)) !!}
                    @endif
                  </p>
                </div>
                <div class="statement-div">
                  <div class="checkbox"> <input type="checkbox" class="layer-check-input"> 我已阅读本次赛事声明</div>
                  <div class="statement-btn"> <a class="layer-btn" disabled="disabled">同意声明</a> </div>
                </div>
              </div>

            </div>
           
          </div>
      </div>
    </div>
</div> 

@endsection

@section('other_js')
<script>
  $(function(){
     $('.body_top li:first-child').addClass('mainCourse');
    var _url = '{{ url('match/form/'.$id) }}';
     $('.statement').on('click','input[type="checkbox"]',function(){
        if($(this).is(':checked')){
            $('.statement .layer-btn').addClass('current').attr("href",_url);
           }else{
          $('.statement .layer-btn').removeClass('current').removeAttr("href");
        }
      }) 
  }) 

</script>
@endsection