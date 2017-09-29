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

    return {
        init: function () {
            // Carousel initialization for Featured side bar
            initFeaturedCarousel();
        }
    };
}();