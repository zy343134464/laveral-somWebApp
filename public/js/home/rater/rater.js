function layerFunc(json,func){ //弹出层
		var flag;
		var layerTpl = ' <div class="alert alert-danger alert-dismissible layer_alert fade in" role="alert">'+
'        <div class="alert_div">'+
'          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+
'            '+
'              <h4>'+json.title+'</h4>'+
'              <div class="alert-cont">'+
'                  <p>'+json.msg+'</p>'+
'                  <p>'+
'                    <button type="button" class="btn btn-danger" data-dismiss="alert" aria-label="Close" data-status="true">确定</button>'+
'<button type="button" class="btn btn-default" style="margin-left:10px;"  data-dismiss="alert" aria-label="Close" data-status="false">取消</button>'+
'                  </p>'+
'               </div>'+
'            </div>'+
'        </div>';
    $('body').append(layerTpl);

		$('body').on('click','.layer_alert button',function(){
			 flag = $(this).data('status');
			  if(func){
			    	func(flag);
			    }
		})
	};
$(function(){
	 $('.textbutton').click(function(){
	 	var ulId = this.parentNode.nextSibling.nextSibling.getElementsByTagName('ul')[0]
	 	var we = this.parentNode.nextSibling.nextSibling;
	 	var showneir = this.parentNode.getElementsByClassName('testeli')[0];
	 	var zuopinId = this.parentNode.getElementsByClassName('img-Id')[0].innerHTML;
		var arrId = [];
		for(let i=0;i<=ulId.getElementsByTagName('li').length-1;i++){
				ulId.getElementsByTagName('li')[i].className = '';
				if(showneir.innerHTML==ulId.getElementsByTagName('li')[i].innerHTML){
					ulId.getElementsByTagName('li')[i].className = 'color';
				}
			}	
	 	ulId.onclick = function(e){
	 		var target = e.target;
	 		var num_data = parseInt(target.getAttribute("data-id"));
	 		
	 		if(target.className!='color'){
	 			arrId.push(num_data);
	 			target.className = 'color';
	 		}else{
				arrId.pop(num_data);
				target.className = '';
			 }
	 	}
	 	
	 	this.parentNode.nextSibling.nextSibling.getElementsByClassName('sure')[0].onclick = function(){
	 			we.style.display = 'none';
	 			var string1 = '';
	 			for(let i=0;i<ulId.getElementsByTagName('li').length;i++){
	 				if(ulId.getElementsByTagName('li')[i].className == 'color'){
	 					string1 += ulId.getElementsByTagName('li')[i].innerHTML;
	 				}
	 			}
	 			showneir.innerHTML = string1;
	 			
	 			$.ajax({
					url:'/admin/match/edit_win_ajax',
					type: 'post',
					dataType: 'json',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
					},
					data: {
						production_id : parseInt(zuopinId),
						win_id : arrId
						
					},
					success: function(data){
						console.log(data)
						data = JSON.parse(data)
					}
				})
				
	 	}
	 })

	// 根据赛事进度给第几轮显示时间
	var timeNum = $('.number_of_times').text();
	$('.num_times li').eq(parseInt(timeNum)).find('.time').show();

	
	$('.on').eq($('.number_times').val()).find('.time').show();

	//左侧移动效果
	window.onscroll = function(){
		var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
		// console.log(scrollTop)
		document.getElementsByClassName('sidebar')[0].style.paddingTop = (scrollTop+20)+'px';
	}
	//赛事进度方法
	var num_time = parseInt($('.number_of_times').text());
	for(let i=0;i<=num_time;i++){
		$('.num_times li')[i].className = 'on';				
	}
	
	
	
/*管理员编辑赛果*/
$('.edit-btn').on('click','button',function(){
		var raterbtn = $(this).parent();
		var raterbtnMatch = raterbtn.attr('match');
		var raterbtnRound = raterbtn.attr('round');
		var btnValue = $(this).attr('value');
		var imgId = raterbtn.attr('index');;
		console.log(imgId)
		var _this = $(this);

		$.ajax({
			url:'/admin/match/badboy',
			type: 'post',
			data: {
				"id": ""+imgId+"",
				"value": ""+btnValue+"",
				"round": ""+raterbtnRound+"",
				"match_id": ""+raterbtnMatch+""
			},
			success: function(data){
				data = JSON.parse(data)
				if (data.data) {
					_this.parent().find('button').removeClass('active');
					_this.addClass('active');
				};
			}
		})
	})
/*评委评审室首页*/
	
	/*切换按钮颜色*/
	/*$('.rater-btn').on('click','button',function(){
		$(this).parent().find('button').removeClass('active')
		$(this).addClass('active')
	})
*/
	var lock;				//是否入围
	var identical;        
	$('.rater-btn').on('click','button',function(){
		
		var raterbtn = $(this).parent();				//获取父级节点
		var raterbtnMatch = raterbtn.attr('match');		//获取自定义match属性值
		var raterbtnRound = raterbtn.attr('round');		//获取自定义round属性值
		var btnValue = $(this).attr('value');			//获取按钮值
		var imgId = $(this).parent().prev().find('.img-Id').text();		//获取该作品的id

		
		identical = imgId;							//将点击的作品替换之前的作品
		var _this = $(this);
		
		var commented = document.getElementsByClassName('text-right')[0].getElementsByTagName('span')[0];		//获取已评的节点
		var No_comment = document.getElementsByClassName('text-right')[0].getElementsByTagName('span')[1];		//获取未评的节点
		
		if(raterbtn.find('button').hasClass('active')){
			var state1 = raterbtn[0].getElementsByClassName('active')[0].value;		//获取按钮改变前状态
			lock = state1==1?true:false;			//作品入围为true，否则false
		}else{
			if($(this).val()==1){
				commented.innerHTML = parseInt(commented.innerHTML)+1;
				No_comment.innerHTML = parseInt(No_comment.innerHTML)-1;
			}
		}
		

		

		var ajax = function(){
			return $.ajax({
				url:'/rater/pic',
				type: 'post',
				data: {
					"id": ""+imgId+"",
					"value": ""+btnValue+"",
					"round": ""+raterbtnRound+"",
					"match_id": ""+raterbtnMatch+""
				},
				success: function(data){
					data = JSON.parse(data)
					// console.log(data)
					if (data.data) {
						_this.parent().find('button').removeClass('active');
						_this.addClass('active');
					};
				}
			})
		}
		ajax().then(function(){
			if(raterbtn.find('button').hasClass('active')){
				var state2 = raterbtn[0].getElementsByClassName('active')[0].value;			//获取按钮改变后状态
					if(state1!=state2&&btnValue==1){
						commented.innerHTML = parseInt(commented.innerHTML)+1;
						No_comment.innerHTML = parseInt(No_comment.innerHTML)-1;
						lock=true;
					}else if(state1!=state2&&btnValue!=1&&lock==true){					//是否点击的不是同一个按钮而且没入围
						commented.innerHTML = parseInt(commented.innerHTML)-1;
						No_comment.innerHTML = parseInt(No_comment.innerHTML)+1;
						lock=false;
					}else if(state1!=state2&&btnValue!=1&&lock==true){
						commented.innerHTML = parseInt(commented.innerHTML)-1;
						No_comment.innerHTML = parseInt(No_comment.innerHTML)+1;
						lock=false;
					}
			}
		})
	})

/*评委评审室比赛列表*/
	//  评委查看图片
	$('.rater-main').on('click','.rater-img',function(){
    
		var imgSrc = $(this).find('img').attr('src');		//获取点击图片路径
		var modelImg = $('.wrapperimg').find('img');		//显示的img标签
		var btnrater = $('.btnrater button').removeClass('active')
		
		modelImg.attr('src',imgSrc);						//修改显示的img标签路径

		//点击作品替换显示详情的分数
		if($('.score_input')[0]){
			var btnactive = $(this).next().next();
			var now_num = parseInt(btnactive.text().substr(btnactive.text().indexOf(':')+1))
			if(now_num){
				$('.score_input')[0].value = now_num;
			}else{
				$('.score_input')[0].value = '';
			}
		}
		
		// var passbtnactive = btnactive.find('.passbtn').hasClass("active");
		// var whilebtnactive = btnactive.find('.whilebtn').hasClass("active");
		// var outbtnactive = btnactive.find('.outbtn').hasClass("active");
		// if (passbtnactive) {
		// 	$('.btnrater .passbtn').addClass('active')
		// 	$('.btnrater .whilebtn').removeClass('active')
		// 	$('.btnrater .outbtn').removeClass('active')
		// };
		// if (whilebtnactive) {
		// 	$('.btnrater .whilebtn').addClass('active')
		// 	$('.btnrater .passbtn').removeClass('active')
		// 	$('.btnrater .outbtn').removeClass('active')
		// };
		// if (outbtnactive) {
		// 	$('.btnrater .whilebtn').removeClass('active')
		// 	$('.btnrater .passbtn').removeClass('active')
		// 	$('.btnrater .outbtn').addClass('active')
		// };

		//按顺序获取列表内的作品id
		var arrId = [];		//id数组
		var id_arr = $('.rater-main li .img-Id');
		for(var i=0;i<id_arr.length;i++){
			arrId.push(id_arr[i].innerHTML)
		}
		
		// 获取图片信息
		var imgId = $(this).next().find('.img-Id').text();		//图片id

		$.ajax({
		  url: '/rater/rater_pic/'+imgId,
		  method: 'get',
		  success: function(data){
			  var oData = data.data;
			  console.log(data)
			picInfro(oData)
		  }
		})

		function picInfro(oData){
			var imgId = $('.wrapperinfro').find('.imgId');
			imgId.text(""+oData.id+"")

			var imgTitle = $('.wrapperinfro').find('.imgTitle');
			imgTitle.text(""+oData.title+"")

			var imgDetail = $('.wrapperinfro').find('.imgDetail');
			imgDetail.text(""+oData.detail+"")
		}

		var _this = $(this);
		var index = $(this).parent().index();				//获取当前li在ul中的索引
		var lengthLi = $(this).parent().parent().find('li').length;		//获取li的个数
		
		$('.next').on('click',function(){
			if (index ===(lengthLi-1)) {		//当点击的到最后一个li时不在往下运行
				return
			};
			index++;							//li索引自增
			var nextImgSrc = _this.parent().parent().find('li').eq(index).find('img').attr('src');		//获取下一个作品的图片路径
			modelImg.attr('src','');			//清空显示详情的路径
			modelImg.attr('src',nextImgSrc);	//替换路径
			var imgId = _this.parent().parent().find('li').eq(index).find('.img-Id').text();			//获取下一个作品的id
			var btnactive = _this.parent().parent().find('li').eq(index).find('.rater-btn');			//获取下一个作品的分数节点
			// var passbtnactive = btnactive.find('.passbtn').hasClass("active");						//搜索下一个作品的类名为passbtn有无类名active
			//点击下一个作品替换显示详情的分数
			var next_num = parseInt(btnactive.text().substr(btnactive.text().indexOf(':')+1));
			if($('.score_input')[0]){
				if(next_num){
					$('.score_input')[0].value = next_num;
				}else{
					$('.score_input')[0].value = '';
				}
			}
			// var whilebtnactive = btnactive.find('.whilebtn').hasClass("active");
			// console.log('123',btnactive.find('.whilebtn'))
			// var outbtnactive = btnactive.find('.outbtn').hasClass("active");
			// if (passbtnactive) {
			// 	$('.btnrater .passbtn').addClass('active')
			// 	$('.btnrater .whilebtn').removeClass('active')
			// 	$('.btnrater .outbtn').removeClass('active')
			// };
			// if (whilebtnactive) {
			// 	$('.btnrater .whilebtn').addClass('active')
			// 	$('.btnrater .passbtn').removeClass('active')
			// 	$('.btnrater .outbtn').removeClass('active')
			// };
			// if (outbtnactive) {
			// 	$('.btnrater .whilebtn').removeClass('active')
			// 	$('.btnrater .passbtn').removeClass('active')
			// 	$('.btnrater .outbtn').addClass('active')
			// };
			// console.log(btnactive)

			// console.log(imgId)
			$.ajax({
			  url: '/rater/rater_pic/'+imgId,
			  method: 'get',
			  success: function(data){
				  var oData = data.data;
				picInfro(oData)
			  }
			})
			function picInfro(oData){
				var imgId = $('.wrapperinfro').find('.imgId');
				imgId.text(""+oData.id+"")

				var imgTitle = $('.wrapperinfro').find('.imgTitle');
				imgTitle.text(""+oData.title+"")

				var imgDetail = $('.wrapperinfro').find('.imgDetail');
				imgDetail.text(""+oData.detail+"")
			}
		})

		$('.prev').on('click',function(){
			if (index ===(0)) {
				return
			};
			index--;
			var prevImgSrc = _this.parent().parent().find('li').eq(index).find('img').attr('src');
			modelImg.attr('src','');
			modelImg.attr('src',prevImgSrc);

			var imgId = _this.parent().parent().find('li').eq(index).find('.img-Id').text();
			var btnactive = _this.parent().parent().find('li').eq(index).find('.rater-btn');
			//点击上一个作品替换显示详情的分数
			var prev_num = parseInt(btnactive.text().substr(btnactive.text().indexOf(':')+1));
			if($('.score_input')[0]){
				if(prev_num){
					$('.score_input')[0].value = prev_num;
				}else{
					$('.score_input')[0].value = '';
				}
			}
			// var passbtnactive = btnactive.find('.passbtn').hasClass("active");
			// var whilebtnactive = btnactive.find('.whilebtn').hasClass("active");
			// var outbtnactive = btnactive.find('.outbtn').hasClass("active");
			// if (passbtnactive) {
			// 	$('.btnrater .passbtn').addClass('active')
			// 	$('.btnrater .whilebtn').removeClass('active')
			// 	$('.btnrater .outbtn').removeClass('active')
			// };
			// if (whilebtnactive) {
			// 	$('.btnrater .whilebtn').addClass('active')
			// 	$('.btnrater .passbtn').removeClass('active')
			// 	$('.btnrater .outbtn').removeClass('active')
			// };
			// if (outbtnactive) {
			// 	$('.btnrater .whilebtn').removeClass('active')
			// 	$('.btnrater .passbtn').removeClass('active')
			// 	$('.btnrater .outbtn').addClass('active')
			// };
			// console.log(imgId)
			$.ajax({
			  url: '/rater/rater_pic/'+imgId,
			  method: 'get',
			  success: function(data){
				  var oData = data.data;
				picInfro(oData)
			  }
			})
			function picInfro(oData){
				var imgId = $('.wrapperinfro').find('.imgId');
				imgId.text(""+oData.id+"")

				var imgTitle = $('.wrapperinfro').find('.imgTitle');
				imgTitle.text(""+oData.title+"")

				var imgDetail = $('.wrapperinfro').find('.imgDetail');
				imgDetail.text(""+oData.detail+"")
			}
		})

		$('.btnrater').on('click','button',function(){
			var raterbtn = $(this).parent();
			var raterbtnMatch = raterbtn.attr('match');
			var raterbtnRound = raterbtn.attr('round');
			var btnValue = $(this).attr('value');
			var imgId1 = _this.parent().parent().find('li').eq(index).find('.img-Id').text();
			var _this1 = $(this)
			var _this2 = _this.parent().parent().find('li').eq(index).find('.rater-btn');

			$.ajax({
				url:'/rater/pic',
				type: 'post',
				data: {
					"id": ""+imgId1+"",
					"value": ""+btnValue+"",
					"round": ""+raterbtnRound+"",
					"match_id": ""+raterbtnMatch+""
				},
				success: function(data){
					data = JSON.parse(data)
					if (data.data) {
						_this1.parent().find('button').removeClass('active');
						_this1.addClass('active');
						_this2.find('button').removeClass('active');
						_this2.find('button').eq(_this1.index()).addClass('active');
						console.log(data.msg);
					};
				}
			})

			console.log(raterbtnMatch,raterbtnRound,imgId1,btnValue)
			if (index ===(lengthLi-1)) {
				return
			};
			index++;
			var nextImgSrc = _this.parent().parent().find('li').eq(index).find('img').attr('src');
			modelImg.attr('src','');
			modelImg.attr('src',nextImgSrc);

			var imgId = _this.parent().parent().find('li').eq(index).find('.img-Id').text();

			$.ajax({
			  url: '/rater/rater_pic/'+imgId,
			  method: 'get',
			  success: function(data){
				  var oData = data.data;
				picInfro(oData)
			  }
			})
			function picInfro(oData){
				var imgId = $('.wrapperinfro').find('.imgId');
				imgId.text(""+oData.id+"")

				var imgTitle = $('.wrapperinfro').find('.imgTitle');
				imgTitle.text(""+oData.title+"")

				var imgDetail = $('.wrapperinfro').find('.imgDetail');
				imgDetail.text(""+oData.detail+"")
			}

		   
		})

		/*评委评分确认*/
		$('.btnrater').on('click','.sure',function(){
				var raterbtn = $(this).parent().parent();
				var raterbtnMatch = raterbtn.attr('match');
				var raterbtnRound = raterbtn.attr('round');
				var btnType = raterbtn.attr('type');
				var btnValue = $('.score_input');
				var imgId1 = _this.parent().parent().find('li').eq(index).find('.img-Id').text();
				var arr = [];
				var showId = $(this).parent().parent().parent().next()[0].getElementsByTagName('ul')[0].getElementsByTagName('li')[0].getElementsByTagName('span')[1].innerHTML;
				//显示的id
				
				// btnValue.val()
				
				//确认后改变页面的分数
				for(let i=0;i<$('.rater-main .img-Id').length;i++){
					if($('.rater-main .img-Id')[i].innerHTML==showId){
						$('.rater-main .img-Id')[i].parentNode.nextSibling.nextSibling.innerHTML = '综合分:'+btnValue.val();
					}
				}
				for(var i=0 ;i<btnValue.length;i++){
					arr[i] = btnValue.eq(i).val()
				}
				
				// console.log(raterbtnMatch,raterbtnRound,btnType,JSON.stringify(arr))

				$.ajax({
					url:'/rater/pic',
					type: 'post',
					data: {
						"id": ""+imgId1+"",
						"type": ""+btnType+"",
						"round": ""+raterbtnRound+"",
						"match_id": ""+raterbtnMatch+"",
						"res": ""+JSON.stringify(arr)+""
					},
					success: function(data){
						// console.log(data);
					}
				})
		   })

	})



	//按顺序获取列表内的作品id
	var Idarr = [];			//当前页面作品id数组
	for(let i=0;i<$('.rater-main li').length;i++){
		Idarr.push(parseInt($('.rater-main li')[i].getElementsByClassName('img-Id')[0].innerHTML))
	}
	var number = 0; 			//当前显示的作品索引
	var www = window.location.protocol+'//'+window.location.host+'/';
	var imgindex = '';
	var modelImg = $('.wrapperimg img');		//显示的img标签路径
	var ImgId = document.getElementsByClassName('imgId')[0];				//显示的编号
	var imgTitle = document.getElementsByClassName('imgTitle')[0];			//显示的作品标题
	var imgDetail = document.getElementsByClassName('imgDetail')[0];		//显示的文字描述
	// 查看图片


	$('.rater-main').on('click','.rater-img2',function(){
		imgindex = $(this)[0].getAttribute('index');		//图片id
		number = Idarr.indexOf(parseInt(imgindex)); 			//当前显示的作品索引
		ajaxFunc(imgindex);							
	})
	//显示的内容
var ajax = function(id){		
	return $.ajax({
	            url:'/admin/match/img/'+id,
	            type: 'get',
	            data: {
	            },
	            success: function(data){
	                data = JSON.parse(data)
	                if(data.pic.indexOf('[')){										//判断单张还是组图
						$('.swiper-wrapper').html('');
						for(let i=0;i<$('.swiper-wrapper').length;i++){
							var dom = '';
							dom +='<div class="swiper-slide"><img src="'+www+data.pic+'" alt=""></div>';
							$('.swiper-wrapper')[i].innerHTML = dom;
						}
						ImgId.innerHTML = data.id;
						imgTitle.innerHTML = data.title;
						imgDetail.innerHTML = data.detail;
					}else{
						$('.swiper-wrapper').html('');
						for(let i=0;i<$('.swiper-wrapper').length;i++){
							var dom = '';
							for(let j=0;j<JSON.parse(data.pic).length;j++){
								dom +='<div class="swiper-slide"><img src="'+www+JSON.parse(data.pic)[j]+'" alt=""></div>';
							}
							$('.swiper-wrapper')[i].innerHTML = dom;
						}
						ImgId.innerHTML = data.id;
						imgTitle.innerHTML = data.title;
						imgDetail.innerHTML = data.detail;
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
		console.log(number)
		// ajaxFunc(imgindex);			
	})
	//下一个作品详情
	$('.nextButton').on('click',function(){
		console.log(number)
	})
	
})
	
	 //点击图片放大
	 $('.modal.fade').on('click','.img img',function(){
	 	var imgSrc = $(this).attr('src'),
	 		imgHtml = '<div class="modal_img_cont"><img src="'+imgSrc+'" alt="" class="modal_show_img"><span><button type="button" class="close">×</button> </span> </div>';
	 		console.log(imgSrc);
	 		$('.modal.fade').append(imgHtml);
	 })
	 //关闭放大图片
	 $('.modal.fade').on('click','.modal_img_cont',function(e){
	 	$(this).addClass('active')
	 })

	$('.textbutton').click(function(){
		$('.choosebox').hide();
        $(this).parents('li').find('.choosebox').show();
    })
    $('.choosebox li').click(function(){
    	var checked = $(this).find('input[type="checkbox"]').prop('checked');
    	$(this).find('input[type="checkbox"]').prop('checked',!checked);
    });
    $('.cancel').click(function(){
    	 $('.choosebox').hide();
    })
    $('.sure').click(function(){
    	var data = {}
    	data.arr = [];
    	$('.choosebox input[type="checkbox"]').each(function(){
    		var check = $(this).prop('checked');
    		if(check){
    			data.arr.push($(this).attr('alt'))
    		}
    	})
    	data.pid = $(this).parents('.choosebox').attr('index');
    	// console.log(data)

   
    })