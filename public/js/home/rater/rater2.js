$(function(){
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
        
        $('.rater-btn').on('click','button',function(){
            var raterbtn = $(this).parent();
            var raterbtnMatch = raterbtn.attr('match');
            var raterbtnRound = raterbtn.attr('round');
            var btnValue = $(this).attr('value');
            var imgId = $(this).parent().prev().find('.img-Id').text();
            var _this = $(this);
    
            $.ajax({
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
                    if (data.data) {
                        _this.parent().find('button').removeClass('active');
                        _this.addClass('active');
                    };
                }
            })
        })
    
    /*评委评审室比赛列表*/
    
        // 查看图片
        $('.rater-main').on('click','.rater-img',function(){
    
            var imgSrc = $(this).find('img').attr('src');		//获取点击图片路径
            var modelImg = $('.wrapperimg').find('img');		//显示的img标签
            var btnrater = $('.btnrater button').removeClass('active')
            
            modelImg.attr('src',imgSrc);						//修改显示的img标签路径
    
            var btnactive = $(this).next().next();
            
            var passbtnactive = btnactive.find('.passbtn').hasClass("active");
            var whilebtnactive = btnactive.find('.whilebtn').hasClass("active");
            var outbtnactive = btnactive.find('.outbtn').hasClass("active");
            if (passbtnactive) {
            	$('.btnrater .passbtn').addClass('active')
            	$('.btnrater .whilebtn').removeClass('active')
            	$('.btnrater .outbtn').removeClass('active')
            };
            if (whilebtnactive) {
            	$('.btnrater .whilebtn').addClass('active')
            	$('.btnrater .passbtn').removeClass('active')
            	$('.btnrater .outbtn').removeClass('active')
            };
            if (outbtnactive) {
            	$('.btnrater .whilebtn').removeClass('active')
            	$('.btnrater .passbtn').removeClass('active')
            	$('.btnrater .outbtn').addClass('active')
            };
    
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
    
            var _this = $(this)
            var index = $(this).parent().index();
            var lengthLi = $(this).parent().parent().find('li').length;
    
            $('.next').on('click',function(){
                if (index ===(lengthLi-1)) {
                    return
                };
                index++;
                var nextImgSrc = _this.parent().parent().find('li').eq(index).find('img').attr('src');
                modelImg.attr('src','');
                modelImg.attr('src',nextImgSrc);
                var imgId = _this.parent().parent().find('li').eq(index).find('.img-Id').text();
                var btnactive = _this.parent().parent().find('li').eq(index).find('.rater-btn');
                var passbtnactive = btnactive.find('.passbtn').hasClass("active");
                var whilebtnactive = btnactive.find('.whilebtn').hasClass("active");
                var outbtnactive = btnactive.find('.outbtn').hasClass("active");
                if (passbtnactive) {
                    $('.btnrater .passbtn').addClass('active')
                    $('.btnrater .whilebtn').removeClass('active')
                    $('.btnrater .outbtn').removeClass('active')
                };
                if (whilebtnactive) {
                    $('.btnrater .whilebtn').addClass('active')
                    $('.btnrater .passbtn').removeClass('active')
                    $('.btnrater .outbtn').removeClass('active')
                };
                if (outbtnactive) {
                    $('.btnrater .whilebtn').removeClass('active')
                    $('.btnrater .passbtn').removeClass('active')
                    $('.btnrater .outbtn').addClass('active')
                };
                console.log(btnactive)
    
                console.log(imgId)
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
                var passbtnactive = btnactive.find('.passbtn').hasClass("active");
                var whilebtnactive = btnactive.find('.whilebtn').hasClass("active");
                var outbtnactive = btnactive.find('.outbtn').hasClass("active");
                if (passbtnactive) {
                    $('.btnrater .passbtn').addClass('active')
                    $('.btnrater .whilebtn').removeClass('active')
                    $('.btnrater .outbtn').removeClass('active')
                };
                if (whilebtnactive) {
                    $('.btnrater .whilebtn').addClass('active')
                    $('.btnrater .passbtn').removeClass('active')
                    $('.btnrater .outbtn').removeClass('active')
                };
                if (outbtnactive) {
                    $('.btnrater .whilebtn').removeClass('active')
                    $('.btnrater .passbtn').removeClass('active')
                    $('.btnrater .outbtn').addClass('active')
                };
                console.log(imgId)
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
    
                    for(var i=0 ;i<btnValue.length;i++){
                        arr[i] = btnValue.eq(i).val()
                    }
                    
                    console.log(raterbtnMatch,raterbtnRound,btnType,JSON.stringify(arr))
    
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
                            console.log(data);
                        }
                    })
               })
    
        })
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
            console.log(data)
      //   	$.ajax({
            // 	url:'/rater/pic',
            // 	type: 'post',
            // 	data: {
            // 	},
            // 	success: function(data){
            // 		console.log(data);
            // 	}
            // })
    
        })