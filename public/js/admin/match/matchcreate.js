$(function () {

  /*赛事主题*/

    // 赛事详情页设置新增标题

    //初始参数个数

    var varCount = 1;
      //新增按钮点击
      $('#addVar').on('click', function(){
        varCount++;
        $node = '<div class="form-group"><label for="var'+varCount+'" id="var'+varCount+'" class="col-sm-2 control-label"></label>'
        + '<div class="col-sm-8"><input type="text" name="title[]" class="form-control" for="var'+varCount+'" id="var'+varCount+'"></div>'
        + '<span class="removeVar">-</span></div>';
        //新表单项添加到“新增”按钮前面
        $(this).parent().before($node);
      });

      //删除按钮点击
      $('form').on('click', '.removeVar', function(){
        $(this).parent().remove();
        varCount--;
      });

    // 征稿开始时间
   
    $.fn.datetimepicker.dates['zh-CN'] = {
      days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
      daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
      daysMin:  ["日", "一", "二", "三", "四", "五", "六", "日"],
      months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
      monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
      today: "今日",
      suffix: [],
      meridiem: ["上午", "下午"]
    };

    $('.collectstart-datetime-lang').datetimepicker({
      language:  'zh-CN',
      format: 'yyyy-mm-dd hh:ii'
    });

      // 征稿结束时间
      $.fn.datetimepicker.dates['zh-CN'] = {
        days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
        daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
        daysMin:  ["日", "一", "二", "三", "四", "五", "六", "日"],
        months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        today: "今日",
        suffix: [],
        meridiem: ["上午", "下午"]
      };

      $('.collectend-datetime-lang').datetimepicker({
        language:  'zh-CN',
        format: 'yyyy-mm-dd hh:ii'
      });

      // 赛果公布日期
      $.fn.datetimepicker.dates['zh-CN'] = {
        days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
        daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
        daysMin:  ["日", "一", "二", "三", "四", "五", "六", "日"],
        months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        today: "今日",
        suffix: [],
        meridiem: ["上午", "下午"]
      };

      $('.reviewstart-datetime-lang').datetimepicker({
        language:  'zh-CN',
        format: 'yyyy-mm-dd hh:ii'
      });


      /*组委会评选*/

    // 比赛合作方信息

    //初始参数个数
    var varCount1 = 1;
      //新增按钮点击
      $('#addVar1').on('click', function(){
        varCount1++;
        $node = '<div class="form-group match-partner-add">'
        + '<div class="col-sm-2 col-sm-offset-2"><input type="text" name="role[]" class="form-control" for="var'+varCount1+'" id="var'+varCount1+'" placeholder="赞助方"></div>'
        + '<div class="col-sm-4" style="margin-left:-24px;"><input type="text" name="name[]" class="form-control" for="var'+varCount1+'" id="var'+varCount1+'" placeholder="名称"></div>'
        + '<span class="removeVar1">-</span>';
        //新表单项添加到“新增”按钮前面
        $(this).parent().before($node);
      });

      //删除按钮点击
      $('form').on('click', '.removeVar1', function(){
        $(this).parent().remove();
        varCount1--;
      });

    //主办方联系方式

    //初始参数个数
    var varCount2 = 1;
      //新增按钮点击
      $('#addVar2').on('click', function(){
        varCount2++;
        $node = '<div class="form-group match-partner-add">'
        + '<div class="col-sm-2 col-sm-offset-2"><input type="text" name="type[]" class="form-control" for="var'+varCount2+'" id="var'+varCount2+'" placeholder="QQ/电话/微信/邮箱"></div>'
        + '<div class="col-sm-4" style="margin-left:-24px;"><input type="text" name="value[]" class="form-control" for="var'+varCount2+'" id="var'+varCount2+'" placeholder=""></div>'
        + '<span class="removeVar2">-</span>';
        //新表单项添加到“新增”按钮前面
        $(this).parent().before($node);
      });

      //删除按钮点击
      $('form').on('click', '.removeVar2', function(){
        $(this).parent().remove();
        varCount2--;
      });

      /*评委*/

      $('.judgelist').on('mouseenter','li',function(){
        $(this).find('.close').css('display','block');
      })
      $('.judgelist').on('mouseleave','li',function(){
        $(this).find('.close').css('display','none');
      })

      /*评委搜索页*/
      $('.judgedata').on('click','li',function(){
        if ($(this).find('.check').css('color')==='rgb(204, 204, 204)') {
          $(this).find('.check').css('background','#d0a45d');
          $(this).find('.check').css('border','#d0a45d');
          $(this).find('.check').css('color','#fff');
          $(this).find('.input').attr("name","id[]");
          $(this).attr('index','1');
        }else{
          $(this).find('.check').css('background','transparent');
          $(this).find('.check').css('border','2px solid #ccc');
          $(this).find('.check').css('color','#ccc');
          $(this).find('.input').attr("name","");
          $(this).removeAttr('index');
        };
      })

  // 编辑评委信息
  $('.editraterBtn').click(function(){
    var raterName = $(this).parent('.judge-edit').prev().find(".name");
    var raterTag = $(this).parent('.judge-edit').prev().find(".tag");
    var raterDetail = $(this).parent('.judge-edit').prev().find(".detail");
    var raterPic = $(this).parent('.judge-edit').prev().prev().find('.rater-img').attr('src');
    var raterPicTo = $(this).parent('.judge-edit').prev().prev().find('.rater-img').attr('index');
    var raterId = $(this).parent('.judge-edit').prev().find("#hiddenId");


    $('#ratername').val(raterName.text());
    $('#ratertag').val(raterTag.text());
    $('#raterdetail').val(raterDetail.text());
    $('#hidden').val(raterId.text());
    $('#poster-pic').find('img').attr('src',raterPic);
    $('.savedraterpath').val(raterPicTo);
  })

  // 编辑嘉宾信息
  $('.editguestBtn').click(function(){
    var raterName = $(this).parent('.judge-edit').prev().find(".name");
    var raterTag = $(this).parent('.judge-edit').prev().find(".tag");
    var raterDetail = $(this).parent('.judge-edit').prev().find(".detail");
    var raterPic = $(this).parent('.judge-edit').prev().prev().find('.rater-img').attr('src');
    var raterPicTo = $(this).parent('.judge-edit').prev().prev().find('.rater-img').attr('index');
    var raterId = $(this).parent('.judge-edit').prev().find("#hiddenId");


    $('#ratername').val(raterName.text());
    $('#ratertag').val(raterTag.text());
    $('#raterdetail').val(raterDetail.text());
    $('#hidden').val(raterId.text());
    $('#poster-pic').find('img').attr('src',raterPic);
    $('.savedraterpath').val(raterPicTo);
  })

  /*奖项设置*/

    //初始参数个数
    var varCount3 = 1;
      //新增按钮点击
      $('#addVar3').on('click', function(){
        varCount++;
        $node = '<div class="form-group">'
        + '<div class="col-sm-2 col-sm-offset-1"><input type="text" name="name[]" class="form-control" for="var'+varCount3+'" id="var'+varCount3+'" placeholder="奖项名称"></div>'
        + '<div class="col-sm-2" style="margin-left:-20px;"><input type="number" name="num[]" min="1" class="form-control" for="var'+varCount3+'" id="var'+varCount3+'" placeholder="位"></div>'
        + '<div class="col-sm-4" style="margin-left:-20px;"><input type="text" name="detail[]" class="form-control" for="var'+varCount3+'" id="var'+varCount3+'" placeholder=""></div>'
        + '<span class="removeVar3">-</span></div>';
        //新表单项添加到“新增”按钮前面
        $(this).parent().before($node);
      });

      //删除按钮点击
      $('form').on('click', '.removeVar3', function(){
        $(this).parent().remove();
        varCount3--;
      });

      /*投稿要求*/

      /*点击仅限单张隐藏*/
      $('#only').on('click',function(){
        if($(this).is(":checked")){
          $('.div1').hide();
        }else{
          $('.div1').show();
        }
      })

      /*点击免费*/
      $('#only2').on('click',function(){
        if($(this).is(":checked")){
          $('.div2').hide();
        }
      })

      $('#only1').on('click',function(){
        if($(this).is(":checked")){
          $('.div2').show();
        }
      })

      $('#only3').on('click',function(){
        if($(this).is(":checked")){
          $('.div2').show();
        }
      })
})
