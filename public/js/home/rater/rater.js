$(function(){

/*审核中赛事*/
	
	/*评选按钮*/
	$('.rater-btn').on('click','input',function(){
		$(this).parent().find('input').removeClass('active')
		$(this).addClass('active')
	})
})