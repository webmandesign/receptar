<?php
/**
 * Plugin integration
 *
 * Jetpack
 *
 * @link  https://wordpress.org/plugins/jetpack/
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * CONTENT:
 * -  1) Requirements check
 * - 10) Actions and filters
 * - 20) Plugin integration
 */





/**
 * 1) Requirements check
 */

	if ( ! class_exists( 'Jetpack' ) ) {
		return;
	}





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Jetpack
			add_action( 'after_setup_theme', 'wm_jetpack', 30 );



	/**
	 * Filters
	 */

		//Jetpack
			add_filter( 'sharing_show',                'wm_jetpack_sharing',        10, 2 );
			add_filter( 'infinite_scroll_js_settings', 'wm_jetpack_is_js_settings', 10    );





/**
 * 20) Plugin integration
 */

	/**
	 * Enables Jetpack features
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_jetpack' ) ) {
		function wm_jetpack() {
			//Responsive videos
				add_theme_support( 'jetpack-responsive-videos' );

			//Site logo
				add_theme_support( 'site-logo' );

			//Featured content
				add_theme_support( 'featured-content', apply_filters( 'wmhook_wm_jetpack_featured_content', array(
						'featured_content_filter' => 'wm_get_banner_posts',
						'max_posts'               => 6,
						'post_types'              => array( 'post' ),
					) ) );

			//Infinite scroll
				add_theme_support( 'infinite-scroll', apply_filters( 'wmhook_wm_jetpack_infinite_scroll', array(
						'container'      => 'posts',
						'footer'         => false,
						'posts_per_page' => 4, //Only works if type is scroll and not click - note, that this can be toggled in WP admin.
						'type'           => 'scroll',
						'wrapper'        => true,
					) ) );
		}
	} // /wm_jetpack



	/**
	 * Jetpack sharing buttons
	 */

		/**
		 * Jetpack sharing display
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  bool $show
		 * @param  obj  $post
		 */
		if ( ! function_exists( 'wm_jetpack_sharing' ) ) {
			function wm_jetpack_sharing( $show, $post ) {
				//Helper variables
					global $wp_current_filter;

				//Preparing output
					if ( in_array( 'the_excerpt', (array) $wp_current_filter ) ) {
						$show = false;
					}

				//Output
					return $show;
			}
		} // /wm_jetpack_sharing



	/**
	 * Jetpack infinite scroll
	 */

		/**
		 * Jetpack infinite scroll JS settings array modifier
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array $settings
		 */
		if ( ! function_exists( 'wm_jetpack_is_js_settings' ) ) {
			function wm_jetpack_is_js_settings( $settings ) {
				//Helper variables
					$settings['text'] = esc_js( __( 'Load more&hellip;', 'wm_domain' ) );

				//Output
					return $settings;
			}
		} // /wm_jetpack_is_js_settings

?>