$(document).ready(function () {
    // 滚动轮播
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        autoWidth: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            }
        }
    })
    // 回到顶部
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
    $goTop.on('click', function () {
        $(window).scrollTop(0);
    });
});