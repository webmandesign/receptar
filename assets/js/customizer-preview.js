/**
 * Customizer preview scripts
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.4.1
 */





( function( $ ) {





	/**
	 * Site title and description.
	 */

		wp.customize( 'blogname', function( value ) {

			// Processing

				value
					.bind( function( to ) {

						$( '.site-title span' )
							.text( to );

					} );

		} ); // /blogname

		wp.customize( 'blogdescription', function( value ) {

			// Processing

				value
					.bind( function( to ) {

						$( '.site-description, .site-banner-header .highlight' )
							.text( to );

					} );

		} ); // /blogdescription





} )( jQuery );
