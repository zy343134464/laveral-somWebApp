@extends('home.user.layout')   

@section('more_css')
<link rel="stylesheet" href="{{ url('css/swiper.min.css') }}"/>
<style>
    .rater-img2{
        border:1px solid #ccc;
        border-bottom:none;
    }
.group{
    width: 50%;
    position: relative;
    height: 50%;
    float: left;
}
.wrapperimg{
    height: 490px;
}
    .gallery-thumbs{
    height: 30%;
    box-sizing: border-box;
    padding: 10px 0;
}
.gallery-thumbs .swiper-slide {
    width: 25%;
    height: 100%;
}
.swiper-slide>img {
    max-width: 100%;
    max-height: 100%;
    /* position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto; */
}
.swiper-button-prev{
    background: none;
}
.swiper-button-next{
    background: none;
}
.continue_add {
    width: 114px;
    height: 40px;
    border-radius: 6px;
    background: #D0A45D;
    color: #fff;
    border: none;
    margin-right: 18px;
    outline: none;
}
.dialog2_button {
    position: absolute;
    bottom: -60px;
    left: 56%;
    margin-left: -193px;
}
.product .match-main > li{
    width:1060px;
    height:310px;
}
.h5{
    color:#999;
    height:50px;
    font-size:16px;
    line-height:50px;
    padding-left:20px;
    border-bottom:1px solid #E9E9E9;
}
.my_main{
    height:260px;
    line-height:170px;
    text-align: center;
}
</style>
@endsection

@section('body2')

<div class="personal-top">
    <!-- 还在征稿期就是 -->
   @if( $match->status == 3 )
    <a href="{{ url('match/uploadimg/'.$id) }}" class="submit-btn">继续投稿</a>
    @else
    <a href="#" class="btn btn-warning">截止投稿</a>
     @endif

</div>
<div class="product">
     
    <div class="row">
        <div class="col-sm-12">
            <ul class="match-main text-left clearfix rater-main">
                @if( count($product) )
                    @foreach($product as $v)
                        <li class="match-check-item" data-id="{{ $v->id }}">
                            <div class="match-img rater-img2" data-toggle="modal" data-target="#imgrater1" index="{{ $v->id }}">
                                <img src="{{ url($v->pic) }}" onerror="onerror=null;src='{{url('img/404.jpg')}}'" indexPic="{{ $v->pic }}">
                                @if( $v->status == 1 )
                                    <!-- 添加信息 -->
                                    <div class="edit-info-mask">
                                        <a href="{{ url('/user/pic/'.$v->id)}}" class="edit-info-btn">添加信息</a>
                                    </div>
                                @else
                                    <a href="javascript:imgShow({{ $v->id }})" class="match-check-mask">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endif
                            </div>
                            <p style="margin-left:10px;margin-top:4px;">作品标题:{{ mb_substr($v->title,0, 10,'UTF8') }} </p>
                            <p style="margin-left:10px;margin-top:4px;">作品作者:{{ mb_substr($v->author,0, 10,'UTF8') }} </p>
                            @if( $v->status != 3 )
                            <div class="footer">
                                <!-- <a href="javascript:imgDel({{ $v->id }})" class="del-btn"><i class="fa fa-close"></i></a> -->
                                <!-- <a href="{{ url('/user/pic/'.$v->id)}}" class="edit-btn"><i class="fa fa-edit"></i></a> -->
                            </div>
                            @endif
                        </li>
                    @endforeach
                             
                @else
                    <li>
                        <div style="color:red;margin-bottom:190px;">
                            <h5 class="h5">已投稿作品</h5>
                            <div class="my_main">
                            你已报名参加本次赛事，并有部分上传作品但未投稿任何作品
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
            <div class="page text-center">
                {{ $product->links() }}
                <!-- <ul class="pagination" style="margin-bottom:100px;">
                    <li><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul> -->
            
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imgrater1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal100">
        <div class="modal-content">
            <div class="modal-header" style="padding-left:66px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="$('#imgrater1').removeClass('in').hide()">&times;</button>
              
            </div>
            <div class="modal-body" style="padding-left:66px;">
                <ul class="clearfix">
                    <li class="wrapperimg">
                        <div class="img">
                           <!--  -->
                           <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="" alt="">
                                    </div>
                                </div>
                                <!-- <div class="swiper-button-next swiper-button-white"></div> -->
                                <!-- <div class="swiper-button-prev swiper-button-white"></div> -->
                            </div>
                            <div class="swiper-container gallery-thumbs">
                                <div class="swiper-wrapper">

                                    <div class="swiper-slide">
                                        <img src="" alt="">
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <span class="prev swiper-button-prev"><i class="fa fa-chevron-left"></i></span>
                            <span class="next swiper-button-next"><i class="fa fa-chevron-right"></i></span>
                        </div>
                        <div class="btnrater" match="" round="">
                           
                        </div>
                    </li>
                    <li class="wrapperinfro">
                        <ul>
                            <li style="padding-top:0;">
                                <span>编号</span>
                                <span class="imgId"></span>
                            </li>
                            <li>
                                <span>作品标题</span>
                                <span class="imgTitle"></span>
                            </li>
                            <li>
                                <span>文字描述</span>
                                <span class="imgDetail" style="width:300px;display:inline-block;vertical-align: top;"></span>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div><!-- /.modal-content -->
        <div class="dialog_button dialog2_button">
            <button type="button" class="continue_add prevButton">《 上一作品</button>
            <button type="button" class="continue_add nextButton">下一作品 》</button>
        </div>
    </div><!-- /.modal -->
