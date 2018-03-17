
function LiftEffect(json){

var array=[];

for(var i =0; i<json.target.length;i++){
	var t = $(json.target[i]).offset().top;
	array.push(t);

}
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
//取窗口滚动条高度 
function getScrollTop(){    
    var scrollTop=0;    
    if(document.documentElement&&document.documentElement.scrollTop){    
        scrollTop=document.documentElement.scrollTop;    
    }else if(document.body){    
        scrollTop=document.body.scrollTop;    
    }    
    return scrollTop;    
} 

//取文档内容实际高度 
function getScrollHeight(){    
    return Math.max(document.body.scrollHeight,document.documentElement.scrollHeight);    
} 
/*window.onscroll=function(){ 
    var height=getClientHeight(); 
    var theight=getScrollTop(); 
    var rheight=getScrollHeight(); 
    var bheight=rheight-theight-height; 
    console.log('此时浏览器可见区域高度为：'+height+'<br />此时文档内容实际高度为：'+rheight+'<br />此时滚动条距离顶部的高度为：'+theight+'<br />此时滚动条距离底部的高度为：'+bheight); 
} */



function Selected(index){
	$(json.control2).children().eq(index).addClass(json.current).siblings().removeClass(json.current);
}

function checkFuc(ele){
	if($(ele).is(':checked')){
		$('.layer .layer-btn').addClass(json.current).removeAttr("disabled");
		$(json.layer).on("click",'.layer-btn',function(){
			$('layer-check-input').removeAttr("checked");
			$('.layer-btn').removeClass(json.current).attr("disabled","disabled");
			$('.statement').hide();
			$('.regist-info').show();
		})	
	 }else{
	 	$('.layer-btn').removeClass(json.current).attr("disabled","disabled");
	 };
}

// $('')

$(window).on("scroll",Check);

function Check(){

	var wst = $(window).scrollTop(),
		foot_h = $("#footer").height()+74,
		ele_top = $("#advertisement").height(),
		key =0,
		flag = true,
		height=getClientHeight(),
		theight=getScrollTop(), 
		rheight=getScrollHeight(),
		bheight=rheight-theight-height; 
		console.log(ele_top,wst+'---------',array[0]);

	for(var i =0; i<array.length; i++){
		key++;
		if(flag){

			if(wst >= array[array.length-key]-300){
				var index = array.length-key;
				flag = false;
			}else{
				flag=true;
			}
		}
	}
	
	if(wst>ele_top){
		$(json.control1).addClass('fix');
		$(json.control2).children().eq(0).addClass(json.current).siblings().removeClass(json.current);
		if(wst>1380){
			$('#matchview .footer').removeClass('fix');
		}

		if(bheight<foot_h){
			
			$("html,body").css({"overflow-Y":"hidden"});
			console.log(foot_h+"foot");
		}

	}else  {
		$(json.control1).removeClass('fix');
		 $('#matchview .footer').addClass('fix');
	}
	Selected(index);
}
$(json.sign_up).on("click",'div',function(){
	var status = $(this).data('status');
	$(this).addClass(json.current).siblings().removeClass(json.current);
	if (status=='sign') {
		$(json.layer).show();
		checkFuc('.statement-div .checkbox input');
	}else{
		$("html,body").stop().animate({
					"scrollTop": 0
				},500);

		$(this).removeClass(json.current)
	};
})

$(json.layer).on("click",'.layer-close',function(){ 
	$(json.layer).hide(); 
})

$(json.layer).on("click",'.layer-check-input',function(){
		checkFuc('.layer-check-input');
});




$(json.control2).on("click",'li',function(){
	$(window).off("scroll");
	var index = $(this).index();
	Selected(index);
	
	var flag = true;
	for(var i =0; i<array.length; i++){
	
		if(flag){
			console.log(array[i]);
			if(index == i){
				$("html,body").stop().animate({
					"scrollTop": array[i]-74
				},500,function(){
					$(window).on("scroll",Check);
				});
				flag = false;
			}else{
				flag=true;
			}
			
		}
	}
		
});

$(json.judges).on('mouseover','li.fl .title-img',function(){
	$(this).parents('li').find('.Personal-info').show()
}).on('mouseout','li .title-img',function(){
	$(this).parents('li').find('.Personal-info').hide()
});

 $(json.date).datetimepicker({
       format: "yyyy-mm-dd",
       autoclose: true,
       todayBtn: true,
       todayHighlight: true,
       showMeridian: true,
       pickerPosition: "bottom-left",
       language: 'zh-CN',//中文，需要引用zh-CN.js包
        startView: 2,//月视图
        minView: 2//日期时间选择器所能够提供的最精确的时间选择视图
    });

}

$(function(){
	LiftEffect({
		"sign_up":".sign-up",
		"judges" : "#judges",    // 评委
		"layer":".layer",      //弹出层
		"control1": ".side", 	 //侧栏电梯的容器
		"control2": ".side-up", 
		// 需要遍历的电梯的父元素
		"target": [".t1",".t3",".t4",".t5"],
		// "target": [".t1",".t2",".t3",".t4",".t5",".t6"], //监听的内容，注意一定要从小到大输入
		"current": "current", 						  //选中的样式
		"date"  : "#date-input"
	});
})