/**
 * Theme frontend scripts
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.8.0
 *
 * Contents:
 *
 *  10) Basics
 *  20) Site header
 *  30) Banner
 *  40) Posts
 * 100) Others
 */

( function( $ ) {

	'use strict';





	/**
	 * 10) Basics
	 */

		var
			$window      = $( window ),
			$siteContent = $( '.is-singular:not(.home) .site-content' );

		$( '.no-js' )
			.removeClass( 'no-js' );





	/**
	 * 20) Site header
	 */

		$( '#menu-toggle' )
			.on( 'click', function( e ) {

				e.preventDefault();

				$( '#secondary' )
					.toggleClass( 'active' );

				$( '#secondary.active' )
					.attr( 'aria-expanded', 'true' )
					.find( '#menu-toggle' )
						.attr( 'aria-expanded', 'true' );

				$( '#secondary:not(.active)' )
					.attr( 'aria-expanded', 'false' )
					.find( '#menu-toggle' )
						.attr( 'aria-expanded', 'false' );

			} );





	/**
	 * 30) Banner
	 */

		if ( $().slick ) {
			$( '#site-banner.enable-slider .site-banner-inner' )
				.slick( {
					'adaptiveHeight' : false,
					'autoplay'       : true,
					'autoplaySpeed'  : ( ! $( '#site-banner' ).data( 'speed' ) ) ? ( 5400 ) : ( $( '#site-banner' ).data( 'speed' ) ),
					'cssEase'        : 'ease-in-out',
					'dots'           : false,
					'easing'         : 'easeInOutBack',
					'fade'           : true,
					'pauseOnHover'   : true,
					'slide'          : 'article',
					'speed'          : 600,
					'swipeToSlide'   : true,
					'prevArrow'      : '<div class="slider-nav slider-nav-prev"><button type="button" class="slick-prev"><span class="genericons-neue genericons-neue-previous"></span></button></div>',
					'nextArrow'      : '<div class="slider-nav slider-nav-next"><button type="button" class="slick-next"><span class="genericons-neue genericons-neue-next"></span></button></div>'
				} );
		}





	/**
	 * 40) Posts
	 */

		$siteContent
			.css( 'min-height', $( '.entry-media' ).outerHeight() + 'px' );

		$window
			.on( 'resize orientationchange', function( e ) {
				if ( 960 < document.body.clientWidth ) {
					$siteContent
						.css( 'min-height', $( '.entry-media' ).outerHeight() + 'px' );
				}
			} );





	/**
	 * 100) Others
	 */

		if ( 0 == $window.scrollTop() ) {
			$( 'body' )
				.addClass( 'not-scrolled' );
		}

		$window
			.on( 'scroll', function( e ) {

				if ( 0 == $window.scrollTop() ) {
					$( 'body' )
						.addClass( 'not-scrolled' )
						.removeClass( 'is-scrolled' );
				} else {
					$( 'body' )
						.addClass( 'is-scrolled' )
						.removeClass( 'not-scrolled' );
				}

			} );





} )( jQuery );
