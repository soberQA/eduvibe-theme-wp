;(function($) {
    "use strict";

    /*
    |=========================
    | Search Modal PopUp
    |=========================
    */ 
    let eduVibeSearchModalPopUp = function(){
        $( '.search-trigger' ).on( 'click', function () {
            $( '.edu-search-popup' ).addClass( 'open' );
            $( 'body, html' ).css( 'overflow-y','hidden' );
        } )
        $( '.close-trigger' ).on( 'click', function () {
            $( '.edu-search-popup' ).removeClass( 'open' );
            $( 'body, html' ).css( 'overflow-y','inherit' );
        } )
        $( '.edu-search-popup' ).on( 'click', function () {
            $( '.edu-search-popup' ).removeClass( 'open' );
            $( 'body, html' ).css( 'overflow-y','inherit' );
        } )
        $( '.edu-search-popup .eduvibe-search-popup-field' ).on( 'click', function (e) {
            e.stopPropagation();
        } )
    }

    /*
    |=========================
    | Add class for table style
    |=========================
    */  
    $( 'table' ).addClass( 'table table-bordered table-striped' );

    /* mobile menu active
    ========================================================================== */
    if ( $.isFunction( $.fn.metisMenu ) ) {
        $( '.eduvibe-mobile-menu-item' ).metisMenu();
    }

    $( '.eduvibe-mobile-menu-nav-wrapper .menu-item-has-children > a' ).on( 'click', function (e) {
        e.preventDefault();
    } );

    $( '.eduvibe-mobile-hamburger-menu > a' ).on( 'click', function (e) {
        e.preventDefault();
        $( '.eduvibe-mobile-menu-nav-wrapper' ).toggleClass( 'eduvibe-mobile-menu-visible' );
        $( 'body' ).addClass( 'eduvibe-mobile-menu-active' );
        $(this).addClass( 'eduvibe-mobile-menu-close--active' );
    } );

    $( '.eduvibe-mobile-menu-close > a' ).on( 'click', function (e) {
        e.preventDefault();
        $( '.eduvibe-mobile-menu-nav-wrapper' ).removeClass( 'eduvibe-mobile-menu-visible' );
        $( 'body').removeClass( 'eduvibe-mobile-menu-active' );
        $( '.eduvibe-mobile-hamburger-menu > a' ).removeClass( 'eduvibe-mobile-menu-close--active' );
    } );

    $( '.eduvibe-mobile-menu-overlay' ).on( 'click', function () {
        $( '.eduvibe-mobile-menu-nav-wrapper' ).removeClass( 'eduvibe-mobile-menu-visible' );
        $( 'body' ).removeClass( 'eduvibe-mobile-menu-active' );
        $( '.eduvibe-mobile-hamburger-menu > a' ).removeClass( 'eduvibe-mobile-menu-close--active' );
    } );

    /*
    |=========================
    | Tilt Hover Animation
    |=========================
    */
    if ( $.isFunction( $.fn.tilt ) ) {
        $( '.eduvibe-single-product-thumb-wrapper' ).tilt( {
            maxTilt: 50,
            perspective: 1400,
            easing: 'cubic-bezier(.03,.98,.52,.99)',
            speed: 1200,
            glare: false,
            maxGlare: 0.3,
            scale: 1.04
        } );
    }

    /*
    |=========================
    | Slick Slider Items
    |=========================
    */  
    $( '.eduvibe-related-course-items, .eduvibe-related-product-items' ).each( function() {
        let carouselWrapper = $(this),
        slidesToShow        = undefined !== carouselWrapper.data( 'slidestoshow' ) ? carouselWrapper.data( 'slidestoshow' ) : 3,
        tabletItems         = undefined !== carouselWrapper.data( 'tablet-items' ) ? carouselWrapper.data( 'tablet-items' ) : 2,
        mobileItems         = undefined !== carouselWrapper.data( 'mobile-items' ) ? carouselWrapper.data( 'mobile-items' ) : 1,
        smallMobileItems    = undefined !== carouselWrapper.data( 'small-mobile-items' ) ? carouselWrapper.data( 'small-mobile-items' ) : 1,
        autoplaySpeed       = undefined !== carouselWrapper.data( 'autoplayspeed' ) ? carouselWrapper.data( 'autoplayspeed' ) : 3000,
        autoplay                = undefined !== carouselWrapper.data( 'autoplay' ) ? carouselWrapper.data( 'autoplay' ) : false,
        loop                = undefined !== carouselWrapper.data( 'loop' ) ? carouselWrapper.data( 'loop' ) : false,
        direction           = false;
        if ( "rtl" == document.dir ) {
            direction = true;
        }
        if ( $.isFunction( $.fn.slick ) ) {  
            $(this).slick( {
                dots: false,
                infinite: true,
                arrows: false,
                speed: 1000,
                loop: loop,
                slidesToShow: slidesToShow,
                slidesToScroll: 1,
                autoplay: autoplay,
                autoplaySpeed: autoplaySpeed,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: tabletItems,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: mobileItems
                        }
                    },
                    {
                        breakpoint: 481,
                        settings: {
                            slidesToShow: smallMobileItems
                        }
                    }
                ]
            } )
        }
    });

    /*
    |=========================
    | LP Course Content
    |=========================
    */  
    let LPCourseContent = document.querySelectorAll( '.course-tab-panel-curriculum .section-content');
    let LPCourseTitle = document.querySelectorAll( '.course-summary ul.curriculum-sections li .section-header .section-title');
    LPCourseContent.forEach((toggle) => {
        toggle.addEventListener( 'click', () => {
            toggle.parentNode.classList.toggle( 'active' );
        } );
    } );

    /*
    |=========================
    | Menu Sticky Function
    |=========================
    */  
    let eduVibeTransparentHeader = function() {
        let header_height = $( '.eduvibe-sticky-header-wrapper' ).outerHeight();
        $(window).on('load scroll', function() {
            let y = $(this).scrollTop();
            if ( y > 120 ) {
                $( '.header-get-sticky, .eduvibe-sticky-header-wrapper' ).addClass( 'eduvibe-header-sticky' );
            } else {
                $( '.header-get-sticky, .eduvibe-sticky-header-wrapper' ).removeClass( 'eduvibe-header-sticky' );
            }
        } );
    };    

    let eduVibeMegaMenu = function() {
        if ( "rtl" == document.dir ) {
            $( '.main-navigation ul > li.mega-menu' ).each(function() {
                let items       = $(this).find( ' > ul.eduvibe-dropdown-menu > li' ).length,
                bodyWidth       = $( 'body' ).outerWidth(),
                parentLinkWidth = $(this).find( ' > a' ).outerWidth(),
                parentLinkpos   = $(this).find( ' > a' ).offset().left,
                width           = items * 250,
                left            = width / 2 - parentLinkWidth / 2,
                linkleftWidth   = parentLinkpos + parentLinkWidth / 2,
                linkRightWidth  = bodyWidth - (parentLinkpos + parentLinkWidth);

                if (width / 2 > linkleftWidth) {
                    $(this).find( ' > ul.eduvibe-dropdown-menu' ).css( {
                        width: width + 'px',
                        right: 'inherit',
                        left: '-' + parentLinkpos + 'px'
                    } );
                } else if (width / 2 > linkRightWidth) {
                    $(this).find( ' > ul.eduvibe-dropdown-menu' ).css( {
                        width: width + 'px',
                        left: 'inherit',
                        right: '-' + linkRightWidth + 'px'
                    } );
                } else {
                    $(this).find( ' > ul.eduvibe-dropdown-menu' ).css( {
                        width: width + 'px',
                        right: '-' + left + 'px'
                    } );
                }
            } );
        } else {
            $( '.main-navigation ul > li.mega-menu' ).each(function() {
                let items       = $(this).find( ' > ul.eduvibe-dropdown-menu > li' ).length,
                bodyWidth       = $( 'body' ).outerWidth(),
                parentLinkWidth = $(this).find( ' > a' ).outerWidth(),
                parentLinkpos   = $(this).find( ' > a' ).offset().left,
                width           = items * 250,
                left            = width / 2 - parentLinkWidth / 2,
                linkleftWidth   = parentLinkpos + parentLinkWidth / 2,
                linkRightWidth  = bodyWidth - (parentLinkpos + parentLinkWidth);

                if (width / 2 > linkleftWidth) {
                    $(this).find( ' > ul.eduvibe-dropdown-menu' ).css( {
                        width: width + 'px',
                        right: 'inherit',
                        left: '-' + parentLinkpos + 'px'
                    } );
                } else if (width / 2 > linkRightWidth) {
                    $(this).find( ' > ul.eduvibe-dropdown-menu' ).css( {
                        width: width + 'px',
                        left: 'inherit',
                        right: '-' + linkRightWidth + 'px'
                    } );
                } else {
                    $(this).find( ' > ul.eduvibe-dropdown-menu' ).css( {
                        width: width + 'px',
                        left: '-' + left + 'px'
                    } );
                }
            } );
        }
    }

    /*
    |=========================
    | CountDown
    |=========================
    */
    $( '.eduvibe-single-event-countdown-content' ).each( function() {
        let $this   = $(this),
        finalDate   = $this.data( 'countdown' ),
        day         = $this.data( 'day' ),
        hours       = $this.data( 'hours' ),
        minutes     = $this.data( 'minutes' ),
        seconds     = $this.data( 'seconds' ),
        expiredText = $this.data( 'expired-text' );

        if ( $.isFunction( $.fn.countdown ) ) {
            $(this).countdown( finalDate,function( event ) {
                let $countdown = $(this).html(event.strftime(' '+
                    '<div class="eduvibe-countdown-each-item"><span class="eduvibe-countdown-each-digit">%-D </span><span class="eduvibe-countdown-each-content">' + day + '</span></div>' +
                    '<div class="eduvibe-countdown-each-item"><span class="eduvibe-countdown-each-digit">%H </span><span class="eduvibe-countdown-each-content">' + hours + '</span></div>' +
                    '<div class="eduvibe-countdown-each-item"><span class="eduvibe-countdown-each-digit">%M </span><span class="eduvibe-countdown-each-content">' + minutes + '</span></div>' +
                    '<div class="eduvibe-countdown-each-item"><span class="eduvibe-countdown-each-digit">%S </span><span class="eduvibe-countdown-each-content">' + seconds + '</span></div>'
                ) );
            } ).on( 'finish.countdown', function ( event ) {
                $(this).html( '<p class="eduvibe-countdown-over-message">' + expiredText + '</p>' );
            } ); 
        }   
    } );

    /*
    |=========================
    | Nice Select
    |=========================
    */
    $( '.widget select' ).niceSelect();

    /*
    |=========================
    | Google Map
    |=========================
    */
    let eduVibeMap = function(){
        if ( $( '#eduvibe-event-contact-map' ).length > 0 ) {
            let items = $( '#eduvibe-event-contact-map' );
            if ( items.data( 'latitude' ) !== "" && items.data( 'longitude' ) !== "" ) {
                let latLng = new google.maps.LatLng( items.data( 'latitude' ), items.data( 'longitude' ) ),
                zoom = 15,
                mapOptions = {
                    center: latLng,
                    zoom: zoom
                },
                map = new google.maps.Map( document.getElementById( 'eduvibe-event-contact-map' ), mapOptions );
            }
        }
    }

    
    /*
    |=========================
    | Preloader
    |=========================
    */  
    let eduVibesitePreloader = function () {
        jQuery( window ).load( function() {
            jQuery( '#eduvibe-preloader' ).fadeOut();
        } );
            
        // Close The Preloader while clicking on the button
        $( '.eduvibe-preloader-close-btn' ).on( 'click', function (e) {
            e.preventDefault();
            jQuery( '#eduvibe-preloader' ).fadeOut();
        } );
    }

    let eduVibeLPWishListAlert = function() {
        $(document).on( 'click', '.eduvie-lp-non-logged-user', function() {
            var $this = $(this);
            $this.addClass( 'ajaxload_wishlist' );
            var $html = '<div id="eduvibe-login-notification" class="eduvibe-login-notification-wrapper eduVibeFadeInRight"><div class="eduvibe-login-message">You need to Login first.</div></div>';
            $( 'body' ).find( '#eduvibe-login-notification' ).remove();
            $( 'body' ).append( $html ).fadeIn( 500 );
            setTimeout( function() {
                $( 'body' ).find( '#eduvibe-login-notification' ).removeClass( 'eduVibeFadeInRight' ).addClass( 'eduVibeFadeOutRight' );
            }, 2000 );
            
            setTimeout( function() {
                $this.removeClass( 'ajaxload_wishlist' );
            }, 200 );
        } );
    }

    // Dom Ready
    $(function() {
        eduVibeLPWishListAlert();
        eduVibeMegaMenu();
        eduVibeTransparentHeader();
        eduVibeSearchModalPopUp();
        eduVibeMap();
        eduVibesitePreloader();
    } );


    /*
    |============================
    | Scroll To Top
    |============================
    */ 
    let eduvibe_back_to_top_offset = 300,
    eduvibe_back_to_top_duration   = 800;

    $(window).on( 'scroll', function() {
        if ( $(this).scrollTop() > eduvibe_back_to_top_offset ) {
            $( '.eduvibe-default-scroll-to-top' ).fadeIn( 100 );
        } else {
            $( '.eduvibe-default-scroll-to-top' ).fadeOut( 100 );
        }
    } );

    $( '.eduvibe-default-scroll-to-top' ).on( 'click', function(event) {
        event.preventDefault();
        $( 'html, body' ).animate({
          scrollTop: 0
        }, eduvibe_back_to_top_duration );
        return false;
    } );

}(jQuery));