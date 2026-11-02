$(document).ready(function() {

    const marqueeText = document.getElementById("marqueeText");

    function checkOverflow() {
        if (marqueeText.scrollWidth > marqueeText.clientWidth) {
            marqueeText.classList.add("marquee");
        } else {
            marqueeText.classList.remove("marquee");
        }
    }

// Run on page load
    checkOverflow();

// Run again on resize/orientation change
    window.addEventListener("resize", checkOverflow);
    window.addEventListener("orientationchange", checkOverflow);

    // Handle navbar open/close
    $('.navbar-open, .mobile-nav-toggle').on('click', function () {
        $('#navbar').toggleClass('navbar-mobile');
        $('.mobile-nav-toggle').toggleClass('d-block d-none');
    });

    // Handle dropdown click only in mobile mode
    $('#navbar').on('click', '.dropdown > a', function (e) {
        if ($('#navbar').hasClass('navbar-mobile')) {
            e.preventDefault();
            $(this).next('ul').toggleClass('dropdown-active');
        }
    });

    $(window).on('scroll resize', function() {
        if ($(window).width() >= 768) {
            if ($(window).scrollTop() >= 100) {
                $('.menubar').addClass('fixed-pc');
                $('.main_header').addClass('hide-header');
            } else {
                $('.menubar').removeClass('fixed-pc');
                $('.main_header').removeClass('hide-header');
            }
        } else {
            $('.menubar').removeClass('fixed-pc');
            $('.main_header').removeClass('hide-header');
        }
    });


});
