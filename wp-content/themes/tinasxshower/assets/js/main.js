/**
 * Main JavaScript file for TinasXShower Theme
 *
 * @package TinasXShower
 */
(function($) {
    'use strict';
    
    // Document Ready
    $(document).ready(function() {
        // Initialize Hero Slider
        initHeroSlider();
        
        // Initialize Gallery Filters
        initGalleryFilters();
        
        // Initialize Contact Form
        initContactForm();
        
        // Initialize Smooth Scroll
        initSmoothScroll();
        
        // Initialize Mobile Menu
        initMobileMenu();
        
        // Initialize Scroll to Top
        initScrollToTop();
    });
    
    /**
     * Initialize Hero Slider
     */
    function initHeroSlider() {
        if ($('.hero-slider').length) {
            new Swiper('.hero-slider', {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        }
    }
    
    /**
     * Initialize Gallery Filters
     */
    function initGalleryFilters() {
        if ($('.gallery-filters').length) {
            $('.filter-btn').on('click', function() {
                var filterValue = $(this).attr('data-filter');
                
                // Update active class
                $('.filter-btn').removeClass('active bg-primary text-white').addClass('bg-gray-200 text-gray-800');
                $(this).addClass('active bg-primary text-white').removeClass('bg-gray-200 text-gray-800');
                
                // Filter items
                if (filterValue === '*') {
                    $('.gallery-item').show();
                } else {
                    $('.gallery-item').hide();
                    $(filterValue).show();
                }
                
                return false;
            });
        }
    }
    
    /**
     * Initialize Contact Form
     */
    function initContactForm() {
        $('#tinasxshower-contact-form').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var responseDiv = form.find('.form-response');
            var submitBtn = form.find('button[type="submit"]');
            
            // Disable submit button
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + submitBtn.text());
            
            // Clear previous messages
            responseDiv.removeClass('text-green-500 text-red-500').addClass('hidden').html('');
            
            // Get form data
            var formData = {
                action: 'tinasxshower_contact_form',
                name: form.find('input[name="name"]').val(),
                email: form.find('input[name="email"]').val(),
                phone: form.find('input[name="phone"]').val(),
                service: form.find('select[name="service"]').val(),
                message: form.find('textarea[name="message"]').val(),
                nonce: tinasxshower_ajax.nonce
            };
            
            // Send AJAX request
            $.post(tinasxshower_ajax.ajax_url, formData, function(response) {
                if (response.success) {
                    // Show success message
                    responseDiv.removeClass('hidden').addClass('text-green-500').html(response.data.message);
                    
                    // Reset form
                    form[0].reset();
                } else {
                    // Show error message
                    responseDiv.removeClass('hidden').addClass('text-red-500').html(response.data.message);
                }
                
                // Re-enable submit button
                submitBtn.prop('disabled', false).html(submitBtn.text().replace('<i class="fas fa-spinner fa-spin"></i> ', ''));
            }).fail(function() {
                // Show error message
                responseDiv.removeClass('hidden').addClass('text-red-500').html('Ha ocurrido un error. Por favor, inténtalo de nuevo más tarde.');
                
                // Re-enable submit button
                submitBtn.prop('disabled', false).html(submitBtn.text().replace('<i class="fas fa-spinner fa-spin"></i> ', ''));
            });
        });
    }
    
    /**
     * Initialize Smooth Scroll
     */
    function initSmoothScroll() {
        // Smooth scroll for anchor links
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                    return false;
                }
            }
        });
    }
    
    /**
     * Initialize Mobile Menu
     */
    function initMobileMenu() {
        $('.mobile-menu-toggle').on('click', function() {
            $('.mobile-menu').toggleClass('hidden');
            $('body').toggleClass('menu-open');
        });
        
        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.mobile-menu, .mobile-menu-toggle').length && !$('.mobile-menu').hasClass('hidden')) {
                $('.mobile-menu').addClass('hidden');
                $('body').removeClass('menu-open');
            }
        });
    }
    
    /**
     * Initialize Scroll to Top
     */
    function initScrollToTop() {
        var scrollToTopBtn = $('.scroll-to-top');
        
        // Show/hide button based on scroll position
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                scrollToTopBtn.addClass('show');
            } else {
                scrollToTopBtn.removeClass('show');
            }
        });
        
        // Scroll to top when button is clicked
        scrollToTopBtn.on('click', function() {
            $('html, body').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    }
    
})(jQuery);