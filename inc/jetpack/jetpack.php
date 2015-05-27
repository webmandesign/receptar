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
 * @version  1.3
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
			add_action( 'after_setup_theme', 'receptar_jetpack', 30 );



	/**
	 * Filters
	 */

		//Jetpack
			add_filter( 'sharing_show',                'receptar_jetpack_sharing',        10, 2 );
			add_filter( 'infinite_scroll_js_settings', 'receptar_jetpack_is_js_settings', 10    );





/**
 * 20) Plugin integration
 */

	/**
	 * Enables Jetpack features
	 *
	 * @since    1.0
	 * @version  1.3
	 */
	if ( ! function_exists( 'receptar_jetpack' ) ) {
		function receptar_jetpack() {
			//Responsive videos
				add_theme_support( 'jetpack-responsive-videos' );

			//Site logo
				add_theme_support( 'site-logo' );

			//Featured content
				add_theme_support( 'featured-content', apply_filters( 'wmhook_receptar_jetpack_featured_content', array(
						'featured_content_filter' => 'receptar_get_banner_posts',
						'max_posts'               => 6,
						'post_types'              => array( 'post' ),
					) ) );

			//Infinite scroll
				add_theme_support( 'infinite-scroll', apply_filters( 'wmhook_receptar_jetpack_infinite_scroll', array(
						'container'      => 'posts',
						'footer'         => false,
						'posts_per_page' => 4, //Only works if type is scroll and not click - note, that this can be toggled in WP admin.
						'render'         => 'receptar_jetpack_is_render',
						'type'           => 'scroll',
						'wrapper'        => true,
					) ) );
		}
	} // /receptar_jetpack



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
		if ( ! function_exists( 'receptar_jetpack_sharing' ) ) {
			function receptar_jetpack_sharing( $show, $post ) {
				//Helper variables
					global $wp_current_filter;

				//Preparing output
					if ( in_array( 'the_excerpt', (array) $wp_current_filter ) ) {
						$show = false;
					}

				//Output
					return $show;
			}
		} // /receptar_jetpack_sharing



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
		if ( ! function_exists( 'receptar_jetpack_is_js_settings' ) ) {
			function receptar_jetpack_is_js_settings( $settings ) {
				//Helper variables
					$settings['text'] = esc_js( esc_html__( 'Load more&hellip;', 'receptar' ) );

				//Output
					return $settings;
			}
		} // /receptar_jetpack_is_js_settings



		/**
		 * Jetpack infinite scroll posts renderer
		 *
		 * @see  receptar_jetpack()
		 *
		 * @since    1.3
		 * @version  1.3
		 */
		function receptar_jetpack_is_render() {

			// Output

				while ( have_posts() ) :

					the_post();

					get_template_part( 'template-parts/content', get_post_format() );

				endwhile;

		} // /receptar_jetpack_is_render
