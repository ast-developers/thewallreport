var App = function () {
    var initFeaturedCarousel = function () {
        if ($('.owl-carousel').length) {
            $('.owl-carousel').owlCarousel({
                loop: true,
                items: 1,
                margin: 10,
                nav: true,
                smartSpeed: 800,
                autoHeight: true
            })
        }
    };

    var manageStickyHeader = function () {
        // Hide Header on on scroll down
        var didScroll;
        var lastScrollTop = 0;
        var delta = 5;
        var navbarHeight = $('nav').outerHeight();

        $(window).scroll(function(event){
            didScroll = true;
        });

        setInterval(function() {
            if (didScroll && $(window).width() >= 768) {
                hasScrolled();
                didScroll = false;
            }
        }, 250);

        function hasScrolled() {
            var st = $(this).scrollTop();
            // If they scrolled down and are past the navbar, add class .nav-up.
            // This is necessary so you never see what is "behind" the navbar.
            if (st > lastScrollTop && st > navbarHeight){
                // Scroll Down
                if(st > 225) {
                    $('#header').removeClass('nav-down').addClass('nav-up');
                }else{
                    $('#header').removeClass('nav-up');
                }
            } else {
                // Scroll Up
                if(st > 180) {
                    $('#header').removeClass('nav-up').addClass('nav-down');
                }else{
                    $('#header').removeClass('nav-down');
                }
            }

            lastScrollTop = st;
        }
    }

    return {
        init: function () {
            // Carousel initialization for Featured side bar
            initFeaturedCarousel();
        },
        manageHeader: function () {
            manageStickyHeader()
        }
    };
}();
