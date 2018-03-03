$(function(){
	// 点击列表每行模态框
	var tbody = $('tbody')
	tbody.on('click','tr',function(){
		var title = $(this).find('.inner-title').text();
		$('.modal .modal-title').text(title);
	})
})