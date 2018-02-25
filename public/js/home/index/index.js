$(function(){
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:12
            },
            1000:{
                items:24
            }
        }
    })

    /*切换图标*/
    $('#collaborate .owl-prev').text('');
    $('#collaborate .owl-prev').append('<i class="fa fa-angle-left"></i>')
    $('#collaborate .owl-next').text('');
    $('#collaborate .owl-next').append('<i class="fa  fa-angle-right"></i>')
})