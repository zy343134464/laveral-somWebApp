$(document).ready(function () {
/*    // 回到顶部
    var $goTop = $('<div id="go-top"><i class="fa fa-arrow-up"></i>回到顶部</div>');
    $('body').append($goTop);
    $(window).on('scroll', function (e) {
        var offsetTop = $('body').scrollTop();
        if (offsetTop > 100) {
            $goTop.show();
        } else {
            $goTop.hide();
        }
    })
    $goTop.on('click', function () {});
        $(window).scrollTop(0);
    });*/
$('header').on('click','.pull-right.personal-center',function(){
    $(this).toggleClass('open') ;
})
})