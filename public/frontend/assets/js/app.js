$('.portfolio-slider').slick({
    dots: false,
    arrows: false,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 0,
    speed: 5000,
    slidesToShow: 3,
    slidesToScroll: 1,
    cssEase: 'linear',
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
            }
        }
    ]
});


$('.portfolio-slider').on('mouseenter', function () {
    $(this).slick('slickPause');
});


$('.portfolio-slider').on('mouseleave', function () {
    $(this).slick('slickPlay');
});
