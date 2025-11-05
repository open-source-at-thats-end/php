(function($) {
    "use strict";

    function toggleSticky() {
        if ($('.sp-agent-section').length > 0) {
            var windowWidth = $(window).width();
            var footerHeight = $('.footer').height() + 360;
            var topSpacing = 182;

            if (windowWidth > 991) {
                $('.sp-agent-section').sticky({
                    topSpacing: topSpacing, 
                    bottomSpacing: footerHeight
                });
            } else {
                $('.sp-agent-section').unstick();
            }
        }
    }

    function windowResizeHandler() {
        toggleSticky();
    }

    windowResizeHandler();

    $(window).resize(function() {
        windowResizeHandler();
    });

    function onContentScroll() {
        if (window.pageYOffset > 93) {
            $('.re-header').addClass('is-sticky');
        } else {
            $('.re-header').removeClass('is-sticky');
        }
    }

    window.onscroll = function() {
        onContentScroll();
    };

    var animateHTML = function() {
        var elems;
        var windowHeight;

        function init() {
            elems = document.querySelectorAll('.main-animate-in');
            windowHeight = window.innerHeight;
            addEventHandlers();
            checkPosition();
        }

        function addEventHandlers() {
            window.addEventListener('scroll', checkPosition);
            window.addEventListener('resize', init);
        }

        function checkPosition() {
            for (var i = 0; i < elems.length; i++) {
                var positionFromTop = elems[i].getBoundingClientRect().top;

                if (positionFromTop - windowHeight <= 0) {
                    elems[i].classList.add('in');
                }
            }
        }

        return {
            init: init
        };
    };

    if ($('.hero-has-animation').length > 0) {
        setTimeout(function() {
            $('.hero-has-animation').addClass('hero-animate');
        }, 100);
    }

    animateHTML().init();

    if ($('.property-carousel-right-stage').length > 0) {
        $('.property-carousel-right-stage').owlCarousel({
            'nav': true,
            'dots': false,
            'margin': 30,
            'responsive': {
                0: {
                    'items': 1
                },
                600: {
                    'items': 2,
                    'stagePadding': 30
                },
                900: {
                    'items': 3,
                    'stagePadding': 60
                },
                1200: {
                    'items': 3,
                    'stagePadding': 120
                },
                1600: {
                    'items': 4,
                    'stagePadding': 120
                }
            },
            'navText': [`<div class="props-carousel-left-arrow main-animate">
                            <svg xmlns="https://www.w3.org/2000/svg" width="32.414" height="20.828" viewBox="0 0 32.414 20.828" class="arrow-1">
                                <g id="Group_30" data-name="Group 30" transform="translate(-1845.086 -1586.086)">
                                    <line id="Line_2" data-name="Line 2" x1="30" transform="translate(1846.5 1596.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                    <line id="Line_3" data-name="Line 3" x1="9" y2="9" transform="translate(1846.5 1587.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                    <line id="Line_4" data-name="Line 4" x1="9" y1="9" transform="translate(1846.5 1596.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                </g>
                            </svg>
                        </div>`,
                        `<div class="property-carousel-right-arrow main-animate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32.414" height="20.828" viewBox="0 0 32.414 20.828">
                                <g id="Symbol_1_1" data-name="Symbol 1 – 1" transform="translate(-1847.5 -1589.086)">
                                    <line id="Line_2" data-name="Line 2" x2="30" transform="translate(1848.5 1599.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                    <line id="Line_3" data-name="Line 3" x2="9" y2="9" transform="translate(1869.5 1590.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                    <line id="Line_4" data-name="Line 4" y1="9" x2="9" transform="translate(1869.5 1599.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                </g>
                            </svg>
                        </div>`],
            'checkVisible': false,
            'smartSpeed': 600
        });
    }

    if ($('.property-carousel-right-stage-1').length > 0) {
        $('.property-carousel-right-stage-1').owlCarousel({
            'nav': true,
            'dots': false,
            'margin': 30,
            'responsive': {
                0: {
                    'items': 1
                },
                600: {
                    'items': 2,
                },
                900: {
                    'items': 2,
                    'stagePadding': 30
                },
                1200: {
                    'items': 3,
                    'stagePadding': 30
                },
                1600: {
                    'items': 3,
                    'stagePadding': 120
                }
            },
            'navText': [`<div class="props-carousel-left-arrow main-animate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32.414" height="20.828" viewBox="0 0 32.414 20.828">
                                <g id="Group_30" data-name="Group 30" transform="translate(-1845.086 -1586.086)">
                                    <line id="Line_2" data-name="Line 2" x1="30" transform="translate(1846.5 1596.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                    <line id="Line_3" data-name="Line 3" x1="9" y2="9" transform="translate(1846.5 1587.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                    <line id="Line_4" data-name="Line 4" x1="9" y1="9" transform="translate(1846.5 1596.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                </g>
                            </svg>
                        </div>`,
                        `<div class="property-carousel-right-arrow main-animate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32.414" height="20.828" viewBox="0 0 32.414 20.828">
                                <g id="Symbol_1_1" data-name="Symbol 1 – 1" transform="translate(-1847.5 -1589.086)">
                                    <line id="Line_2" data-name="Line 2" x2="30" transform="translate(1848.5 1599.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                    <line id="Line_3" data-name="Line 3" x2="9" y2="9" transform="translate(1869.5 1590.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                    <line id="Line_4" data-name="Line 4" y1="9" x2="9" transform="translate(1869.5 1599.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                </g>
                            </svg>
                        </div>`],
            'checkVisible': false,
            'smartSpeed': 600
        });
    }

    if ($('.services-c-stage').length > 0) {
        $('.services-c-stage').owlCarousel({
            'nav': true,
            'dots': false,
            'margin': 30,
            'responsive': {
                0: {
                    'items': 1
                },
                600: {
                    'items': 2,
                },
                900: {
                    'items': 2,
                },
                1200: {
                    'items': 3,
                },
            },
            'navText': [`<svg xmlns="http://www.w3.org/2000/svg" width="32.414" height="20.828" viewBox="0 0 32.414 20.828">
                            <g id="Group_30" data-name="Group 30" transform="translate(-1845.086 -1586.086)">
                                <line id="Line_2" data-name="Line 2" x1="30" transform="translate(1846.5 1596.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                <line id="Line_3" data-name="Line 3" x1="9" y2="9" transform="translate(1846.5 1587.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                <line id="Line_4" data-name="Line 4" x1="9" y1="9" transform="translate(1846.5 1596.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                            </g>
                        </svg>`,
                        `<svg xmlns="http://www.w3.org/2000/svg" width="32.414" height="20.828" viewBox="0 0 32.414 20.828">
                            <g id="Symbol_1_1" data-name="Symbol 1 – 1" transform="translate(-1847.5 -1589.086)">
                                <line id="Line_2" data-name="Line 2" x2="30" transform="translate(1848.5 1599.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                <line id="Line_3" data-name="Line 3" x2="9" y2="9" transform="translate(1869.5 1590.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                <line id="Line_4" data-name="Line 4" y1="9" x2="9" transform="translate(1869.5 1599.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                            </g>
                        </svg>`],
            'checkVisible': false,
            'smartSpeed': 600
        });
    }

    if ($('.testim-1-stage').length > 0) {
        $('.testim-1-stage').owlCarousel({
            'nav': true,
            'dots': false,
            'margin': 30,
            'responsive': {
                0: {
                    'items': 1
                },
                600: {
                    'items': 2,
                },
                900: {
                    'items': 2,
                },
                1200: {
                    'items': 3,
                },
            },
            'navText': [`<svg xmlns="http://www.w3.org/2000/svg" width="32.414" height="20.828" viewBox="0 0 32.414 20.828">
                            <g id="Group_30" data-name="Group 30" transform="translate(-1845.086 -1586.086)">
                                <line id="Line_2" data-name="Line 2" x1="30" transform="translate(1846.5 1596.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                <line id="Line_3" data-name="Line 3" x1="9" y2="9" transform="translate(1846.5 1587.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                <line id="Line_4" data-name="Line 4" x1="9" y1="9" transform="translate(1846.5 1596.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                            </g>
                        </svg>`,
                        `<svg xmlns="http://www.w3.org/2000/svg" width="32.414" height="20.828" viewBox="0 0 32.414 20.828">
                            <g id="Symbol_1_1" data-name="Symbol 1 – 1" transform="translate(-1847.5 -1589.086)">
                                <line id="Line_2" data-name="Line 2" x2="30" transform="translate(1848.5 1599.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                <line id="Line_3" data-name="Line 3" x2="9" y2="9" transform="translate(1869.5 1590.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                                <line id="Line_4" data-name="Line 4" y1="9" x2="9" transform="translate(1869.5 1599.5)" fill="none" stroke="#333" stroke-linecap="round" stroke-width="2"/>
                            </g>
                        </svg>`],
            'checkVisible': false,
            'smartSpeed': 600
        });
    }

    var heroPropCarouselItems = 1;

    $('.hero-props-carousel-1 .carousel-item').each(function(index, element) {
        if (index == 0) {
            $('.hero-props-carousel-1-prices').addClass('price-active first-time');
        }

        $('.hero-props-carousel-1-prices .carousel-ticker-counter').append('<span>0' + heroPropCarouselItems + '</span>');

        heroPropCarouselItems += 1;
    });

    $('.hero-props-carousel-1-prices .carousel-ticker-total').append('<span>0' + $('.hero-props-carousel-1 .carousel-item').length + '</span>');

    $('.hero-props-carousel-1').on('slide.bs.carousel', function(carousel) {
        $('.hero-props-carousel-1-prices').removeClass('first-time');
        $('.hero-props-carousel-1-prices').carousel(carousel.to);
    });

    $('.hero-props-carousel-1').on('slid.bs.carousel', function(carousel) {
        var tickerPos = (carousel.to) * 13;

        $('.hero-props-carousel-1-prices .carousel-ticker-counter > span').css('transform', 'translateY(-' + tickerPos + 'px)');
    });

    $('.hero-props-carousel-1 .carousel-control-next').click(function(e) { 
        $('.hero-props-carousel-1').carousel('next');
    });
    $('.hero-props-carousel-1 .carousel-control-prev').click(function(e) { 
        $('.hero-props-carousel-1').carousel('prev');
    });

    $('.hero-props-carousel-2-right').on('slide.bs.carousel', function(carousel) {
        if(carousel.direction == 'left') {
            $('.hero-props-carousel-2-left').carousel('next');
        } else {
            $('.hero-props-carousel-2-left').carousel('prev');
        }
    });

    $('.hero-props-carousel-2 .carousel-control-next').click(function(e) { 
        $('.hero-props-carousel-2-right').carousel('next');
    });
    $('.hero-props-carousel-2 .carousel-control-prev').click(function(e) { 
        $('.hero-props-carousel-2-right').carousel('prev');
    });

    var heroPropCarousel2Items = 1;

    $('.hero-props-carousel-2-right .carousel-item').each(function(index, element) {
        $('.hero-props-carousel-2 .carousel-ticker-counter').append('<span>0' + heroPropCarousel2Items + '</span>');

        heroPropCarousel2Items += 1;
    });

    $('.hero-props-carousel-2 .carousel-ticker-total').append('<span>0' + $('.hero-props-carousel-2-right .carousel-item').length + '</span>');

    $('.hero-props-carousel-2-right').on('slid.bs.carousel', function(carousel) {
        var tickerPos = (carousel.to) * 13;

        $('.hero-props-carousel-2 .carousel-ticker-counter > span').css('transform', 'translateY(-' + tickerPos + 'px)');
    });

    $('.sp-more').click(function(e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;

        $(this).prev('p').find('.dots').toggle();
        $(this).prev('p').find('.dots-more').slideToggle();
        $(this).toggleClass('sp-less');
    });

    if ($('#calculator-chart').length > 0) {
        var calculatorChartElem = document.getElementById('calculator-chart').getContext('2d');
        var calculatorChart = new Chart(calculatorChartElem, {
            type: 'doughnut',
            data: {
                labels: ['Principal and Interest', 'Property Taxes', 'HOA Dues'],
                datasets: [{
                    data: [0, 0, 0],
                    backgroundColor: ['rgba(0, 112, 201, 1)', 'rgba(75, 154, 217, 1)', 'rgba(153, 198, 233, 1)'],
                    borderWidth: [2, 2, 2],
                    hoverBackgroundColor: ['rgba(0, 112, 201, 1)', 'rgba(75, 154, 217, 1)', 'rgba(153, 198, 233, 1)'],
                    hoverBorderWidth: [2, 2, 2],
                    hoverBorderColor: ['rgba(0, 112, 201, 0.10)', 'rgba(75, 154, 217, 0.10)', 'rgba(153, 198, 233, 0.10)']
                }],
            },
            options: {
                responsive: true,
                cutoutPercentage: 90,
                tooltips: {
                    enabled: false
                },
                legend: {
                    display: false,
                }
            }
        });
    }

    function updateCalculatorInfo() {
        var term           = $('#calculator-form-term').val();
        var interest       = $('#calculator-form-interest').val();
        var price          = $('#calculator-form-price').val();
        var downPrice      = $('#calculator-form-down-price').val();
        var downPercentage = $('#calculator-form-down-percentage').val();
        var taxes          = $('#calculator-form-property-taxes').val();
        var dues           = $('#calculator-form-hoa-dues').val();

        var termValue = term;
        var interestValue = interest.replace('%', '');
        var priceValue = price.replace(/\D+/g, '');
        var downPriceValue = downPrice;
        var downPercentageValue = downPercentage.replace('%', '');
        var taxesValue = taxes.replace(/\D+/g, '');
        var duesValue = dues.replace(/\D+/g, '');

        var dpa   = parseFloat(downPercentageValue) * parseFloat(priceValue) / 100;
        var ma    = parseFloat(priceValue) - dpa;
        var r     = parseFloat(interestValue) / 12 / 100;
        var n     = parseFloat(termValue) * 12;
        var tmp   = Math.round(ma * (r * Math.pow((1 + r), n)) / (Math.pow((1 + r), n) - 1));
        var total = tmp + parseFloat(taxesValue) + parseFloat(duesValue);

        $('#calculator-data-pi').text('$' + tmp.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','));
        $('#calculator-data-pt').text(taxes);
        $('#calculator-data-hd').text(dues);
        $('.calculator-chart-result-sum').text('$' + total.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','));

        calculatorChart.data.datasets[0].data = [tmp, taxesValue, duesValue];
        calculatorChart.update();
    }

    if ($('.calculator-form').length > 0) {
        updateCalculatorInfo();
    }

    $('.form-control-transform').focus(function() {
        var self_ = $(this);
        var inputValue = self_.val();
        var dataType = self_.attr('data-type');
        var newInputValue;

        if (dataType == 'currency') {
            newInputValue = inputValue.replace(/\D+/g, '');
        } else if (dataType == 'percent') {
            newInputValue = inputValue.replace('%', '');
        }

        self_.val(newInputValue);
        self_.attr('type', 'number');

        if (dataType == 'percent') {
            self_.attr('min', '0');
            self_.attr('max', '100');
        }
    });

    $('.form-control-transform').blur(function() {
        var self_ = $(this);
        var inputValue = self_.val();
        var dataType = self_.attr('data-type');
        var newInputValue;

        if (dataType == 'currency') {
            newInputValue = '$' + inputValue.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        } else if (dataType == 'percent') {
            newInputValue = inputValue.replace(/\,/g, '.') + '%';
        }

        self_.attr('type', 'text');

        if (dataType == 'percent') {
            self_.removeAttr('min');
            self_.removeAttr('max');
        }

        self_.val(newInputValue);
    });

    $('#calculator-form-down-price').on('keyup change', function() {
        var price     = $('#calculator-form-price').val();
        var downPrice = $(this).val();

        var priceValue = price.replace(/\D+/g, '');
        var downPercentage = (parseFloat(downPrice) * 100 / parseFloat(priceValue)).toFixed(2);
        var newDownPercentage = downPercentage.toString() + '%';

        $('#calculator-form-down-percentage').val(newDownPercentage);

        updateCalculatorInfo();
    });

    $('#calculator-form-down-percentage').on('keyup change', function() {
        var price          = $('#calculator-form-price').val();
        var downPercentage = $(this).val();

        var priceValue = price.replace(/\D+/g, '');
        var downPrice = Math.round(parseFloat(downPercentage) * parseFloat(priceValue) / 100);
        var newDownPrice = '$' + downPrice.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        $('#calculator-form-down-price').val(newDownPrice);

        updateCalculatorInfo();
    });

    $('#calculator-form-price').on('keyup change', function() {
        var price          = $(this).val();
        var downPercentage = $('#calculator-form-down-percentage').val();

        var priceValue = price.replace(/\D+/g, '');
        var downPrice = Math.round(parseFloat(downPercentage) * parseFloat(priceValue) / 100);
        var newDownPrice = '$' + downPrice.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        $('#calculator-form-down-price').val(newDownPrice);

        updateCalculatorInfo();
    });

    $('#calculator-form-interest').on('keyup change', function() {
        updateCalculatorInfo();
    });

    $('#calculator-form-term').on('change', function() {
        updateCalculatorInfo();
    });

    $('.blog-posts-carousel-1 .carousel-control-next').click(function(e) { 
        $('.blog-posts-carousel-1-img').carousel('next');
    });
    $('.blog-posts-carousel-1 .carousel-control-prev').click(function(e) { 
        $('.blog-posts-carousel-1-img').carousel('prev');
    });

    $('.blog-posts-carousel-1-img').on('slide.bs.carousel', function(carousel) {
        if(carousel.direction == 'left') {
            $('.blog-posts-carousel-1-caption').carousel('next');
        } else {
            $('.blog-posts-carousel-1-caption').carousel('prev');
        }
    });

    // Animate nav sub menu
    $('.nav > li').hover(function() {
        var subMenu = $(this).children('ul:first');

        if (subMenu.length > 0 && !$('.re-header').hasClass('mobile')) {
            var subMenuWidth  = subMenu.width();
            var menuItemLeft  = $(this).offset().left;
            var windowWidth   = $(window).width();
            var menuItemRight = windowWidth - menuItemLeft;

            if (menuItemRight < subMenuWidth) {
                subMenu.css({
                    'right': '0',
                    'left': 'auto'
                });
            }

            subMenu.fadeIn({ queue: false, duration: 200 });
            subMenu.animate({ top: "24px" }, 200);
        }
    }, function() {
        var subMenu = $(this).children('ul:first');

        if (subMenu.length > 0  && !$('.re-header').hasClass('mobile')) {
            subMenu.fadeOut({ queue: false, duration: 200 });
            subMenu.animate({ top: "10px" }, 200);
        }
    });

    $('.re-header-nav-trigger').click(function() {
        $(this).toggleClass('active');
        $('.logo').toggleClass('logo-nav');
        $('.re-header').toggleClass('mobile');
        $('.nav').toggle();
    });

    $('.blog-post-video').click(function() {
        $(this).hide().next('iframe').show();
    });

    // Handle agent rating system
    function clearAgentRating() {
        $('.single-agent-rating span').removeClass('selected');
    }
    $('.single-agent-rating span').click(function() {
        clearAgentRating();
        $(this).addClass('selected');
    });

    $('.map-toggle').click(function () {
        $('.map-side').addClass('max');
        $('.content-side').addClass('min');
        $('.list-toggle').show();
    });

    $('.list-toggle').click(function() {
        $('.map-side').removeClass('max');
        $('.content-side').removeClass('min');
        $('.list-toggle').hide();
    });

    $('.adv-toggle').click(function () {
        $(this).toggleClass('active');
        $('.content-side-search-form-adv').slideToggle();
    });

    $('.signin-trigger').click(function() {
        $('#signup-modal').modal('hide');
        $('#signin-modal').modal('show');
    });
    $('.signup-trigger').click(function() {
        $('#signin-modal').modal('hide');
        $('#signup-modal').modal('show');
    });
    $('#signin-modal').on('shown.bs.modal', function () {
        $('body').addClass('modal-open');
    });
    $('#signup-modal').on('shown.bs.modal', function () {
        $('body').addClass('modal-open');
    });

    $('.results-card-1 .carousel-control-next').click(function(event) {
        event.preventDefault();
        var target = $(this).attr('data-href');

        $(target).carousel('next');
    });
    $('.results-card-1 .carousel-control-prev').click(function(event) {
        event.preventDefault()
        var target = $(this).attr('data-href');

        $(target).carousel('prev');
    });
})(jQuery);