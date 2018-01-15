$(document).ready(function(){
    // 滚动轮播
    $('.owl-carousel').owlCarousel({
    loop:true,
    margin:30,
    autoWidth: true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        }
    }
    })
});