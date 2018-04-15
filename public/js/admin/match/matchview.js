$(function(){
	detail({
		current:'current',
		judges_ul : '.judges_ul', //评委详细信息
		slide:'.slide_contrains', //侧边栏滚动
		control2:'.slide_ul', //导航点击跳转指定位置
		target:[".t1",".t2",".t3",".t4",".t5"],
	})
})

var detail = function(obj){

var array=[];

for(var i =0; i<obj.target.length;i++){
	var t = $(obj.target[i]).offset().top;
	array.push(t);
}
	/*评委的详细信息*/
	$(obj.judges_ul).on('mouseover','li',function(){
		var img_src = $(this).children('.judge_img').attr('src'),
			name = $(this).children('.name').html(),
			title = $(this).children('.title').html(),
			cont = $(this).children('.cont_msg').html(),
		    judges_infoTpl = ' <div class="judges_info">'+
'                            <img src="'+img_src+'" width="215" height="215" />'+
'                            <div class="judges_detail_msg">'+
'                              <p class="name">'+name+'</p>'+
'                              <p class="title">'+title+'</p>'+
'                              <div class="cont" style="word-wrap:break-word;">'+cont
'                              '+
'                              </div>'+
'                            </div>'+
'                          </div>';
		$(this).append(judges_infoTpl);
		var t = $('.judges_ul').offset().left-$(this).offset().left;
		$('.judges_info').css('left',  t+'px');
	}).on('mouseout','li',function(){ 
   		$('.judges_info').remove()
});
	/*end*/

function Selected(index){
			$(obj.control2).children().eq(index).addClass(obj.current).siblings().removeClass(obj.current);
		}
/*侧边栏滚动*/
$(window).on("scroll",Check);

	function Check(){
	//取窗口可视范围的高度 
		function getClientHeight(){    
		    var clientHeight=0;    
		    if(document.body.clientHeight&&document.documentElement.clientHeight){    
		        var clientHeight=(document.body.clientHeight<document.documentElement.clientHeight)?document.body.clientHeight:document.documentElement.clientHeight;            
		    }else{    
		        var clientHeight=(document.body.clientHeight>document.documentElement.clientHeight)?document.body.clientHeight:document.documentElement.clientHeight;        
		    }    
		    return clientHeight;    
		} 
	 
		//取文档内容实际高度 
		function getScrollHeight(){    
		    return Math.max(document.body.scrollHeight,document.documentElement.scrollHeight);    
		}

		var ele_top = $('main.main_matchview').offset().top,
			footer_t = $('.t4 .content').offset().top,
			key = 0,
			flag = true,
			height=getClientHeight(),
			theight=$(window).scrollTop(),
			rheight=getScrollHeight(),
			bheight=rheight-theight-height;
			//console.log(theight,ele_top+'ele_top',footer_t);k

			for(var i =0; i<array.length; i++){
				key++;
				if(flag){
					if(theight >= array[array.length-key]-300){
						var index = array.length-key;
						flag = false;
					}else{
						flag=true;
					}
				}
			}

			if(theight>22){
				$(obj.slide).addClass('current');
				$(obj.slide).stop().animate({
					"top": theight+'px'
				},0);
				if(footer_t<theight){
					$('#footer_page').removeClass(obj.current); 
					
				}else{
					$('#footer_page').addClass(obj.current);
				}
			}else{
				$(obj.slide).stop().animate({
					"top":'0px'
				},0);
			}
	}

// 点击导航跳转到指定位置
$(obj.control2).on("click",'li',function(){
	var index = $(this).index();
	 Selected(index);
	  
	var flag = true;
	for(var i =0; i<array.length; i++){
		if(flag){
			if(index == i){
				$(obj.slide).stop().animate({
						"top": $(window).scrollTop()+'px'
					},1);
				$("html,body").stop().animate({
					"scrollTop": array[i]-54
				},500,function(){
					$(window).on("scroll",Check);
				});
				flag = false;
			}else{
				// $(window).off("scroll");
				flag=true;
			}
		}
	} 	
});



}