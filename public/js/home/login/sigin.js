$(function () {
    // $('input').iCheck({
    //     checkboxClass: 'icheckbox_square-blue',
    //     radioClass: 'iradio_square-blue',
    //     increaseArea: '20%' // optional
    // });
    
    //验证手机号定时器函数
    $('.yanzheng').click(function(){
       _this = $(this);
       _this.attr("disabled",'disabled');
       
        var time = 60;
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
    	
    })
    
    //密码强度函数
    var $hint = $('.pwd_intensity li');
    document.getElementById('password').onkeyup = function(){
        var p = /[a-z]/i;
        var regEn = /[`~!@#$%^&*()_+<>?:"{},.\/;'[\]]/im,regCn = /[·！#￥（——）：；“”‘、，|《。》？、【】[\]]/im;
        
        if(this.value&&!p.test(this.value)&&!(regEn.test(this.value)||regCn.test(this.value))){     //有值但不是字母或者特殊字符
            $hint.eq(0).show()
            $hint.eq(1).hide()
            $hint.eq(2).hide()
        }else if(p.test(this.value)&&(regEn.test(this.value)||regCn.test(this.value))){   //有值且是字母或者特殊字符
            $hint.eq(0).show()
            $hint.eq(1).show()
            $hint.eq(2).show()
        }else if(p.test(this.value)||(regEn.test(this.value)||regCn.test(this.value))){
            $hint.eq(0).show()
            $hint.eq(1).show()
            $hint.eq(2).hide()
        }else{
            $hint.eq(0).hide()
            $hint.eq(1).hide()
            $hint.eq(2).hide()
        }
        
        
    }

    //验证手机格式函数
    function checkPhone(e){
        var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
        if(!e.value){
            msg.innerHTML = '手机号码不能为空';
        }   
        else if(!myreg.test(e.value)){
            msg.innerHTML = '号码格式不正确！';
        }else{
            msg.innerHTML = ''
            
        }
    }
});