</div>
@endsection

@section('other_js')
<script src="{{ url('js/swiper.min.js') }}"></script>
    <script>
   var solicit_end  = '{{ $match }}';
        // 组图的显示开始------------------------------------------------------------------------------------
            var www = window.location.protocol+'//'+window.location.host+'/';
            for(let i=0;i<$('.rater-img2').length;i++){
                // console.log($('.rater-img2'))
                if($('.rater-img2')[i].getElementsByTagName('img')[0].getAttribute('indexpic').indexOf('[')){  
                    $('.rater-img2')[i].getElementsByTagName('img')[0].src = www+$('.rater-img2')[i].getElementsByTagName('img')[0].getAttribute('indexpic');
                }else{
                    var arr = JSON.parse($('.rater-img2')[i].getElementsByTagName('img')[0].getAttribute('indexpic'));
                    $('.rater-img2')[i].innerHTML = '';
                    var imgs = '';
                    for(let j=0;j<arr.length;j++){
                        imgs +='<div class="group"><img src="'+www+arr[j]+'" alt=""></div>'
                    }
                    $('.rater-img2')[i].innerHTML = imgs;
                }
            }
// 组图的显示结束------------------------------------------------------------------------------------
//按顺序获取列表内的作品id
var Idarr = [];			//当前页面作品id数组
	for(let i=0;i<$('.match-img').length;i++){
        Idarr.push(parseInt($('.match-img')[i].getAttribute('index')))
	}
	var number = 0; 			//当前显示的作品索引
	var www = window.location.protocol+'//'+window.location.host+'/';
	var imgindex = '';
	var modelImg = $('.wrapperimg img');		//显示的img标签路径
	var ImgId = document.getElementsByClassName('imgId');				//显示的编号
	var imgTitle = document.getElementsByClassName('imgTitle');			//显示的作品标题
	var imgDetail = document.getElementsByClassName('imgDetail');		//显示的文字描述
	// 查看图片


	$('.rater-img2').on('click',function(){
		imgindex = $(this)[0].getAttribute('index'); 		//图片id
		// console.log(imgindex)
		number = Idarr.indexOf(parseInt(imgindex)); 			//当前显示的作品索引
		ajaxFunc(imgindex);							
	})
	//显示的内容
