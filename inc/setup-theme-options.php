<?php
/**
 * Theme options
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.6.0
 *
 * Content:
 *
 * 10) Actions and filters
 * 20) Options functions
 * 30) Partial refresh
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
	 * @since    1.0.0
	 * @version  1.6.0
	 *
	 * @param  array $options
	 */
	if ( ! function_exists( 'receptar_theme_options_array' ) ) {
		function receptar_theme_options_array( $options = array() ) {

			// Processing

				/**
				 * Theme customizer options array
				 */

					$options = array(



						/**
						 * Theme credits
						 */
						'0' . 90 . 'placeholder' => array(
							'id'                   => 'placeholder',
							'type'                 => 'section',
							'create_section'       => '',
							'in_panel'             => esc_html_x( 'Theme Options', 'Customizer panel title.', 'receptar' ),
							'in_panel-description' => '<h3>' . esc_html__( 'Theme Credits', 'receptar' ) . '</h3>'
								. '<p class="description">'
								. sprintf(
									esc_html_x( '%1$s is a WordPress theme developed by %2$s.', '1: linked theme name, 2: theme author name.', 'receptar' ),
									'<a href="' . esc_url( wp_get_theme( 'receptar' )->get( 'ThemeURI' ) ) . '"><strong>' . esc_html( wp_get_theme( 'receptar' )->get( 'Name' ) ) . '</strong></a>',
									'<strong>' . esc_html( wp_get_theme( 'receptar' )->get( 'Author' ) ) . '</strong>'
								)
								. '</p>'
								. '<p class="description">'
								. sprintf(
									esc_html_x( 'You can obtain other professional WordPress themes at %s.', '%s: theme author link.', 'receptar' ),
									'<strong><a href="' . esc_url( wp_get_theme( 'receptar' )->get( 'AuthorURI' ) ) . '">' . esc_html( str_replace( 'http://', '', untrailingslashit( wp_get_theme( 'receptar' )->get( 'AuthorURI' ) ) ) ) . '</a></strong>'
								)
								. '</p>'
								. '<p class="description">'
								. esc_html__( 'Thank you for using a theme by WebMan Design!', 'receptar' )
								. '</p>',
						),



						/**
						 * Colors: Accents and predefined colors
						 *
						 * Don't use `preview_js` here as these colors affect too many elements.
						 */
						100 . 'colors' . 10 => array(
							'id'             => 'colors-accents',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'receptar' ), esc_html_x( 'Accents', 'Customizer color section title', 'receptar' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'receptar' ),
						),



							/**
							 * Accent colors
							 */

								100 . 'colors' . 10 . 100 => array(
									'type'    => 'html',
									'content' => '<p class="description">' . esc_html__( 'These colors affect links, buttons and other elements.', 'receptar' ) . '</p>',
								),

								100 . 'colors' . 10 . 200 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Primary accent color', 'receptar' ) . '</h3>',
								),

									100 . 'colors' . 10 . 210 => array(
										'type'        => 'color',
										'id'          => 'color-accent',
										'label'       => esc_html__( 'Accent color', 'receptar' ),
										'description' => esc_html__( 'This color affects links, buttons and other elements of the website', 'receptar' ),
										'default'     => '#e53739',
									),
									100 . 'colors' . 10 . 220 => array(
										'type'        => 'color',
										'id'          => 'color-accent-text',
										'label'       => esc_html__( 'Accent text color', 'receptar' ),
										'description' => esc_html__( 'Color of text over accent color background', 'receptar' ),
										'default'     => '#ffffff',
									),



						/**
						 * Colors: Header
						 */
						100 . 'colors' . 20 => array(
							'id'             => 'colors-header',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'receptar' ), esc_html_x( 'Header', 'Customizer color section title', 'receptar' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'receptar' ),
						),



							/**
							 * Header colors
							 */

								100 . 'colors' . 20 . 100 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Header', 'receptar' ) . '</h3>',
								),

									100 . 'colors' . 20 . 110 => array( // This array key is used in `receptar_custom_css_replacements()` function.
										'type'    => 'color',
										'id'      => 'color-header-background',
										'label'   => esc_html__( 'Background color', 'receptar' ),
										'default' => '#2a2c2e',
									),
									100 . 'colors' . 20 . 120 => array(
										'type'    => 'color',
										'id'      => 'color-header-text',
										'label'   => esc_html__( 'Text color', 'receptar' ),
										'default' => '#ffffff',
									),



						/**
						 * Colors: Content
						 */
						100 . 'colors' . 30 => array(
							'id'             => 'colors-content',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'receptar' ), esc_html_x( 'Content', 'Customizer color section title', 'receptar' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'receptar' ),
						),



							/**
							 * Content colors
							 */

								100 . 'colors' . 30 . 100 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Content', 'receptar' ) . '</h3>',
								),

									100 . 'colors' . 30 . 110 => array(
										'type'    => 'color',
										'id'      => 'color-content-background',
										'label'   => esc_html__( 'Background color', 'receptar' ),
										'default' => '#ffffff',
									),
									100 . 'colors' . 30 . 120 => array(
										'type'        => 'color',
										'id'          => 'color-content-text',
										'label'       => esc_html__( 'Text color', 'receptar' ),
										'default'     => '#6a6c6e',
									),
									100 . 'colors' . 30 . 130 => array(
										'type'        => 'color',
										'id'          => 'color-content-headings',
										'label'       => esc_html__( 'Headings color', 'receptar' ),
										'default'     => '#1a1c1e',
									),
									100 . 'colors' . 30 . 140 => array(
										'type'        => 'color',
										'id'          => 'color-content-border',
										'label'       => esc_html__( 'Borders color', 'receptar' ),
										'default'     => '#eaecee',
									),



							/**
							 * Sidebar colors
							 */

								100 . 'colors' . 30 . 200 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Secondary content colors', 'receptar' ) . '</h3><p class="description">' . esc_html__( 'These colors are used for comments area, pagination.', 'receptar' ) . '</p>',
								),

									100 . 'colors' . 30 . 210 => array(
										'type'    => 'color',
										'id'      => 'color-content-alt-background',
										'label'   => esc_html__( 'Background color', 'receptar' ),
										'default' => '#2a2c2e',
									),
									100 . 'colors' . 30 . 220 => array(
										'type'        => 'color',
										'id'          => 'color-content-alt-text',
										'label'       => esc_html__( 'Text color', 'receptar' ),
										'default'     => '#9a9c9e',
									),
									100 . 'colors' . 30 . 230 => array(
										'type'        => 'color',
										'id'          => 'color-content-alt-headings',
										'label'       => esc_html__( 'Headings color', 'receptar' ),
										'default'     => '#ffffff',
									),
									100 . 'colors' . 30 . 240 => array(
										'type'        => 'color',
										'id'          => 'color-content-alt-border',
										'label'       => esc_html__( 'Borders color', 'receptar' ),
										'default'     => '#3a3c3e',
									),



							/**
							 * Sidebar colors
							 */

								100 . 'colors' . 30 . 300 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Sidebar', 'receptar' ) . '</h3>',
								),

									100 . 'colors' . 30 . 310 => array(
										'type'    => 'color',
										'id'      => 'color-sidebar-background',
										'label'   => esc_html__( 'Background color', 'receptar' ),
										'default' => '#1a1c1e',
									),
									100 . 'colors' . 30 . 320 => array(
										'type'        => 'color',
										'id'          => 'color-sidebar-text',
										'label'       => esc_html__( 'Text color', 'receptar' ),
										'default'     => '#9a9c9e',
									),
									100 . 'colors' . 30 . 330 => array(
										'type'        => 'color',
										'id'          => 'color-sidebar-headings',
										'label'       => esc_html__( 'Headings color', 'receptar' ),
										'default'     => '#ffffff',
									),
									100 . 'colors' . 30 . 340 => array(
										'type'        => 'color',
										'id'          => 'color-sidebar-border',
										'label'       => esc_html__( 'Borders color', 'receptar' ),
										'default'     => '#3a3c3e',
									),



						/**
						 * Colors: Footer
						 */
						100 . 'colors' . 40 => array(
							'id'             => 'colors-footer',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'receptar' ), esc_html_x( 'Footer', 'Customizer color section title', 'receptar' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'receptar' ),
						),



							/**
							 * Footer colors
							 */

								100 . 'colors' . 40 . 100 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Footer', 'receptar' ) . '</h3>',
								),

									100 . 'colors' . 40 . 110 => array(
										'type'    => 'color',
										'id'      => 'color-footer-background',
										'label'   => esc_html__( 'Background color', 'receptar' ),
										'default' => '#f5f7f9',
									),
									100 . 'colors' . 40 . 120 => array(
										'type'    => 'color',
										'id'      => 'color-footer-text',
										'label'   => esc_html__( 'Text color', 'receptar' ),
										'default' => '#9a9c9e',
									),



						/**
						 * Texts
						 *
						 * Don't use `preview_js` here as it outputs escaped HTML.
						 */
						800 . 'texts' => array(
							'id'             => 'texts',
							'type'           => 'section',
							'create_section' => esc_html_x( 'Texts', 'Customizer section title.', 'receptar' ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'receptar' ),
						),

							800 . 'texts' . 500 => array(
								'type'        => 'textarea',
								'id'          => 'texts_site_info',
								'label'       => esc_html__( 'Footer credits (copyright)', 'receptar' ),
								'description' => sprintf( esc_html__( 'Set %s to disable this area.', 'receptar' ), '<code>-</code>' ) . ' ' . esc_html__( 'Leaving the field empty will fall back to default theme setting.', 'receptar' ) . ' ' . sprintf( esc_html__( 'You can use %s to display dynamic, always current year.', 'receptar' ), '<code>[year]</code>' ),
								'default'     => '',
								'validate'    => 'wp_kses_post',
								'preview_js'  => array(
									'custom' => "jQuery( '.site-info' ).html( to ); if ( '-' === to ) { jQuery( '.footer-area-site-info' ).hide(); } else { jQuery( '.footer-area-site-info:hidden' ).show(); }",
								),
							),



						/**
						 * Fonts
						 */
						900 . 'typography' => array(
							'id'             => 'fonts',
							'type'           => 'section',
							'create_section' => esc_html_x( 'Typography', 'Customizer section title.', 'receptar' ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'receptar' ),
						),

							900 . 'typography' . 100 => array(
								'type'    => 'html',
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
										. '<code>.site-title, h1, .h1, blockquote</code>'
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


			// Output

				return apply_filters( 'wmhook_receptar_theme_options_array_output', $options );

		}
	} // /receptar_theme_options_array



	/**
	 * Header background RGBA
	 *
	 * @since    1.0.0
	 * @version  1.4.0
	 *
	 * @param  array  $replacements
	 * @param  array  $theme_options
	 * @param  string $output
	 */
	if ( ! function_exists( 'receptar_custom_css_replacements' ) ) {
		function receptar_custom_css_replacements( $replacements, $theme_options, $output ) {
			//Helper variables
				$option_key = 100 . 'colors' . 20 . 110;

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
	 * @version  1.6.0
	 *
	 * @param  string $styles
	 */
	if ( ! function_exists( 'receptar_custom_css_template' ) ) {
		function receptar_custom_css_template( $styles = '' ) {
			//Preparing output
				ob_start();

				locate_template( 'assets/css/_custom.css',      true );
				locate_template( 'assets/css/_custom-plus.css', true );

				$styles = ob_get_clean();

			//Output
				return apply_filters( 'wmhook_receptar_custom_css_template_output', $styles );
		}
	} // /receptar_custom_css_template





/**
 * 30) Partial refresh
 */

	/**
	 * Customizer partial refresh
	 *
	 * @since    1.4.1
	 * @version  1.4.1
	 *
	 * @param  object $wp_customize  WP customizer object.
	 */
	if ( ! function_exists( 'receptar_customizer_partial_refresh' ) ) {
		function receptar_customizer_partial_refresh( $wp_customize ) {

			// Requirements check

				if ( ! isset( $wp_customize->selective_refresh ) ) {
					return;
				}


			// Processing

				$wp_customize->get_setting( 'custom_logo' )->transport = 'postMessage';

				$wp_customize->selective_refresh->add_partial( 'custom_logo', array(
					'selector'            => '.site-branding',
					'container_inclusive' => false,
					'render_callback'     => 'receptar_customizer_partial_refresh_logo',
				) );

		}
	} // /receptar_customizer_partial_refresh

	add_filter( 'customize_register', 'receptar_customizer_partial_refresh', 999 );



		/**
		 * Customizer partial refresh helper: site logo
		 *
		 * @since    1.4.1
		 * @version  1.4.1
		 */
		if ( ! function_exists( 'receptar_customizer_partial_refresh_logo' ) ) {
			function receptar_customizer_partial_refresh_logo() {

				// Output

					receptar_logo( false );

			}
		} // /receptar_customizer_partial_refresh_logo
