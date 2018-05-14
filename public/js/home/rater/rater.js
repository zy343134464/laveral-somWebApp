

	// 获取url？之后的值
        function changeURLArg(url,arg,arg_val){ 
                var pattern=arg+'=([^&]*)'; 
                var replaceText=arg+'='+arg_val; 
                if(url.match(pattern)){ 
                    var tmp='/('+ arg+'=)([^&]*)/gi'; 
                    tmp=url.replace(eval(tmp),replaceText); 
                    return tmp; 
                }else{ 
                    if(url.match('[\?]')){ 
                        return url+'&'+replaceText; 
                    }else{ 
                        return url+'?'+replaceText; 
                    } 
                } 
                return url+'\n'+arg+'\n'+arg_val; 
            } 

	function url_change(ele){  //给select下拉框跳转
        if($('.'+ele).find( 'option')){
            for(let i=0;i<$('.'+ele).find( 'option').length;i++){
                var number = $('.'+ele).find( 'option').eq(i).val();
                var url_num = window.location.search;
                if(url_num == ''|| url_num ==null || url_num ==undefined ){
                  $('.'+ele).find( 'option').eq(i).val( 'http://'+ window.location.host+ window.location.pathname+'?'+ele+'='+number);
                //    console.log( document.getElementsByClassName(ele)[0].getElementsByTagName('option')[i].value);
                }else{
                    $('.'+ele).find( 'option').eq(i).val(  changeURLArg(window.location.href,ele,number));
                }
                
            }
    }
}
$(function(){
	// 奖项编辑----------------------------------------------------------------------
	 $('.textbutton').click(function(){
		 var ulId = this.parentNode.nextSibling.nextSibling.getElementsByTagName('ul')[0]	//奖项列表
		 var we = this.parentNode.nextSibling.nextSibling;									//奖项编辑框
		 var showneir = this.parentNode.getElementsByClassName('testeli')[0];				//当前显示的奖项
		 var zuopinId = this.parentNode.getElementsByClassName('img-Id')[0].innerHTML;		//作品id
		 var Competition_id = this.getAttribute('Competition-id');							//赛事id
		
		 
		var arrId = [];		//上传的奖项id
		
		for(let i=0;i<=ulId.getElementsByTagName('li').length-1;i++){
				ulId.getElementsByTagName('li')[i].className = '';
				
				for(let j=0;j<showneir.innerHTML.split(" ").length;j++){
					if(showneir.innerHTML.split(" ")[j]==ulId.getElementsByTagName('li')[i].getElementsByTagName('span')[0].innerHTML){
						ulId.getElementsByTagName('li')[i].className = 'color';
					}
				}
				if(ulId.getElementsByTagName('li')[i].className=='color'){
					arrId.push(parseInt(ulId.getElementsByTagName('li')[i].getAttribute("data-id")));
				}
			}	
			function awardsClick(){			//奖项点击事件
				for(let i=0;i<ulId.getElementsByTagName('li').length;i++){
					ulId.getElementsByTagName('li')[i].onclick = function(){
						var num_data = parseInt(this.getAttribute("data-id"));
							if(this.className!='color'){
								arrId.push(num_data);
								this.className = 'color';
							}else{
								var index = arrId.indexOf(num_data); 
								arrId.splice(index, 1); 
								// console.log(arrId)
								this.className = '';
							}
					}
				 }
			}
			awardsClick();
	 	this.parentNode.nextSibling.nextSibling.getElementsByClassName('sure')[0].onclick = function(){
	 			we.style.display = 'none';
	 			var string1 = '';
	 			for(let i=0;i<ulId.getElementsByTagName('li').length;i++){
	 				if(ulId.getElementsByTagName('li')[i].className == 'color'){
	 					string1 += ulId.getElementsByTagName('li')[i].getElementsByTagName('span')[0].innerHTML+' ';
	 				}
	 			}
	 			showneir.innerHTML = string1;
	 			// console.log('123',arrId)
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
						// console.log('31',data)
						data = JSON.parse(data);
						
					}
				})
				
		 }
		 
		//  其他
		for(let i=0;i<document.getElementsByClassName('else').length;i++){
			document.getElementsByClassName('else')[i].onclick = function(){
				if(this.className!='else color'){
					this.className = 'else color';
					this.getElementsByTagName('span')[0].style.display = 'none';
					this.getElementsByTagName('input')[0].style.display = 'inline-block'; 
				}
				var _this = this;
				this.getElementsByTagName('input')[0].onblur = function(){
					_this.className='else';
					_this.getElementsByTagName('span')[0].style.display = 'block';
					this.style.display = 'none';
					// console.log(this.value)
					var that = this;
					if(this.value.length>0){
						$.ajax({
							url:'/admin/match/add_award',
							type: 'post',
							dataType: 'json',
							headers: {
								'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
							},
							data: {
								match_id : Competition_id,
								name : that.value
								
							},
							success: function(data){
								console.log(data)
								if(data.status){
									var new_awards = `<li data-id='${data.data}'><i class='SelectBtn'></i><span>${that.value}</span></li>`;
									for(let i=0;i<$('.rater_list_li .ul_num').length;i++){
										$('.rater_list_li .ul_num')[i].innerHTML +=new_awards;
									}
									// ulId.innerHTML +=new_awards;
									awardsClick();
								}else{
									alert('奖项添加有误，请重新添加！')
								}
							}
						})
					}
					
				}
			}
		}
		
	 })

	// 根据赛事进度给第几轮显示时间
	var timeNum = $('.number_of_times').text();
	$('.num_times li').eq(parseInt(timeNum)).find('.time').show();
	$('.on').eq($('.number_times').val()).find('.time').show();
	//赛事进度方法
	var num_time = parseInt($('.number_of_times').text());
	for(let i=0;i<=num_time;i++){
		$('.num_times li')[i].className = 'on';				
	}



	//左侧移动效果--------------------------------------
	window.onscroll = function(){
		var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
		// console.log(scrollTop)
		if(document.getElementsByClassName('sidebar')[0]){
			document.getElementsByClassName('sidebar')[0].style.paddingTop = (scrollTop+20)+'px';
		}
		
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

	var lock;				//作品是否点击过
	var now_Id = 0;			//当前作品id

	$('.rater-btn').on('click','button',function(){
		
		var raterbtn = $(this).parent();				//获取父级节点
		var raterbtnMatch = raterbtn.attr('match');		//获取赛事id
		var raterbtnRound = raterbtn.attr('round');		//获取本轮轮次
		var imgId = raterbtn.attr('index');				//获取该作品的id
		var btnValue = $(this).attr('value');			//获取按钮值
		var _this = $(this);
		var shenyu = $('.shenyu i');					//剩余票数dom
		var yiping = $('.yiping i');					//已评dom
		var weiping = $('.weiping i');					//未评

		var shenyu2 = $('.shenyu2');					//弹窗剩余票数dom
		var yiping2 = $('.yiping2');					//弹窗已评dom
		var weiping2 = $('.weiping2');					//弹窗未评

		if(_this.parent().find('button').hasClass('active')){
			lock = true;
			var old = _this.parent().find('.active').val();		//按钮点击前的状态
		}else{
			lock = false;
		}

		var ajax = function(){
			return $.ajax({
				url:'/rater/pic',
				type: 'post',
				data: {
					"id": ""+imgId+"",				//作品的id
					"value": ""+btnValue+"",		//按钮值
					"round": ""+raterbtnRound+"",	//本轮轮次
					"match_id": ""+raterbtnMatch+""	//赛事id
				},
				success: function(data){
					data = JSON.parse(data)
					console.log(data)
					if (data.data) {
						_this.parent().find('button').removeClass('active');
						_this.addClass('active');
						for(let i=0;i<$('.img-Id').length;i++){
							if($('.img-Id').eq(i).text()==imgId){
								$('.img-Id').eq(i).parent().next().find('button').removeClass('active');
								for(let j=0;j<$('.img-Id').eq(i).parent().next().find('button').length;j++){
									if($('.img-Id').eq(i).parent().next().find('button').eq(j).val()==_this.val()){
										$('.img-Id').eq(i).parent().next().find('button').eq(j).addClass('active');
									}
								}

							}
						}
					}else{
						this.judge = true;		//判断返回的data的状态是否为false
					}
				}
			})
		}
		if(!_this.hasClass('active')){			//判断不是多次次点击按钮时触发ajax
			ajax().then(function(){
				if(this.judge){					//已投完票则不能往下走
					return false;
				}
				if(lock){						//判断该作品是否已有点击过
					if(_this.val()==1){			//该作品已点击，并此次点击的是入围
						shenyu.text(parseInt(shenyu.text())-1);
						shenyu2.text(parseInt(shenyu2.text())-1);
					}else{						//点击的不是入围
						if(old==1){				//之前点击是否是入围
							shenyu.text(parseInt(shenyu.text())+1);
							shenyu2.text(parseInt(shenyu2.text())+1);
						}
					}
				}else{							//作品未点击过
					if(_this.val()==1){			//点击的是否是入围
						shenyu.text(parseInt(shenyu.text())-1);		
						yiping.text(parseInt(yiping.text())+1);
						weiping.text(parseInt(weiping.text())-1);
						shenyu2.text(parseInt(shenyu2.text())-1);		
						yiping2.text(parseInt(yiping2.text())+1);
						weiping2.text(parseInt(weiping2.text())-1);
					}else{
						yiping.text(parseInt(yiping.text())+1);
						weiping.text(parseInt(weiping.text())-1);
						yiping2.text(parseInt(yiping2.text())+1);
						weiping2.text(parseInt(weiping2.text())-1);
					}
				}
			})
		}
		
	})

/*评委评审室比赛列表*/
	//  评委查看图片
	$('.rater-main').on('click','.rater-img',function(){
		
		// var imgSrc = $(this).find('img').attr('src');		//获取点击图片路径
		// var modelImg = $('.wrapperimg').find('img');		//显示的img标签
		// var btnrater = $('.btnrater button').removeClass('active')
		
		// modelImg.attr('src',imgSrc);						//修改显示的img标签路径

		//点击作品替换显示详情的分数
		// if($('.score_input')[0]){
		// 	var btnactive = $(this).next().next();
		// 	var now_num = parseInt(btnactive.text().substr(btnactive.text().indexOf(':')+1))
		// 	if(now_num){
		// 		$('.score_input')[0].value = now_num;
		// 	}else{
		// 		$('.score_input')[0].value = '';
		// 	}
		// }
	

		//按顺序获取列表内的作品id
		// var arrId = [];		//id数组
		// var id_arr = $('.rater-main li .img-Id');
		// for(var i=0;i<id_arr.length;i++){
		// 	arrId.push(id_arr[i].innerHTML)
		// }
		
		// // 获取图片信息
		// var imgId = $(this).next().find('.img-Id').text();		//图片id

		

		// function picInfro(oData){
		// 	var imgId = $('.wrapperinfro').find('.imgId');
		// 	imgId.text(""+oData.id+"")

		// 	var imgTitle = $('.wrapperinfro').find('.imgTitle');
		// 	imgTitle.text(""+oData.title+"")

		// 	var imgDetail = $('.wrapperinfro').find('.imgDetail');
		// 	imgDetail.text(""+oData.detail+"")
		// }

		// var _this = $(this);
		// var index = $(this).parent().index();				//获取当前li在ul中的索引
		// var lengthLi = $(this).parent().parent().find('li').length;		//获取li的个数
		
		// $('.next').on('click',function(){
		// 	if (index ===(lengthLi-1)) {		//当点击的到最后一个li时不在往下运行
		// 		return
		// 	};
		// 	index++;							//li索引自增
		// 	var nextImgSrc = _this.parent().parent().find('li').eq(index).find('img').attr('src');		//获取下一个作品的图片路径
		// 	modelImg.attr('src','');			//清空显示详情的路径
		// 	modelImg.attr('src',nextImgSrc);	//替换路径
		// 	var imgId = _this.parent().parent().find('li').eq(index).find('.img-Id').text();			//获取下一个作品的id
		// 	var btnactive = _this.parent().parent().find('li').eq(index).find('.rater-btn');			//获取下一个作品的分数节点
		// 	// var passbtnactive = btnactive.find('.passbtn').hasClass("active");						//搜索下一个作品的类名为passbtn有无类名active
		// 	//点击下一个作品替换显示详情的分数
		// 	var next_num = parseInt(btnactive.text().substr(btnactive.text().indexOf(':')+1));
		// 	if($('.score_input')[0]){
		// 		if(next_num){
		// 			$('.score_input')[0].value = next_num;
		// 		}else{
		// 			$('.score_input')[0].value = '';
		// 		}
		// 	}
		
		// 	$.ajax({
		// 	  url: '/rater/rater_pic/'+imgId,
		// 	  method: 'get',
		// 	  success: function(data){
		// 		  var oData = data.data;
		// 		picInfro(oData)
		// 	  }
		// 	})
		// 	function picInfro(oData){
		// 		var imgId = $('.wrapperinfro').find('.imgId');
		// 		imgId.text(""+oData.id+"")

		// 		var imgTitle = $('.wrapperinfro').find('.imgTitle');
		// 		imgTitle.text(""+oData.title+"")

		// 		var imgDetail = $('.wrapperinfro').find('.imgDetail');
		// 		imgDetail.text(""+oData.detail+"")
		// 	}
		// })

		// $('.prev').on('click',function(){
		// 	if (index ===(0)) {
		// 		return
		// 	};
		// 	index--;
		// 	var prevImgSrc = _this.parent().parent().find('li').eq(index).find('img').attr('src');
		// 	modelImg.attr('src','');
		// 	modelImg.attr('src',prevImgSrc);

		// 	var imgId = _this.parent().parent().find('li').eq(index).find('.img-Id').text();
		// 	var btnactive = _this.parent().parent().find('li').eq(index).find('.rater-btn');
		// 	//点击上一个作品替换显示详情的分数
		// 	var prev_num = parseInt(btnactive.text().substr(btnactive.text().indexOf(':')+1));
		// 	if($('.score_input')[0]){
		// 		if(prev_num){
		// 			$('.score_input')[0].value = prev_num;
		// 		}else{
		// 			$('.score_input')[0].value = '';
		// 		}
		// 	}
			
		// 	$.ajax({
		// 	  url: '/rater/rater_pic/'+imgId,
		// 	  method: 'get',
		// 	  success: function(data){
		// 		  var oData = data.data;
		// 		picInfro(oData)
		// 	  }
		// 	})
		// 	function picInfro(oData){
		// 		var imgId = $('.wrapperinfro').find('.imgId');
		// 		imgId.text(""+oData.id+"")

		// 		var imgTitle = $('.wrapperinfro').find('.imgTitle');
		// 		imgTitle.text(""+oData.title+"")

		// 		var imgDetail = $('.wrapperinfro').find('.imgDetail');
		// 		imgDetail.text(""+oData.detail+"")
		// 	}
		// })

		// $('.btnrater').on('click','button',function(){
		// 	var raterbtn = $(this).parent();
		// 	var raterbtnMatch = raterbtn.attr('match');
		// 	var raterbtnRound = raterbtn.attr('round');
		// 	var btnValue = $(this).attr('value');
		// 	var imgId1 = _this.parent().parent().find('li').eq(index).find('.img-Id').text();
		// 	var _this1 = $(this)
		// 	var _this2 = _this.parent().parent().find('li').eq(index).find('.rater-btn');

		// 	$.ajax({
		// 		url:'/rater/pic',
		// 		type: 'post',
		// 		data: {
		// 			"id": ""+imgId1+"",
		// 			"value": ""+btnValue+"",
		// 			"round": ""+raterbtnRound+"",
		// 			"match_id": ""+raterbtnMatch+""
		// 		},
		// 		success: function(data){
		// 			data = JSON.parse(data)
		// 			if (data.data) {
		// 				_this1.parent().find('button').removeClass('active');
		// 				_this1.addClass('active');
		// 				_this2.find('button').removeClass('active');
		// 				_this2.find('button').eq(_this1.index()).addClass('active');
		// 				console.log(data.msg);
		// 			};
		// 		}
		// 	})

			 
		// 	if (index ===(lengthLi-1)) {
		// 		return
		// 	};
		// 	index++;
		// 	var nextImgSrc = _this.parent().parent().find('li').eq(index).find('img').attr('src');
		// 	modelImg.attr('src','');
		// 	modelImg.attr('src',nextImgSrc);

		// 	var imgId = _this.parent().parent().find('li').eq(index).find('.img-Id').text();

		// 	$.ajax({
		// 	  url: '/rater/rater_pic/'+imgId,
		// 	  method: 'get',
		// 	  success: function(data){
		// 		  var oData = data.data;
		// 		picInfro(oData)
		// 	  }
		// 	})
		// 	function picInfro(oData){
		// 		var imgId = $('.wrapperinfro').find('.imgId');
		// 		imgId.text(""+oData.id+"")

		// 		var imgTitle = $('.wrapperinfro').find('.imgTitle');
		// 		imgTitle.text(""+oData.title+"")

		// 		var imgDetail = $('.wrapperinfro').find('.imgDetail');
		// 		imgDetail.text(""+oData.detail+"")
		// 	}

		   
		// })



	})

// 组图的显示开始------------------------------------------------------------------------------------
var www = window.location.protocol+'//'+window.location.host+'/';
for(let i=0;i<$('.rater-img2').length;i++){
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
	// console.log($('.news_hjy'))
	if($('.news_hjy').length!=0){
		for(let i=0;i<$('.works_hjy').length;i++){
			Idarr.push($('.works_hjy').eq(i).find('.works_Id').text())
		}
	}else{
		for(let i=0;i<$('.rater-main li').length;i++){
			Idarr.push(parseInt($('.rater-main li')[i].getElementsByClassName('img-Id')[0].innerHTML))
		}
	}
	
	var number = 0; 			//当前显示的作品索引
	var www = window.location.protocol+'//'+window.location.host+'/';
	var imgindex = '';
	var modelImg = $('.wrapperimg img');		//显示的img标签路径
	var ImgId = document.getElementsByClassName('imgId');				//显示的编号
	var imgTitle = document.getElementsByClassName('imgTitle');			//显示的作品标题
	var imgDetail = document.getElementsByClassName('imgDetail');		//显示的文字描述
	// 查看图片


	$('.rater-main').on('click','.rater-img2',function(){
		// console.log(123)
		imgindex = $(this)[0].getAttribute('index'); 		//图片id
		// console.log(imgindex)
		number = Idarr.indexOf(parseInt(imgindex)); 			//当前显示的作品索引
		// console.log(Idarr)
		ajaxFunc(imgindex);							
	})
	//显示的内容
var ajax = function(id){	
// console.log('/user/match/img/'+id)	
	if($('.news_hjy')){
		var url = '/img/'+id;
	}else{
		var url = '/user/match/img/'+id;
	}
	return $.ajax({
	            url:url,
	            type: 'get',
	            data: {
	            },
	            success: function(data){
					// console.log(data)
	                data = JSON.parse(data);
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
			// console.log(number)
			ajaxFunc(Idarr[number]);		
		}
	})
	//--------------------------------------------------------------------------------------
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