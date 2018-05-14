$(function () {
	$("#slider-forget").slider({
		width: 360, // width
		height: 33, // height
		sliderBg: "#E8E8E8", // 滑块背景颜色
		color: "#999", // 文字颜色
		fontSize: 14, // 文字大小
		bgColor: "#7AC23C", // 背景颜色
		textMsg: "请按住滑块拖动到最右边", // 提示文字
		successMsg: "验证通过", // 验证成功提示文字
		successColor: "#fff", // 滑块验证成功提示文字颜色
		time: 400, // 返回时间
		callback: function(result) { // 回调函数，true(成功),false(失败)
		  if(result){
			$(".yz-group").removeClass('hide');
			}
		}
	});
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
    $('.form-group').on('click','.yanzheng',function(event){

    	event.preventDefault();
    	 _this = $(this);
       _this.attr("disabled",'disabled');
       
        var time = 30;
        _this.text(time+' s');

        var settime = setInterval(function(){
            if(time>0){
                time--;
                _this.text(time+' s');
                
            }else{
                window.clearInterval(settime);
                _this.removeAttr("disabled");
                _this.text('发送验证码');
            }
        },1000)
        
        var ajax = function(phone){
            $.ajax({
                type: 'POST',
                url: '/phone',
                data: {phone:phone},
                dataType: 'json',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    if(data.status){
              
                        $('.btn-flat').removeAttr('disabled');
                    }else{
                        alert(data.msg);
                        $('.btn-primary').attr('disabled','disabled');
                    }
                },
                error: function(xhr, type){
                  console.log(xhr, type)
                }
            });
        }
        var myreg=/^[1][3,4,5,7,8][0-9]{9}$/;  
        if(myreg.test($('.phone-yx').val())){
            ajax($('.phone-yx').val());
        }
    	
    })
});