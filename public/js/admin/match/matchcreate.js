$(function () {
    /*赛事主题*/
    // 赛事详情页设置新增标题

    //初始参数个数

    var varCount = 1;
      //新增按钮点击
        $('#addVar').on('click', function(){
            varCount++;
            $node = '<div class="form-group"><label for="var'+varCount+'" id="var'+varCount+'" class="col-sm-2 control-label"></label>'
              + '<div class="col-sm-8"><input type="text" class="form-control" for="var'+varCount+'" id="var'+varCount+'"></div>'
              + '<span class="removeVar">-</span></div>';
        //新表单项添加到“新增”按钮前面
            $(this).parent().before($node);
        });

      //删除按钮点击
      $('form').on('click', '.removeVar', function(){
        $(this).parent().remove();
        varCount--;
    });


    /*组委会评选*/
    // 比赛合作方信息

    //初始参数个数
    var varCount1 = 1;
      //新增按钮点击
        $('#addVar1').on('click', function(){
            varCount1++;
            $node = '<div class="two-wrapper"><div class="form-group match-partner-add">'
              + '<div class="col-sm-5 col-sm-offset-2"><input type="text" class="form-control" for="var'+varCount1+'" id="var'+varCount1+'" placeholder="合作角色"></div></div>'
              + '<div class="form-group">'
              + '<div class="col-sm-5 col-sm-offset-2"><input type="text" class="form-control" for="var'+varCount1+'" id="var'+varCount1+'" placeholder="合作信息"></div>'
              + '<span class="removeVar1">-</span></div></div>';
        //新表单项添加到“新增”按钮前面
            $(this).parent().before($node);
        });

      //删除按钮点击
      $('form').on('click', '.removeVar1', function(){
        $(this).parent().parent().remove();
        varCount1--;
    });

    //主办方联系方式

    //初始参数个数
    var varCount2 = 1;
      //新增按钮点击
        $('#addVar2').on('click', function(){
            varCount2++;
            $node = '<div class="two-wrapper"><div class="form-group match-partner-add">'
              + '<div class="col-sm-5 col-sm-offset-2"><input type="text" class="form-control" for="var'+varCount2+'" id="var'+varCount2+'" placeholder="QQ/电话/微信"></div></div>'
              + '<div class="form-group">'
              + '<div class="col-sm-5 col-sm-offset-2"><input type="text" class="form-control" for="var'+varCount2+'" id="var'+varCount2+'" placeholder=""></div>'
              + '<span class="removeVar2">-</span></div></div>';
        //新表单项添加到“新增”按钮前面
            $(this).parent().before($node);
        });

      //删除按钮点击
      $('form').on('click', '.removeVar2', function(){
        $(this).parent().parent().remove();
        varCount2--;
    });

    // 评委及嘉宾
    $('.judgelist').on('mouseenter','li',function(){
        $(this).find('.close').css('display','block');
    })
    $('.judgelist').on('mouseleave','li',function(){
        $(this).find('.close').css('display','none');
    })


    // 奖项设置

    //初始参数个数
     var varCount3 = 1;
      //新增按钮点击
        $('#addVar3').on('click', function(){
            varCount++;
            $node = '<div class="form-group">'
              + '<div class="col-sm-2 col-sm-offset-1"><input type="text"  name="no[]"  class="form-control" for="var'+varCount3+'" id="var'+varCount3+'" placeholder="奖项等级" ></div>'
              + '<div class="col-sm-2" style="margin-left:-20px;"><input type="number"  name="num[]"  class="form-control" for="var'+varCount3+'" id="var'+varCount3+'" placeholder="位"></div>'
              + '<div class="col-sm-4" style="margin-left:-20px;"><input type="text"  name="detail[]"  class="form-control" for="var'+varCount3+'" id="var'+varCount3+'" placeholder=""></div>'
              + '<span class="removeVar3">-</span></div>';
        //新表单项添加到“新增”按钮前面
            $(this).parent().before($node);
        });

      //删除按钮点击
      $('form').on('click', '.removeVar3', function(){
        $(this).parent().remove();
        varCount3--;
    });
})