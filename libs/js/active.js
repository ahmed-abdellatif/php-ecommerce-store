(function ($) {
    'use strict';

    var $window = $(window);
    
    // Fullscreen Active Code
    $window.on('resizeEnd', function () {
        $(".full_height").height($window.height());
    });

    $window.on('resize', function () {
        if (this.resizeTO) clearTimeout(this.resizeTO);
        this.resizeTO = setTimeout(function () {
            $(this).trigger('resizeEnd');
        }, 300);
    }).trigger("resize");

    // Welcome Slider Active Code
    if ($.fn.owlCarousel) {
        var wel_slides = $('.welcome_slides');
        wel_slides.owlCarousel({
            items: 1,
            margin: 0,
            loop: true,
            nav: false,
            dots: true,
            nav: true,
            navText: ['<i class="ti-arrow-left"></i>','<i class="ti-arrow-right"></i>'],
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 800,
            autoplayHoverPause: false,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut'
        });

        wel_slides.on('translate.owl.carousel', function () {
            var layer = $("[data-animation]");
            layer.each(function () {
                var anim_name = $(this).data('animation');
                $(this).removeClass('animated ' + anim_name).css('opacity', '0');
            });
        });

        $("[data-delay]").each(function () {
            var anim_del = $(this).data('delay');
            $(this).css('animation-delay', anim_del);
        });

        $("[data-duration]").each(function () {
            var anim_dur = $(this).data('duration');
            $(this).css('animation-duration', anim_dur);
        });

        wel_slides.on('translated.owl.carousel', function () {
            var layer = wel_slides.find('.owl-item.active').find("[data-animation]");
            layer.each(function () {
                var anim_name = $(this).data('animation');
                $(this).addClass('animated ' + anim_name).css('opacity', '1');
            });
        });
    }

    // New Arrivals Slider Active Code
    if ($.fn.owlCarousel) {
        $(".new_arrivals_slides, .you_make_like_slider").owlCarousel({
            items: 4,
            margin: 30,
            loop: true,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            autoplay: true,
            smartSpeed: 1500,
            autoplayTimeout: 7000,
            autoplayHoverPause: true,
            responsive: {
                320: {
                    items: 1
                },
                576: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });
        
        // Featured Product Slider Active Code
        $(".featured_product_slides").owlCarousel({
            items: 2,
            margin: 30,
            loop: true,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            autoplay: true,
            smartSpeed: 1500,
            autoplayTimeout: 7000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                }
            }
        });
        
        // Popular Items Active Code
        $(".popular_items_slides").owlCarousel({
            items: 4,
            margin: 30,
            loop: true,
            nav: false,
            dots: false,
            autoplay: true,
            smartSpeed: 1500,
            autoplayTimeout: 7000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 3
                },
                992: {
                    items: 4
                }
            }
        });
        
        // Popular Brands Slider Active Code
        $(".popular_brands_slide").owlCarousel({
            items: 6,
            margin: 30,
            loop: true,
            nav: false,
            dots: false,
            center: false,
            autoplay: true,
            smartSpeed: 800,
            responsive: {
                0: {
                    items: 2
                },
                480: {
                    items: 3
                },
                768: {
                    items: 4
                },
                992: {
                    items: 6
                }
            }
        });
        // Testimonials Slider Active Code
        $(".testimonials_slides").owlCarousel({
            items: 3,
            margin: 50,
            loop: true,
            dots: true,
            center: true,
            autoplay: true,
            smartSpeed: 1200,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                768: {
                    items: 3
                }
            }
        });
    }

    // Cart & User Active Code
    $('#header-cart-btn').on('click', function () {
        $('body').toggleClass('cart-data-open');
    })
    $('#header-user-btn').on('click', function () {
        $('body').toggleClass('user-data-open');
    })

    // Navigation Active Code
    if ($.fn.navigation) {
        $("#bigshop-nav").navigation();
    }

    // Popup Video Active Code
    if ($.fn.magnificPopup) {
        $('.video_btn').magnificPopup({
            disableOn: 0,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: true,
            fixedContentPos: false
        });
        $('.gallery_img').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
        $('.size_guide_img').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    }

    // ScrollUp Active Code
    if ($.fn.scrollUp) {
        $.scrollUp({
            scrollSpeed: 1000,
            easingType: 'easeInOutQuart',
            scrollText: '<i class="ti-angle-up" aria-hidden="true"></i>'
        });
    }

    // Counterup Active Code
    if ($.fn.counterUp) {
        $('.counter').counterUp({
            delay: 10,
            time: 2000
        });
    }

    // Countdown Active Code
    $('[data-countdown]').each(function () {
        var $this = $(this),
            finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function (event) {
            $(this).find(".days").html(event.strftime("%D"));
            $(this).find(".hours").html(event.strftime("%H"));
            $(this).find(".minutes").html(event.strftime("%M"));
            $(this).find(".seconds").html(event.strftime("%S"));
        });
    });

    // Masonary Gallery Active Code
    $('.gallery_full_width_images_area, .portfolio-column, .blog-masonary').imagesLoaded(function () {
        // filter items on button click
        $('.portfolio-menu').on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
        });
        var $grid = $('.gallery_full_width_images_area, .portfolio-column, .blog-masonary').isotope({
            itemSelector: '.single_gallery_item, .column_single_gallery_item, .sb_masonary_item',
            percentPosition: true,
            masonry: {
                columnWidth: '.single_gallery_item, .column_single_gallery_item, .sb_masonary_item'
            }
        });
    });

    // Jarallax Active Code
    if ($.fn.jarallax) {
        $('.jarallax').jarallax({
            speed: 0.2
        });
    }

    $(function () {
        $('[data-toggle="popover"]').popover({
            html: true,
            trigger: 'hover',
            content: function () {
                return '<img src="' + $(this).data('img') + '" />';
            }
        })
    })

    // MatchHeight Active Code
    if ($.fn.matchHeight) {
        $('.item').matchHeight();
    }

    // Price Range Active Code
    $('.slider-range-price').each(function () {
        var min = jQuery(this).data('min');
        var max = jQuery(this).data('max');
        var unit = jQuery(this).data('unit');
        var value_min = jQuery(this).data('value-min');
        var value_max = jQuery(this).data('value-max');
        var label_result = jQuery(this).data('label-result');
        var t = $(this);
        $(this).slider({
            range: true,
            min: min,
            max: max,
            values: [value_min, value_max],
            slide: function (event, ui) {
                var result = label_result + " " + unit + ui.values[0] + ' - ' + unit + ui.values[1];
                console.log(t);
                t.closest('.slider-range').find('.range-price').html(result);
            }
        });
    })

    // PreventDefault a Click
    $("a[href='#']").on('click', function ($) {
        $.preventDefault();
    });

    // Sticky Active Code
    $("#stickyHeader").sticky({
        topSpacing: 0
    });

    // wow Active Code
    if ($window.width() > 767) {
        new WOW().init();
    }

})(jQuery);