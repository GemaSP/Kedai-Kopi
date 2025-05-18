(function ($) {
    "use strict";

    // Date and Time Picker
    $('.date').datetimepicker({
        format: 'L'
    });
    $('.time').datetimepicker({
        format: 'LT'
    });
 
    // Testimonial Carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        margin: 30,
        dots: true,
        loop: true,
        center: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });
    // Back to top 
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        }
        else
        {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });
    $(document).ready(function () {
        $('#btnHot').click(function () {
            $('#hotMenu').removeClass('d-none');
            $('#coldMenu').addClass('d-none');
            $('#btnHot').addClass('active');
            $('#btnCold').removeClass('active');
        });

        $('#btnCold').click(function () {
            $('#coldMenu').removeClass('d-none');
            $('#hotMenu').addClass('d-none');
            $('#btnCold').addClass('active');
            $('#btnHot').removeClass('active');
        });
    });
})(jQuery);