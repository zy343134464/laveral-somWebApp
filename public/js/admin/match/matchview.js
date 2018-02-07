function LiftEffect(json){

var array=[];

for(var i =0; i<json.target.length;i++){
	var t = $(json.target[i]).offset().top;
	array.push(t);

}

function Selected(index){
	$(json.control2).children().eq(index).addClass(json.current).siblings().removeClass(json.current);
}


$(window).on("scroll",Check);

function Check(){

	var wst = $(window).scrollTop();


	var key =0;
	var flag = true;
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
	Selected(index);
}

$(json.control2).on("click",'li',function(){
	$(window).off("scroll");
	var index = $(this).index();
	Selected(index);
	
	var flag = true;
	for(var i =0; i<array.length; i++){
	
		if(flag){

			if(index == i){
				$("html,body").stop().animate({
					"scrollTop": array[i]-50
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

}

$(function(){
	LiftEffect({
		"control1": ".side", 						  //侧栏电梯的容器
		"control2": ".side-up",                           //需要遍历的电梯的父元素
		"target": [".t1",".t2",".t3",".t4",".t5",".t6"], //监听的内容，注意一定要从小到大输入
		"current": "current" 						  //选中的样式
	});
})