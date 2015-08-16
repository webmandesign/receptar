<?php
/**
 * Theme options
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.3.5
 *
 * CONTENT:
 * - 10) Actions and filters
 * - 20) Options functions
 */





/**
 * 10) Actions and filters
 */

	/**
	 * Filters
	 */

		//Apply customizer options
			add_filter( 'wmhook_theme_options', 'receptar_theme_options_array', 10 );
		//Theme custom styles to be outputed in HTML head
			add_filter( 'wmhook_custom_styles', 'receptar_custom_css_template', 10 );
		//Custom CSS replacements
			add_filter( 'wmhook_receptar_custom_styles_replace_replacements', 'receptar_custom_css_replacements', 10, 3 );





/**
 * 20) Options functions
 */

	/**
	 * Set theme options array
	 *
	 * @since    1.0
	 * @version  1.3.5
	 *
	 * @param  array $options
	 */
	if ( ! function_exists( 'receptar_theme_options_array' ) ) {
		function receptar_theme_options_array( $options = array() ) {
			//Preparing output

				/**
				 * Theme customizer options array
				 */

					$options = array(

						/**
						 * Colors
						 */
						100 . 'colors' => array(
							'id'                   => 'colors',
							'type'                 => 'section',
							'create_section'       => esc_html_x( 'Colors', 'Customizer section title.', 'receptar' ),
							'in_panel'             => esc_html_x( 'Theme', 'Customizer panel title.', 'receptar' ),
							'in_panel-description' => '<h3>' . esc_html__( 'Theme Credits', 'receptar' ) . '</h3><p class="description">' . sprintf(
										esc_html_x( '%1$s is free WordPress theme developed by %2$s. You can obtain other professional WordPress themes at %3$s. Thank you for using this awesome theme!', '1: linked theme name, 2: theme author name, 3: theme author link.', 'receptar' ),
										'<a href="' . esc_url( wp_get_theme()->get( 'ThemeURI' ) ) . '" target="_blank"><strong>' . esc_html( wp_get_theme()->get( 'Name' ) ) . '</strong></a>',
										esc_html( wp_get_theme()->get( 'Author' ) ),
										'<strong><a href="' . esc_url( wp_get_theme()->get( 'AuthorURI' ) ) . '" target="_blank">' . esc_html( wp_get_theme()->get( 'AuthorURI' ) ) . '</a></strong>'
									) . '</p>'
									. '<p><a href="' . esc_url( wp_get_theme()->get( 'ThemeURI' ) ) . '#donate" class="donation-link" target="_blank">' . esc_html__( 'Donate', 'receptar' ) . '</a></p>',
						),

							100 . 'colors' . 100 => array(
								'type'    => 'theme-customizer-html',
								'content' => '<h3>' . esc_html__( 'Accent color', 'receptar' ) . '</h3>',
							),

								100 . 'colors' . 110 => array(
									'type'        => 'color',
									'id'          => 'color' . '-accent',
									'label'       => esc_html__( 'Accent color', 'receptar' ),
									'description' => esc_html__( 'This color affects links, buttons and other elements of the website', 'receptar' ),
									'default'     => '#e53739',
								),
								100 . 'colors' . 120 => array(
									'type'        => 'color',
									'id'          => 'color' . '-accent-text',
									'label'       => esc_html__( 'Accent text color', 'receptar' ),
									'description' => esc_html__( 'Color of text over accent color background', 'receptar' ),
									'default'     => '#ffffff',
								),



							100 . 'colors' . 200 => array(
								'type'    => 'theme-customizer-html',
								'content' => '<h3>' . esc_html__( 'Header', 'receptar' ) . '</h3>',
							),

								100 . 'colors' . 210 => array( //This array key is used in `receptar_custom_css_replacements()` function.
									'type'    => 'color',
									'id'      => 'color' . '-header-background',
									'label'   => esc_html__( 'Background color', 'receptar' ),
									'default' => '#2a2c2e',
								),
								100 . 'colors' . 220 => array(
									'type'    => 'color',
									'id'      => 'color' . '-header-text',
									'label'   => esc_html__( 'Text color', 'receptar' ),
									'default' => '#ffffff',
								),



							100 . 'colors' . 300 => array(
								'type'    => 'theme-customizer-html',
								'content' => '<h3>' . esc_html__( 'Sidebar', 'receptar' ) . '</h3>',
							),

								100 . 'colors' . 310 => array(
									'type'    => 'color',
									'id'      => 'color' . '-sidebar-background',
									'label'   => esc_html__( 'Background color', 'receptar' ),
									'default' => '#1a1c1e',
								),
								100 . 'colors' . 320 => array(
									'type'        => 'color',
									'id'          => 'color' . '-sidebar-text',
									'label'       => esc_html__( 'Text color', 'receptar' ),
									'default'     => '#9a9c9e',
								),
								100 . 'colors' . 330 => array(
									'type'        => 'color',
									'id'          => 'color' . '-sidebar-headings',
									'label'       => esc_html__( 'Headings color', 'receptar' ),
									'default'     => '#ffffff',
								),
								100 . 'colors' . 340 => array(
									'type'        => 'color',
									'id'          => 'color' . '-sidebar-border',
									'label'       => esc_html__( 'Borders color', 'receptar' ),
									'default'     => '#3a3c3e',
								),



							100 . 'colors' . 400 => array(
								'type'    => 'theme-customizer-html',
								'content' => '<h3>' . esc_html__( 'Content', 'receptar' ) . '</h3>',
							),

								100 . 'colors' . 410 => array(
									'type'    => 'color',
									'id'      => 'color' . '-content-background',
									'label'   => esc_html__( 'Background color', 'receptar' ),
									'default' => '#ffffff',
								),
								100 . 'colors' . 420 => array(
									'type'        => 'color',
									'id'          => 'color' . '-content-text',
									'label'       => esc_html__( 'Text color', 'receptar' ),
									'default'     => '#6a6c6e',
								),
								100 . 'colors' . 430 => array(
									'type'        => 'color',
									'id'          => 'color' . '-content-headings',
									'label'       => esc_html__( 'Headings color', 'receptar' ),
									'default'     => '#1a1c1e',
								),
								100 . 'colors' . 440 => array(
									'type'        => 'color',
									'id'          => 'color' . '-content-border',
									'label'       => esc_html__( 'Borders color', 'receptar' ),
									'default'     => '#eaecee',
								),

								100 . 'colors' . 450 => array(
									'type'    => 'theme-customizer-html',
									'content' => '<h4>' . esc_html__( 'Alternative colors', 'receptar' ) . '</h4>',
								),

									100 . 'colors' . 460 => array(
										'type'    => 'color',
										'id'      => 'color' . '-content-alt-background',
										'label'   => esc_html__( 'Background color', 'receptar' ),
										'default' => '#2a2c2e',
									),
									100 . 'colors' . 470 => array(
										'type'        => 'color',
										'id'          => 'color' . '-content-alt-text',
										'label'       => esc_html__( 'Text color', 'receptar' ),
										'default'     => '#9a9c9e',
									),
									100 . 'colors' . 480 => array(
										'type'        => 'color',
										'id'          => 'color' . '-content-alt-headings',
										'label'       => esc_html__( 'Headings color', 'receptar' ),
										'default'     => '#ffffff',
									),
									100 . 'colors' . 490 => array(
										'type'        => 'color',
										'id'          => 'color' . '-content-alt-border',
										'label'       => esc_html__( 'Borders color', 'receptar' ),
										'default'     => '#3a3c3e',
									),



							100 . 'colors' . 800 => array(
								'type'    => 'theme-customizer-html',
								'content' => '<h3>' . esc_html__( 'Footer', 'receptar' ) . '</h3>',
							),

								100 . 'colors' . 810 => array(
									'type'        => 'color',
									'id'          => 'color' . '-footer-background',
									'label'       => esc_html__( 'Background color', 'receptar' ),
									'default'     => '#f5f7f9',
								),
								100 . 'colors' . 820 => array(
									'type'        => 'color',
									'id'          => 'color' . '-footer-text',
									'label'       => esc_html__( 'Text color', 'receptar' ),
									'default'     => '#9a9c9e',
								),



						/**
						 * Fonts
						 */
						200 . 'fonts' => array(
							'id'             => 'fonts',
							'type'           => 'section',
							'create_section' => esc_html_x( 'Fonts', 'Customizer section title.', 'receptar' ),
							'in_panel'       => esc_html_x( 'Theme', 'Customizer panel title.', 'receptar' ),
						),

							200 . 'fonts' . 100 => array(
								'type'    => 'theme-customizer-html',
								'content' => '<p class="description">' . sprintf(
										esc_html_x( 'This theme does not restrict you to a predefined set of fonts. Please use any font service (such as %s) plugin you want and set the plugin according to the information below.', '%s is replaced with linked examples of web fonts libraries such as Google Fonts or Adobe Typekit.', 'receptar' ),
										'<a href="http://www.google.com/fonts" target="_blank"><strong>Google Fonts</strong></a>, <a href="https://typekit.com/fonts" target="_blank"><strong>Adobe Typekit</strong></a>'
									) . '</p>'
									. '<p>' . esc_html__( 'List of CSS selectors for predefined theme font sets:', 'receptar' ) . '</p>'
									. '<ol>'
									. '<li><strong>' . esc_html_x( 'Texts:', 'CSS selector group name.', 'receptar' ) . '</strong><br />'
										. '<code>html</code>'
									. '</li>'
									. '<li><strong>' . esc_html_x( 'Headings:', 'CSS selector group name.', 'receptar' ) . '</strong><br />'
										. '<code>h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .entry-category, .entry-title .entry-edit</code>'
									. '</li>'
									. '<li><strong>' . esc_html_x( 'Logo:', 'CSS selector group name.', 'receptar' ) . '</strong><br />'
										. '<code>h1, .h1, blockquote</code>'
									. '</li>'
									. '</ol>'
									. '<p>' . sprintf(
												esc_html__( 'By default the theme uses %1$s font for texts, %2$s font for headings and %3$s font for logo.', 'receptar' ),
												//Texts
												'<a href="http://www.google.com/fonts/specimen/Roboto" target="_blank">Roboto</a>',
												//Headings
												'<a href="https://www.google.com/fonts/specimen/Roboto+Condensed" target="_blank">Roboto Condensed</a>',
												//Logo
												'<a href="http://www.google.com/fonts/specimen/Alegreya" target="_blank">Alegreya</a>'
											) . '</p>',
							),

					);

			//Output
				return apply_filters( 'wmhook_receptar_theme_options_array_output', $options );
		}
	} // /receptar_theme_options_array



	/**
	 * Header background RGBA
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array  $replacements
	 * @param  array  $theme_options
	 * @param  string $output
	 */
	if ( ! function_exists( 'receptar_custom_css_replacements' ) ) {
		function receptar_custom_css_replacements( $replacements, $theme_options, $output ) {
			//Helper variables
				$option_key = 100 . 'colors' . 210;

			//Preparing output
				if (
						! empty( $replacements )
						&& isset( $theme_options[ $option_key ] )
						&& isset( $theme_options[ $option_key ][ 'id' ] )
					) {

					$value = '';

					$option_id = $theme_options[ $option_key ][ 'id' ];

					if ( isset( $theme_options[ $option_id ]['default'] ) ) {
						$value = $theme_options[ $option_id ]['default'];
					}
					if ( $mod = get_theme_mod( $option_id ) ) {
						$value = $mod;
					}
					$value = '#' . trim( $value, '#' );

					$replacements[ '[[' . $option_id . '|alpha=20]]' ] = receptar_color_hex_to_rgba( $value, 20 );

				}

			//Output
				return $replacements;
		}
	} // /receptar_custom_css_replacements



	/**
	 * Basic custom CSS styles template
	 *
	 * Use a '[[skin-option-id]]' tags in your custom CSS styles string
	 * where the specific option value should be used.
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $styles
	 */
	if ( ! function_exists( 'receptar_custom_css_template' ) ) {
		function receptar_custom_css_template( $styles = '' ) {
			//Preparing output
				ob_start();

				locate_template( 'css/_custom.css',      true );
				locate_template( 'css/_custom-plus.css', true );

				$styles = ob_get_clean();

			//Output
				return apply_filters( 'wmhook_receptar_custom_css_template_output', $styles );
		}
	} // /receptar_custom_css_template

?>