var ajax = function(id){	
// console.log('/user/match/img/'+id)	
	return $.ajax({
	            url:'/user/match/img/'+id,
	            type: 'get',
	            data: {
	            },
	            success: function(data){
	                data = JSON.parse(data);
					console.log(typeof data.pic)
	                if(typeof data.pic=='string'){	//判断单张还是组图
						$('.swiper-wrapper').html('');
						for(let i=0;i<$('.swiper-wrapper').length;i++){
							var dom = '';
							dom +='<div class="swiper-slide"><img src="'+www+data.pic+'" alt=""></div>';
							$('.swiper-wrapper')[i].innerHTML = dom;
						}
						for(let i=0;i<ImgId.length;i++){
							ImgId[i].innerHTML = data.id;
							imgTitle[i].innerHTML = data.title;
							imgDetail[i].innerHTML = data.detail;
						}
						
						
						// console.log(data.id,data.title,data.detail);
						// console.log(ImgId)
					}else{
						$('.swiper-wrapper').html('');
						for(let i=0;i<$('.swiper-wrapper').length;i++){
							var dom = '';
							for(let j=0;j<data.pic.length;j++){
								dom +='<div class="swiper-slide"><img src="'+www+data.pic[j]+'" alt=""></div>';
							}
							$('.swiper-wrapper')[i].innerHTML = dom;
						}
						// console.log(data.id,data.title,data.detail);
						for(let i=0;i<ImgId.length;i++){
							ImgId[i].innerHTML = data.id;
							imgTitle[i].innerHTML = data.title;
							imgDetail[i].innerHTML = data.detail;
						}
						// console.log(ImgId);
					}
	            }
	        })
}
	function ajaxFunc(imgindex){
		ajax(imgindex).then(function(){		//点击列表中的作品后自动渲染
			var galleryTop = new Swiper('.gallery-top', {
				nextButton: '.swiper-button-next',
				prevButton: '.swiper-button-prev',
				spaceBetween: 6,           //slide之间的距离（单位px）
				observer:true,
				observeParents:true,
				
			});
			var galleryThumbs = new Swiper('.gallery-thumbs', {
				spaceBetween: 6,
				centeredSlides: true,         //false无法使用
				slidesPerView: 'auto',        //设置slider容器能够同时显示的slides数量(carousel模式)。
				touchRatio: 0.2,              //触摸距离与slide滑动距离的比率。
				slideToClickedSlide: true,    //设置为true则点击slide会过渡到这个slide。
				observer:true,                //vue框架加入
				observeParents:true           //vue框架加入
			});
			galleryTop.params.control = galleryThumbs;
			galleryThumbs.params.control = galleryTop;
		})
	}
	$('.prevButton').on('click',function(){
		if(number>0){
			number--;
			ajaxFunc(Idarr[number]);	
		}
	})
	//下一个作品详情
	$('.nextButton').on('click',function(){
		if(number<Idarr.length-1){
			number++;
			ajaxFunc(Idarr[number]);		
		}
	})
	//--------------------------------------------------------------------------------------
        function imgShow(id) {
            // $('#imgrater1').show().addClass('in');
            
            // var modelImg = $('.wrapperimg img');        //显示的img标签路径
            // var ImgId = document.getElementsByClassName('imgId')[0];                //显示的编号
            // var imgTitle = document.getElementsByClassName('imgTitle')[0];          //显示的作品标题
            // var imgDetail = document.getElementsByClassName('imgDetail')[0];        //显示的文字描述
            
            // var num;     //点击的作品id在列表id数组中的索引
            // //按顺序获取列表内的作品id
            // var arrId = [];     //列表id数组
            // var id_arr = $('.match-main li');
            // for(let i=0;i<id_arr.length;i++){
            //     var iId = parseInt(id_arr.eq(i).attr('data-id'));
            //     arrId.push(iId);
            //     if(iId === id) {
            //         num = i;
            //     }
            // }

            // console.log(arrId.indexOf(imgId))        //点击的作品id在列表id数组中的索引
            // console.log(imgId)                       //点击的作品id
            // console.log(arrId)                       //列表的作品id数组

            //显示的内容
            
        //     var ajax = function(id){        
        //         return $.ajax({
        //             url:'/admin/match/img/'+id,
        //             type: 'get',
        //             data: {
        //             },
        //             success: function(data){
        //                 data = JSON.parse(data)
        // //                 console.log(data)
        //                 modelImg.attr('src','http://a.com/'+data.pic);
        //                 ImgId.innerHTML = data.id;
        //                 imgTitle.innerHTML = data.title;
        //                 imgDetail.innerHTML = data.detail;
        //             }
        //         })
        //     }
            // ajax(id)                         //点击列表中的作品后自动渲染

            //下一个作品详情
            // $('.next').unbind().on('click',function(){
            //     if(num<arrId.length-1){
            //         num++;
            //         ajax(arrId[num])
            //     }
            // })
            // //上一个作品详情
            // $('.prev').unbind().on('click',function(){
            //     if(num>=1){
            //         num--;
            //         ajax(arrId[num])
            //     }
            // })
        }

        // 删除作品
        function imgDel(id) {
            promptShow('作品管理', '如果你确认删除此作品，里面的内容将全部清空', function() {
                $.ajax({
                type: 'POST',
                url: '/user/del_pic',
                data: { id : id},
                dataType: 'json',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                     if(data[0]==1){
                        window.location.reload();
                    }
                },
                error: function(xhr, type){
                alert('Ajax error!')
                }
                });
            })
        }
        
    </script>
@endsection
