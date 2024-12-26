var styleBackup = '', restOfTimeout = 500, currentState = '', freeze = false;
$('.portfolio-slider').on('init', function (event, slick, direction) {
    const observer = new MutationObserver(function (mutationsList, observer) {
        for (const mutation of mutationsList) {
            if (mutation.type === 'attributes' && mutation.attributeName == 'style' && freeze) {
                $('.portfolio-slider .slick-track').css('transform', currentState);
            }
        }
    });
    observer.observe($('.portfolio-slider .slick-track')[0], { attributes: true });
    $('.portfolio-slider .slick-track').mouseover(function () {
        styleBackup = $('.portfolio-slider .slick-track').attr('style');
        currentState = getComputedStyle($('.portfolio-slider .slick-track')[0]).transform;
        freeze = true;
        $('.portfolio-slider').slick('slickPause');
        let translateDone = parseFloat(currentState.split(',')[4]) * (-1);
        let regex = /translate3d\(([^,]*),/gm;
        if ((m = regex.exec(styleBackup)) !== null) {
            let translateNeed = parseFloat(m[1]) * (-1);
            let slideWidth = $('.portfolio-slider .slick-slide').first().width();
            let speed = 5000 / slideWidth;
            restOfTimeout = (translateNeed - translateDone) * speed;
        } else {
            restOfTimeout = 500;
        }
        $('.portfolio-slider .slick-track').css('transform', currentState);
    });
    $('.portfolio-slider .slick-track').mouseout(function () {
        freeze = false;
        $('.portfolio-slider .slick-track').attr('style', styleBackup.replace('5000ms', restOfTimeout + 'ms'));
        $('.portfolio-slider').slick('slickPlay');
    });
});

$('.portfolio-slider').slick({
    slidesToShow: 3,
    speed: 4000,
    autoplay: true,
    infinite: true,
    autoplaySpeed: 0,
    cssEase: 'linear',
    slidesToScroll: 1,
    pauseOnHover: false
});

// ToolTips
const showTooltips = () => {
    document
        .querySelectorAll('[data-tooltip="tooltip"]')
        .forEach(function (element) {
            new bootstrap.Tooltip(element, {
                html: true,
            });
        });
};

document.addEventListener("DOMContentLoaded", function () {
    showTooltips();
});


window.addEventListener("load", function () {
    const loader = document.getElementById("loader");
    if(loader){
        loader.style.display = "none";
    }
});
