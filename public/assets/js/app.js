$(function () {
    const $slider = $('.js-hero-slider');

    if ($slider.length === 0) {
        return;
    }

    const $slides = $slider.find('.hero-slider__slide'),
        $dots = $slider.find('.js-hero-slider-dot'),
        $prev = $slider.find('.js-hero-slider-prev'),
        $next = $slider.find('.js-hero-slider-next');

    const autoPlayDelay = 5000;
    let currentIndex = 0;
    let autoPlayTimer = null;

    function showSlide(index) {
        if (index < 0) {
            index = $slides.length - 1;
        }

        if (index >= $slides.length) {
            index = 0;
        }

        $slides.removeClass('is-active').eq(index).addClass('is-active');
        $dots.removeClass('is-active').eq(index).addClass('is-active');

        currentIndex = index;
    }

    function showNextSlide() {
        showSlide(currentIndex + 1);
    }

    function startAutoPlay() {
        if ($slides.length <= 1) {
            return;
        }

        stopAutoPlay();

        autoPlayTimer = window.setInterval(function () {
            showNextSlide();
        }, autoPlayDelay);
    }

    function stopAutoPlay() {
        if (autoPlayTimer !== null) {
            window.clearInterval(autoPlayTimer);
            autoPlayTimer = null;
        }
    }

    $prev.on('click', function () {
        showSlide(currentIndex - 1);
        startAutoPlay();
    });

    $next.on('click', function () {
        showNextSlide();
        startAutoPlay();
    });

    $dots.on('click', function () {
        showSlide(Number($(this).data('slide-index')));
        startAutoPlay();
    });

    $slider.on('mouseenter', function () {
        stopAutoPlay();
    });

    $slider.on('mouseleave', function () {
        startAutoPlay();
    });

    startAutoPlay();
});