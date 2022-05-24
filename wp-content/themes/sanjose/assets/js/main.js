;(function($, window, document, undefined) {
    "use strict";

    var swipers = [], winW, winH, winScr, _isresponsive, smPoint = 768, mdPoint = 992, lgPoint = 1200, addPoint = 1600, _ismobile = navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i);

    if("function"!==typeof pageCalculations){var winW,winH,winS,pageCalculations,onEvent=window.addEventListener;pageCalculations=function(a){winW=window.innerWidth;winH=window.innerHeight;winS=document.body.scrollTop;a&&(onEvent("load",a,!0),onEvent("resize",a,!0),onEvent("orientationchange",a,!1))};pageCalculations(function(){pageCalculations()})};

    /*====================
          Preloader
    ====================*/
    $("#loading").delay(700).fadeOut("slow");

    var izotope_portfolio = function () {

        if ( $('.izotope-container').length ) {

            $('.izotope-container').each(function(){

                var $container = $(this).find('.portfolio-list');
                var $filter = $(this).find('.filters');

                /* Init isotope */
                if( $container.hasClass('fcampaign-masonry') ) {
                    $container.isotope({
                        itemSelector: '.item',
                        layoutMode: 'masonry',
                        masonry: {
                            columnWidth: '.item'
                        }
                    });
                } else {
                    $container.isotope({
                        itemSelector: '.item',
                        layoutMode: 'fitRows'
                    });
                }

                /* Filter */
                $filter.on('click', '.but', function() {

                    $filter.find('.but').removeClass('activbut');
                    $(this).addClass('activbut');

                    var filterValue = $(this).attr('data-filter');
                    $container.isotope({filter: filterValue});
                    return false;

                });
            });
        }
    }

    /*====================
          Main menu
    ====================*/
    var $mainMenu = $("#main-menu");

    // Get the mmenu API
    var mmenuApi = $mainMenu.data("mmenu");

    // mmenu init
    $mainMenu.mmenu({
        //options
        extensions: ["border-none", "fullscreen"],
        offCanvas: {
            zposition: "front",
            position: "bottom"
        },
        navbar: {
            title: "Menu"
        },
        navbars: {
            content: ["close"],
            height: 1
        }
    }, {
        // configuration
        clone: true
    });

    /*====================
        Background image
    ====================*/
    function sanjose_img_background(img_sel, parent_sel, img_height) {
        if (!img_sel) {
            console.info('no img selector');
            return false;
        }
        var $parent, _this;
        $(img_sel).each(function() {
            _this = $(this);
            $parent = _this.closest(parent_sel);
            $parent = $parent.length ? $parent : _this.parent();
            if (img_height) {
                $parent.css('background-image', 'url(' + this.src + ')');
                _this.css('visibility', 'hidden');
            } else {
                $parent.css('background-image', 'url(' + this.src + ')');
                _this.hide();
            }
        });
    }

    sanjose_img_background('.hidden-img');

    /*====================
         Swiper slider
     ====================*/
    function initSwiper() {
        var initIterator = 0;
        $('.swiper-container').each(function() {
            var $t = $(this);

            if ($t.find('.swiper-slide').length <= 1) {
                $t.find('.pagination').hide();
                $t.find('.swiper-slide').css('width', '100%');
                return 0;
            }

            var index = 'swiper-unique-id-' + initIterator;

            $t.addClass('swiper-' + index + ' initialized').attr('id', index);
            $t.find('.pagination').addClass('pagination-' + index);

            var verticalHeight = parseInt($t.attr('data-height'), 10);

            var autoPlayVar = parseInt($t.attr('data-autoplay'), 10);
            var mode = $t.attr('data-mode');
            var centerVar = parseInt($t.attr('data-center'), 10);
            var simVar = ($t.closest('.circle-description-slide-box').length) ? false : true;

            var slidesPerViewVar = $t.attr('data-slides-per-view');
            if (slidesPerViewVar == 'responsive') {
                slidesPerViewVar = updateSlidesPerView($t);
            } else if (slidesPerViewVar == 'auto') {
                slidesPerViewVar = 'auto'
            } else {
                slidesPerViewVar = parseInt(slidesPerViewVar, 10);
            }

            var loopVar = parseInt($t.attr('data-loop'), 10);
            var speedVar = parseInt($t.attr('data-speed'), 10);

            swipers['swiper-' + index] = new Swiper('.swiper-' + index, {
                speed: speedVar,
                pagination: '.pagination-' + index,
                loop: loopVar,
                paginationClickable: true,
                autoplay: autoPlayVar,
                slidesPerView: slidesPerViewVar,
                keyboardControl: true,
                calculateHeight: (verticalHeight == 0) ? false : true,
                simulateTouch: simVar,
                centeredSlides: centerVar,
                roundLengths: true,
                loopedSlides: 4,
                noSwiping: true,
                noSwipingClass: 'swiper-no-swiping',
                mode: mode || 'horizontal',
                onInit: function(swiper) {
                    galleryPopup();
                },
                onSlideChangeEnd: function(swiper) {
                    var activeIndex = (loopVar === 1) ? swiper.activeLoopIndex : swiper.activeIndex;
                },
                onSlideChangeStart: function(swiper) {
                    galleryPreview();
                    $t.find('.swiper-slide.active').removeClass('active');

                    var activeIndex = (loopVar === 1) ? swiper.activeLoopIndex : swiper.activeIndex;

                },
                onSlideClick: function(swiper) {

                }

            });

            swipers['swiper-' + index].reInit();
            if (!centerVar) {
                if ($t.attr('data-slides-per-view') == 'responsive') {
                    var paginationSpan = $t.find('.pagination span');
                    var paginationSlice = paginationSpan.hide().slice(0, (paginationSpan.length + 1 - slidesPerViewVar));
                    if (paginationSlice.length <= 1 || slidesPerViewVar >= $t.find('.swiper-slide').length) $t.addClass('pagination-hidden');
                    else $t.removeClass('pagination-hidden');
                    paginationSlice.css('display', 'inline-block');
                }
            }
            initIterator++;
        });
    }

    $('.slide-prev').on('click', function() {
        swipers['swiper-' + $(this).closest('.swiper-container').attr('id')].swipePrev();
        return false;
    });
    $('.slide-next').on('click', function() {
        swipers['swiper-' + $(this).closest('.swiper-container').attr('id')].swipeNext();
        return false;
    });

    function updateSlidesPerView(swiperContainer) {
        if (winW >= addPoint) return parseInt($(swiperContainer).attr('data-add-slides'), 10);
        else if (winW >= lgPoint) return parseInt($(swiperContainer).attr('data-lg-slides'), 10);
        else if (winW >= mdPoint) return parseInt($(swiperContainer).attr('data-md-slides'), 10);
        else if (winW >= smPoint) return parseInt($(swiperContainer).attr('data-sm-slides'), 10);
        else return parseInt($(swiperContainer).attr('data-xs-slides'), 10);
    }

    /*====================
        Pagination image
     ====================*/
    function paginationImg() {

        var paginationImg = $(".wpc-pagination-img");

        for ( var i = 0; i < paginationImg.length; i++) {

            var  paginationSwitch = $(paginationImg[i]).find(".swiper-pagination-switch");

            for ( var y = 0; y < paginationSwitch.length; y++) {

                var _this = $(paginationSwitch[y]);

                $(_this).append("<img src=' "+$(_this).closest(".swiper-container").find(".swiper-slide:not(.swiper-slide-duplicate)[data-numb-slide="+y+"]").attr("data-img-slide")+"' alt='' class='hidden-img'>");
            }
        }
    }

    /*====================
        Responsive video
    ====================*/
    if( $(".post-detail").length ) {
        $(".post-detail").fitVids();
    }
    
    /*====================
       Countdown counter
     ====================*/
    $(".countdown-item").each(function () {

        var countdown_percent       = $(this).data('percent');
        var countdown_border_width  = $(this).data('border-width');
        var countdown_counter_width = $(this).data('counter-width');
        var countdown_border_color  = $(this).data('border-color');
        var countdown_counter_color = $(this).data('counter-color');
        var countdown_number_color  = $(this).data('number-color');

        $(this).circliful({
            animationStep: 5,
            foregroundBorderWidth: countdown_counter_width,
            backgroundBorderWidth: countdown_border_width,
            percent: countdown_percent,
            foregroundColor: countdown_counter_color,
            backgroundColor: countdown_border_color,
            fontColor: countdown_number_color,
            percentageY: 110,
            percentageX: 104
        });
    });

    /*====================
         Load more blog
     ====================*/
    if (window.load_more_post) {
        var pageNum = 2;
        var nextLink = window.load_more_post.nextLink;
    }

    function load_more_post() {
        // The link of the next page of posts.
        if (window.load_more_post) {

            // The maximum number of pages the current query can return.
            var max = parseInt(window.load_more_post.maxPage);
            // wrapper selector
            var wrap_selector = '.js-load-post';

            var $btn = $('.load-btn'),
                $btnText = $btn.html();

            $btn.html('loading...');

            if( pageNum <= max ) {

                var $container = $(wrap_selector);
                $.ajax({
                    url:nextLink,
                    type: "get",
                    success: function(data){
                        $container.append( $(data).find(wrap_selector).html() );

                        var newElements = $(data).find('.js-load-post .post');
                        var elems = [];

                        newElements.each(function(i){
                            elems.push(this);
                        });

                        sanjose_img_background('.hidden-img');

                        $btn.html( $btnText );

                        pageNum++;
                        nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ pageNum);

                        if( pageNum == ( max + 1 ) ) {
                            $btn.hide('fast');
                        }
                    }
                });
            }
            return false;

        }
    }

    $('#load-more').on('click', function(){
        load_more_post();
    });

    // Load more team
    if (window.load_more_team) {
        var pageNum = 2;
        var nextLink = window.load_more_team.nextLink;
    }

    function load_more_team() {
        // The link of the next page of posts.
        if (window.load_more_team) {

            // The maximum number of pages the current query can return.
            var max = parseInt(window.load_more_team.maxPage);
            // wrapper selector
            var wrap_selector = '.js-load-team';

            var $btn = $('.load-btn'),
                $btnText = $btn.html();

            $btn.html('loading...');

            if( pageNum <= max ) {

                var $container = $(wrap_selector);
                $.ajax({
                    url:nextLink,
                    type: "get",
                    success: function(data){
                        $container.append( $(data).find(wrap_selector).html() );

                        var newElements = $(data).find('.js-load-team .sanjose-team-item');
                        var elems = [];

                        console.log(newElements);
                        console.log('----------');
                        console.log(elems);

                        newElements.each(function(i){
                            elems.push(this);
                        });

                        sanjose_img_background('.hidden-img');

                        $btn.html( $btnText );

                        pageNum++;
                        nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ pageNum);

                        if( pageNum == ( max + 1 ) ) {
                            $btn.hide('fast');
                        }
                    }
                });
            }
            return false;

        }
    }

    $('#load-more').on('click', function(){
        load_more_team();
    });

     /*====================
          Video Banner
     ====================*/
    $('.sanjose-video-banner, .sanjose-banner').each(function(){
        var videoWrap = $(this),
            videoPopUp = videoWrap.find('.video_popup'),
            buttonPlay = videoWrap.find('.button-play, .link-video'),
            videoIframe = videoPopUp.find('iframe'),
            iframeSrc = videoIframe.attr('src'),
            iframeDataSrc = videoIframe.attr('data-src'),
            closePlayButton = videoPopUp.find('.close-btn');
        buttonPlay.on('click', function(e){
            e.preventDefault();
            videoPopUp.addClass('active');
            videoIframe.attr('src', iframeDataSrc);
        });

        closePlayButton.on('click', function(){
            videoPopUp.removeClass('active');
            videoIframe.attr('src', iframeSrc);
        });
    });

    function addVideo() {
        $('.sanjose-banner').each(function() {
            var $this = $(this);
            $this.find('.video-iframe').show();

            var $video = $this.find('.video-iframe iframe'),
                w = $video.width(),
                h = $video.outerHeight(),
                videoRatio = (w / h).toFixed(2),
                minW = parseInt($this.width()),
                minH = parseInt($this.outerHeight()),
                widthRatio = minW / w,
                heightRatio = minH / h,
                newWidth, newHeight;
            if (widthRatio > heightRatio) {
                newWidth = minW;
                newHeight = Math.ceil(newWidth / videoRatio);
            } else {
                newHeight = minH;
                newWidth = Math.ceil(newHeight * videoRatio);
            }
            $video.width(newWidth + 'px').height(newHeight + 'px');

            if (newHeight > minH) {
                $video.css('top', -(newHeight - minH) / 2);
            } else {
                $video.css('top', '0');
            }
        });
    }

    /*====================
         Share button
     ====================*/
    $('[data-share]').on('click',function(){

        var w = window,
            url = this.getAttribute('data-share'),
            title = '',
            w_pop = 600,
            h_pop = 600,
            scren_left = w.screenLeft != undefined ? w.screenLeft : screen.left,
            scren_top = w.screenTop != undefined ? w.screenTop : screen.top,
            width = w.innerWidth,
            height = w.innerHeight,
            left = ((width / 2) - (w_pop / 2)) + scren_left,
            top = ((height / 2) - (h_pop / 2)) + scren_top,
            newWindow = w.open(url, title, 'scrollbars=yes, width=' + w_pop + ', height=' + h_pop + ', top=' + top + ', left=' + left);

        if (w.focus) {
            newWindow.focus();
        }

        return false;
    });

    /*====================
      Absolute img block
     ====================*/
    if( $('.absolute-image').length ) {
        $('.absolute-image').each(function(){
            $(this).closest('.wpb_wrapper').css('position','relative');
            var $image = $(this).find('img');
            $(this).css({
                'position': 'absolute',
                'width': $(window).width() / 2
            });
        });
    }

    $('.product-absolute-img').append('<div class="absolute-wrapp-img"></div>');

    /*============================*/
    /* SORTER PRICING */
    /*============================*/
    var sorter_pricing = function () {

        if ( $('.sanjose-pricing.filters').length ) {

            $('.sanjose-pricing').each(function(){

                var $container = $(this);
                var data_items = $container.find('.js-pricing-item');
                var $filters   = $(this).find('.select-price').find('li');

                // First item filter
                var first_item_filter   = $filters.first();
                var first_Value         = first_item_filter.attr('data-filter-price');
                var filterer_first_item = data_items.filter('[data-price = "' + first_Value + '"]');

                data_items.hide();
                filterer_first_item.show();

                /* Filter */
                $filters.on('click', function() {

                    /* Show/Hide active class */
                    $filters.removeClass('active');
                    $(this).addClass('active');

                    var filterValue = $(this).attr('data-filter-price');

                    /* Show/Hide albums item */
                    var filteredItems  = data_items.filter('[data-price = "' + filterValue + '"]');

                    $(this).closest('.sanjose-pricing').find('.js-pricing-item').hide();
                    filteredItems.show();
                    return false;

                });

            });
        }
    };

    /*====================
            Timeline
     ====================*/
     var timeline = {
        elems: {
            $container: $('.tabs-header'),
            $counters: null,
            $mainLine: null,
            $tabs: null,
            $animatedLine: null,
            $contents: $('.tab-content'),
            setElems: function () {
                timeline.elems.$counters = timeline.elems.$container.find('.counter');
                timeline.elems.$tabs = timeline.elems.$container.find('.tab-item');
            }
        },
        _animationDuration: 350,
        init: function () {
            if (!this.elems.$container.length) {
                return
            }
            this.elems.setElems();
            this.insertMainLine();
            this.elems.$animatedLine = this.insertAnimateLine();

            var mainLineHeight = this.getLineHeight(this.elems.$counters.eq(0), this.elems.$counters.last());
            this.setLineHeight(this.elems.$mainLine, mainLineHeight);

            this.elems.$tabs.on('click', this.activateTab);
        },
        insertMainLine: function () {
            this.elems.$mainLine = $('<span class="sanjose-timeline__main-line"></span>').appendTo(this.elems.$counters.eq(0));
        },
        insertAnimateLine: function () {
            return $('<span class="sanjose-timeline__animated-line"></span>').appendTo('.sanjose-timeline__main-line');
        },
        getLineHeight: function ($firstElem, $lastElem) {
            var lineHeight = $lastElem.offset().top - $firstElem.offset().top - $firstElem.height();
            return lineHeight;
        },
        setLineHeight: function ($element, height, isMainLine) {
          $element.height(height);
        },
        activateTab: function () {
            if ($(this).hasClass('active')) { return; }

            timeline.elems.$tabs.removeClass('active highlited');
            $(this).addClass('active');

            var newActiveElemIndex = timeline.elems.$tabs.index(this);
            var activeTabs = timeline.elems.$tabs.filter(function (index) {
              return index <= newActiveElemIndex;
            });
            $(activeTabs).addClass('highlited');

            var animateLineHeight = timeline.getLineHeight(timeline.elems.$counters.eq(0), $(this));
            timeline.setLineHeight(timeline.elems.$animatedLine, animateLineHeight);

            // Show Content
            var $activeContent = $($(this).data('content'));
            var activeSwiper = null;
            timeline.elems.$contents.stop().filter(':visible').fadeOut(400, function() {
              $activeContent.fadeIn();
              // Reinit Swiper
              activeSwiper = swipers['swiper-' + $activeContent.find('.swiper-container').attr('id')];
              
              // if current active slide include slider
              if ( activeSwiper !== undefined ) {
                activeSwiper.updatePagination();
                activeSwiper.reInit();
              }
            });


        }
     }

    /*====================
     Product slideshow
     ====================*/
    if ( $('.sanjose-product-slideshow').length ) {
        var div_top = $('.sanjose-product-slideshow').offset().top;

        $(document).scroll(function() {
            if (div_top <= $(document).scrollTop()) {
                $('.sanjose-product-slideshow').find('.info-item').addClass('show-info');
            }
        });

        $('.pagination-product').on('click', 'li:not(.active)', function() {
            var index_el = $(this).index();

            $(this).addClass('active').siblings().removeClass('active');
            $(this).closest('.sanjose-product-slideshow').find('.product-content').removeClass('active').eq(index_el).addClass('active');

            var product_content = $(this).closest('.sanjose-product-slideshow').find('.product-content');

            if ( product_content.hasClass('active') ) {
                product_content.siblings().find('.info-item').removeClass('show-info');
            }

        });

        $('.info-item').each(function () {

            var info_icon = $(this).find('.info-icon');

            info_icon.on('click', function () {
                $(this).closest('.info-item').toggleClass('show-info');
            });

        });
    }

    /*====================
          Masonry posts
     ====================*/
    function masonry_posts() {
        if($('.blog-list').length){
            $('.blog-list').masonry({
                // set itemSelector so .grid-sizer is not used in layout
                itemSelector: '.post, .page',
                columnWidth: '.post, .page',
                percentPosition: true
            });
        }
    }
    masonry_posts();

    /*====================
          Masonry footer unit test
     ====================*/
    /*function masonry_unit() {
        if($('.main-footer .sidebar').length){
            $('.main-footer .sidebar').masonry({
                // set itemSelector so .grid-sizer is not used in layout
                itemSelector: '.sanjose-widget',
                columnWidth: '.sanjose-widget',
                percentPosition: true
            });
        }
    }
    masonry_unit();*/
    // add class select widget for unit test
    $(".sanjose-widget select[id*='archives-dropdow']").parent().addClass("widget_archive_dropdown");
    $(".widget_categories select").parent().addClass("widget_categories_dropdown");
    $(".widget_text select").closest(".widget_text").addClass("widget_text_dropdown");


    // ------------------------------------------------------------------------
    // Particles JS Animation
    // ------------------------------------------------------------------------
    if ($("#particles-js").length) {
        if ($(window).width() > 960) {
            particlesJS("particles-js", {
                "particles": {
                    "number": {
                        "value": 120,
                        "density": {
                            "enable": true,
                            "value_area": 1800
                        }
                    },
                    "color": {
                        "value": "#ffffff"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 3
                        },
                        "image": {
                            "src": "img/github.svg",
                            "width": 100,
                            "height": 100
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": false,
                        "anim": {
                            "enable": false,
                            "speed": 1,
                            "opacity_min": 0.2,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 20,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 250,
                        "color": "#ffffff",
                        "opacity": 0.2,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 1,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": false,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "window",
                    "events": {
                        "onhover": {
                            "enable": false,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": false,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 180,
                            "line_linked": {
                                "opacity": 1
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true
            });

        }
    }

    // Gallery single portfolio
    function galleryPreview() {
        $('.js-preview-gallery').each(function() {
            var active_slide = $(this).closest('.slider-gallery').find('.swiper-slide-active');
            $(this).css('background-image', active_slide.find('.portfolio_bg-slide').css('background-image'));
            $(this).parent().attr('href', active_slide.find('a').attr('href'));
        });

    }

    /*============================================
          Number List for info block shortcode
     ============================================*/

    $('.js-count-list').each(function() {
        var numberList = $(this).closest('.item-info').index() + 1;
        if(numberList<10) {
            numberList = '0' + numberList;
        }
        $(this).text(numberList);
    });

    /*============================================
        Add class active accordion panel wrap
     ============================================*/

    $(".collapse").on('shown.bs.collapse',function(){
        var parent_wrap = $(this).closest('.panel');
        parent_wrap.addClass('active');

    });
    $(".collapse").on('hidden.bs.collapse',function(){
        var parent_wrap = $(this).closest('.panel');
        parent_wrap.removeClass('active');
    });


    // likes on blog
    function toggleLikeFromCookies($element, postId) {
        if (document.cookie.search(postId) === -1) {
            $element.removeClass('post__likes--liked');
        } else {
            $element.addClass('post__likes--liked');
        }
    }

    var $likes = $('.js-voit-img');

    for (var i = 0; i < $likes.length; i++) {
        toggleLikeFromCookies($likes.eq(i), $likes.eq(i).attr('data-id'));
    }

    $likes.on('click', function() {
        var $this = $(this),
            post_id = $this.attr('data-id');
        $this.toggleClass('post__likes--liked');

        $.ajax({
            type: "POST",
            url: ajax_data.ajaxurl,
            data: ({
                action: 'sanjose_like_post',
                post_id: post_id
            }),
            success: function(msg) {
                $this.closest('.entry-post').find('.count-likes').text(msg);
                toggleLikeFromCookies($this, post_id);
            }
        });
        return false;
    });


    /*====================
          Window load
     ====================*/
    $(window).on('load', function () {
        // Preloader
        $("#loading").delay(700).fadeOut("slow");

        izotope_portfolio();
        // add class active panel wrap accordion
        $('shown.bs.collapse').each(function() {
            $(this).closest('.panel').addClass('panel');
        });

        initSwiper();
        paginationImg();
        sanjose_img_background('.hidden-img');
        sorter_pricing();
        addVideo();
        galleryPreview();
        hoverBut('.sanjose-banner .btn');
        hoverButRev('.sanjose-text a.link');

        // timeline init
        timeline.init();
        $('.owl-carousel').owlCarousel({
            center: true,
            items: 7,
            autoWidth:true,
            loop: true,
            margin: 50
        });

    });

    /*====================
     Window resize
     ====================*/

    $(window).on('resize', function () {
        addVideo();
        izotope_portfolio();
        masonry_posts();
    });

    function galleryPopup() {
        $(".lightgallery").lightGallery();
    }
    galleryPopup();

    if ( $('.portfolio-list.prague_grid').length == 0 ) {
        $('.portfolio-list').lightGallery({
            thumbnail:true
        });
    }

    $('.content-item .rotate').on('click', function (event) {
        event.stopPropagation();
    })




    function changeStateVideo(iframe_container,button,player,hover_enable,services){


        var $this = $(button),
            iframe = iframe_container.find('iframe');


        if ($this.hasClass('start')) {
            services == 'youtube' && player.pauseVideo();
            if (iframe.data('src')) {
                iframe.attr('src','about:blank');
            }
            $this.removeClass('start')
                .closest('.iframe-video').removeClass('play');
        } else {
            services == 'youtube' && player.playVideo();
            if (iframe.data('src')) {
                iframe.attr('src',iframe.data('src'));
            }
            $this.addClass('start')
                .closest('.iframe-video').addClass('play');
        }

        iframe_container = '';
    }
    // youtube video ready
    window.onYouTubeIframeAPIReady = function() {

        var player = [],
            $iframe_parent = [],
            $this,
            $button;

        // each all iframe
        $('iframe').each(function(i){
            // get parent element
            $this = $(this);
            $iframe_parent[i] = $this.closest('.iframe-video.youtube');

            // init video player
            player[i] = new YT.Player(this, {

                // callbacks
                events: {
                    'onReady': function(event){
                        // mute on/off
                        if ( $iframe_parent[i].data('mute') ) {
                            event.target.mute();
                        }
                    },
                    'onStateChange': function(event){

                        switch (event.data) {
                            case 1:
                                // start play
                                //Exammple: console.log(player.getDuration());
                                //changeStateVideo($iframe_parent[i],$this[0], player[i],false,'youtube');
                                break;

                            case 2:
                                // pause
                                break;

                            case 3:
                                // buffering

                                break;

                            case 0:
                                // end video
                                $iframe_parent[i].removeClass('play').find('.play-button').removeClass('start');

                                break;

                            default: '-1'
                            // not play
                        }
                    }
                }
            });

            // hover play/pause video
            if ($iframe_parent[i].data('type-start') == 'hover') {
                changeStateVideo($iframe_parent[i], this, player[i],true,'youtube')
            }

            if($(window).width() < 992){
                $iframe_parent[i].find('iframe').addClass('hide');
            }else{
                $iframe_parent[i].find('iframe').removeClass('hide');
            }

            // click play/pause video
            if ($iframe_parent[i].data('type-start') == 'click') {
                $iframe_parent[i].find('.play-button').on('click', function(event){
                    event.preventDefault();
                    changeStateVideo($iframe_parent[i],this, player[i],false,'youtube');
                    $iframe_parent[i].find('iframe').toggleClass('hide');

                });
            }
            var muteButton = $iframe_parent[i].find('.mute-button');
            // mute video
            if(muteButton.length){
                muteButton.on('click', function () {
                    if(muteButton.hasClass('mute1')){
                        player[i].unMute();
                        muteButton.removeClass('mute1');
                    }else{
                        muteButton.addClass('mute1');
                        player[i].mute();
                    }
                });
            }
            // stop video
            $iframe_parent[i].find('.video-close-button').on('click',function(){
                event.preventDefault();
                player[i].stopVideo();
                $iframe_parent[i].removeClass('play')
                    .find('.play-button').removeClass('start');
            });

        });

    };


function hoverBut (link) {
    var $msglist = $(link);
    if ( $msglist.length ) {
        var color = $msglist.data("color");
        if ( color.length && color !== undefined) {
            $msglist.css({'box-shadow': '5px 8.7px 20px' + color});
            $msglist.hover(
                function () {
                    $(this).css({'background-color': 'transparent', 'color': color, 'box-shadow': 'none'});
                },
                function () {
                    $(this).css({'background-color': color, 'color': '#fff', 'box-shadow': '5px 8.7px 20px' + color});
                }
            );
        }
    }
}
    function hoverButRev (link) {
        var $msglist = $(link);
        if ( $msglist.length ) {
            var color = $msglist.data("color");
            if (color.length) {
                $msglist.hover(
                    function () {
                        $(this).css({'background-color': color, 'color': '#fff'});
                    },
                    function () {
                        $(this).css({'background-color': 'transparent', 'color': '#3b55e6'});
                    }
                );
            }
        }
    }

})(jQuery, window, document);





