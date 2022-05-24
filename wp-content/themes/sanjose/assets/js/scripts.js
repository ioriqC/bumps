;(function($, window, document, undefined) {
  "use strict";

  /*============================*/
  /* INIT */
  /*============================*/
  var swipers = [],
  vivus = [],
  slicks = [],
  winScr,
  isotopeGridVar,
  _isresponsive,
  smPoint = 768,
  mdPoint = 992,
  lgPoint = 1200,
  addPoint = 1600,
  _ismobile = navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i);

    /**
     *
     * PageCalculations function
     * @since 1.0.0
     * @version 1.0.1
     * @var winW
     * @var winH
     * @var winS
     * @var pageCalculations
     * @var onEvent
     **/
    if (typeof pageCalculations !== 'function') {

        var winW, winH, winS, pageCalculations, documentHeight, $html, latestKnownScrollY, lastKnownScrollY, onEvent = window.addEventListener;

        pageCalculations = function(func){
            
            winW = window.innerWidth;
            winH = window.innerHeight;
            winS = $(window).scrollTop();
            documentHeight = $(document).height(),
            $html = $('html');
            latestKnownScrollY = $(window).scrollTop(),
            lastKnownScrollY = latestKnownScrollY;

            if (!func) return;

            onEvent('load', func, true); // window onload
            onEvent('resize', func, true); // window resize

        }// end pageCalculations

        pageCalculations(function(){
            pageCalculations();
        });

    }

    pageCalculations(function(){
        wpc_add_img_bg('.s-img-switch');
        topFullBannerHeight();
    });

    /***********************************/
    /* STICKY HEADER */
    /**********************************/
    function header_sticky() {   
        if ( $('.main-header').hasClass('fix_menu') ) {
            var headerHeight = $('.main-header.fix_menu').outerHeight();
            if ( $(window).scrollTop() >= headerHeight ) {
                $('.main-header').addClass('fix_menu-active');
            } else {
                $('.main-header').removeClass('fix_menu-active');
            }
        }
    }


    /***********************************/
    /* WINDOW LOAD */
    /**********************************/

    $(window).on('load', function() {
        $('body').addClass('loaded').find('.prague-loader').addClass('is-loaded');
        startBtnAnimate();
        pragueGrid();

        if ( $('.main-header').hasClass('fix_menu') ) {
            var wpadminbar = $('#wpadminbar').length ? 32 : 0;
            console.log(wpadminbar);
            $('.main-header').css('top', wpadminbar);
        }
    });

    /***********************************/
    /* WINDOW RESIZE */
    /**********************************/
    $(window).on('resize', function() {
        
    });

    /***********************************/
    /* WINDOW SCROLL */
    /**********************************/
    $(window).on('scroll', function() {
        startBtnAnimate();
        header_sticky();
    });

    /***********************************/
    /* BACKGROUND */
    /**********************************/
    //sets child image as a background
    function wpc_add_img_bg( img_sel, parent_sel){

        if (!img_sel) {
            console.info('no img selector');
            return false;
        }

        var $parent, $neighbor, $imgDataHidden, $imgDataSibling, _this;

        $(img_sel).each(function(){
            _this = $(this);
            $imgDataHidden = _this.data('s-hidden');
            $imgDataSibling = _this.data('s-sibling');
            $parent = _this.closest( parent_sel );
            $parent = $parent.length ? $parent : _this.parent();

            if ($imgDataSibling) {
                $parent.addClass('s-back-sibling-switch');
                $neighbor = _this.next();
                $neighbor = $neighbor.length ? $neighbor : _this.next();
                $neighbor.css( 'background-image' , 'url(' + this.src + ')' ).addClass('s-sibling-switch');
            }
            else {
                $parent.css( 'background-image' , 'url(' + this.src + ')' ).addClass('s-back-switch');
            }

            if ($imgDataHidden) {
                _this.css('visibility', 'hidden');
            } else {
                _this.hide();
            }
        });
    }

    /***********************************/
    /* TOP BANNER HEIGHT AND CURSOR */
    /**********************************/
    function topFullBannerHeight() {

        var bannerFullWrapper = $('.top-banner.fullheight'),
            bannerFullContent = $('.top-banner.fullheight .content'),
            bannerFullContentHeight = $('.top-banner.fullheight .content').outerHeight(true);

        if(winH < bannerFullContentHeight) {
            bannerFullWrapper.css('min-height', bannerFullContentHeight);
        }
        else {
            bannerFullWrapper.css('min-height', winH);
        }
    }

    $('.top-banner .top-banner-cursor').on('click', function(e) {

        $('html, body').animate({
            scrollTop: $('.top-banner').height() + $('.top-banner').offset().top
        }, 1000);

    })

    /***********************************/
    /* BUTTON CREATIVE ANIMATE */
    /**********************************/
    function startBtnAnimate() {

        var btnCreative = $('.a-btn.creative, .a-btn-2.creative').not('.anima');

        if (btnCreative.length) {
            for (var i = 0; i < btnCreative.length; i++) {
                if ($(window).scrollTop() >= $(btnCreative[i]).offset().top - $(window).height() * 0.9) {
                    $(btnCreative[i]).addClass('anima');
                }
            }
        }        
    }

    /***********************************/
    /* PORTFOLIO */
    /**********************************/

    function pragueGrid() {
        var block = '.prague_services, .prague_books, .prague_media, .prague_exhibition_grid, .prague_grid';

        if($(block).length) {

            var $portfolioGrid = $(block),
                $portfolioItemWrapp = $portfolioGrid.find('.portfolio-item-wrapp');


            isotopeGridVar = $portfolioGrid.isotope({
                itemSelector: '.portfolio-item-wrapp',
                layoutMode: 'fitRows',
            }); 
        }
    }


    var scrollSelector = '.menu-item a', // selector menu link
        active_class = 'active',
        time = 1000,
        contentTop = {},
        contentOffset,
        currentAnchor = window.location.hash,
        scrollFlag = 0,
        $this;
 
    // Fill object with scroll blocks data (offset and height)
    window.setContentTopObject = function(){
        contentOffset = $('.prague-header').innerHeight();
        contentTop = {};
        $(scrollSelector).each(function(){
            if (this.hash && $(this.hash).length) {
                $(this).attr('data-hash', this.hash);
                $this = $( this.hash );
                var offset_top = $this.offset().top;
                contentTop[this.hash] = {'top': Math.round(offset_top - contentOffset), 'bottom': Math.round(offset_top  - contentOffset + $this.outerHeight() )};
            }
        });
    }
    
    $(window).on('load', function(){
        setContentTopObject();
    });
 
    $(window).on('resize', function(){
        setContentTopObject();
    });
 
    // Animate scroll after clicking menu link
    $(scrollSelector).on('click', function(e){
 
        //check dom element
        if ( !this.hash && !$(this.hash).length ) { 
            return true; 
        }
 
        setImmediateAnchor(this, time);
        e.preventDefault();
    });
 
    function setImmediateAnchor(anchor, time){
        if( anchor && $(anchor.hash).length){
            scrollFlag = 1;
            var link_hash = anchor.hash;
 
            $('html, body').stop().animate({ 'scrollTop' : contentTop[link_hash].top }, time, function(){
 
                if(history.pushState) {
                    history.pushState(null, null, link_hash);
                }
                else {
                    location.hash = link_hash;
                }
 
                currentAnchor = link_hash;
                scrollFlag = 0;
                $(scrollSelector).parent().removeClass(active_class);
                $(scrollSelector+'[data-hash="' + currentAnchor + '"]').parent().addClass(active_class);
            });         
 
        } 
    }
 
    $(window).on('load', function(){
        if ( $(window).scrollTop() > 0 && location.hash ) {
            setImmediateAnchor(location,1000);
        };
    });
    
    function setScrollAnchor(){
        if(!scrollFlag){
            var scrollPositionTop = $(window).scrollTop();
            for(var p in contentTop){
                if(contentTop[p].top <= scrollPositionTop && contentTop[p].bottom > scrollPositionTop && currentAnchor != p){
 
                    $(scrollSelector).parent().removeClass(active_class);
                    if(history.pushState) {
                        history.pushState(null, null, p);
                    }
                    else {
                        location.hash = p;
                    }
                    $(scrollSelector).parent().removeClass(active_class);
                    $(scrollSelector+'[data-hash="' + p + '"]').parent().addClass(active_class);
                    currentAnchor = p;
                    break;
                }
            }
        }
    }
 
    $('html, body').on('scroll mousedown DOMMouseScroll mousewheel keyup', function(e){
            if ( (e.which > 0 || e.type == 'mousedown' || e.type == 'mousewheel') && scrollFlag ){
                //console.log(e);
                $('html,body').stop();
                scrollFlag = 0;
                setScrollAnchor();
            } else {
                if (!scrollFlag) {
                    scrollFlag = 0;
                    setScrollAnchor();
                };
            }
    });

  var headeroffset;



  $(window).on('scroll', function() {
    

    if ($(this).scrollTop() >= headeroffset) {
      $('.prague-header').addClass('sticky');
    }
    else {
      $('.prague-header').removeClass('sticky');
    }
  });

  function footerPosition() {

      var header = $('header.main-header').not('.fix_menu').outerHeight() || 0,
          footer = $('footer.main-footer').outerHeight() + $('footer.main-footer + .footer-bottom').outerHeight(),
          bodyMinHeight = $(window).height() - header - footer;

      $('.mm-slideout > header + div.container').css('min-height', bodyMinHeight);
  }

    $(window).on('load resize orientationchange', function () {
        footerPosition();
    });


})(jQuery, window, document);