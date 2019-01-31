<?php
/**
 * Plugin integration
 *
 * Beaver Builder
 *
 * @link  https://www.wpbeaverbuilder.com/
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.7.0
 *
 * CONTENT:
 * -  1) Requirements check
 * - 10) Actions and filters
 * - 20) Plugin integration
 */





/**
 * 1) Requirements check
 */


	if ( ! class_exists( 'FLBuilder' ) ) {
		return;
	}





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		add_action( 'wp_enqueue_scripts', 'receptar_bb_assets' );



	/**
	 * Filters
	 */

		add_filter( 'fl_builder_settings_form_defaults', 'receptar_bb_global_settings', 10, 2 );

		add_filter( 'fl_builder_upgrade_url', 'receptar_bb_upgrade_url' );





/**
 * 20) Plugin integration
 */

	/**
	 * Upgrade link URL
	 *
	 * @since    1.0
	 * @version  1.2
	 *
	 * @param  string $url
	 */
	if ( ! function_exists( 'receptar_bb_upgrade_url' ) ) {
		function receptar_bb_upgrade_url( $url ) {
			//Output
				return esc_url( add_query_arg( 'fla', '67', $url ) );
		}
	} // /receptar_bb_upgrade_url



	/**
	 * Styles and scripts
	 *
	 * @since    1.0
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_bb_assets' ) ) {
		function receptar_bb_assets() {

			// Processing

				if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {
					wp_enqueue_style(
						'receptar-bb-addon',
						get_theme_file_uri( 'assets/css/beaver-builder-editor.css' ),
						false,
						esc_attr( trim( wp_get_theme()->get( 'Version' ) ) ),
						'screen'
					);
				}

		}
	} // /receptar_bb_assets



	/**
	 * Global settings
	 *
	 * @since    1.0
	 * @version  1.7.0
	 *
	 * @param  array  $defaults
	 * @param  string $form_type
	 */
	if ( ! function_exists( 'receptar_bb_global_settings' ) ) {
		function receptar_bb_global_settings( $defaults, $form_type ) {

			// Processing

				if ( 'global' === $form_type ) {

					// "Default Page Heading" section
					$defaults->show_default_heading     = '1';
					$defaults->default_heading_selector = '.entry-header';

					// "Rows" section
					$defaults->row_padding       = 0;
					$defaults->row_width         = $GLOBALS['content_width'];
					$defaults->row_width_default = 'full';

					// "Modules" section
					$defaults->module_margins = 0;

					// "Responsive Layout" section
					$defaults->medium_breakpoint     = 960;
					$defaults->responsive_breakpoint = 680;

				}


			// Output

				return $defaults;

		}
	} // /receptar_bb_global_settings
