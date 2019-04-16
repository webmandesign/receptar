<?php
/**
 * Customizer options generator
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.8.0
 *
 * CONTENT:
 * 10) Assets
 * 20) Main customizer function
 * 30) CSS variables
 */





/**
 * 10) Assets
 */

	/**
	 * Outputs customizer JavaScript
	 *
	 * This function automatically outputs theme customizer preview JavaScript for each theme option,
	 * where the `preview_js` property is set.
	 *
	 * For CSS theme option change it works by inserting a `<style>` tag into a preview HTML head for
	 * each theme option separately. This is to prevent inline styles on elements when applied with
	 * pure JS.
	 * Also, we need to create the `<style>` tag for each option separately so way we gain control
	 * over the output. If we put all the CSS into a single `<style>` tag, it would be bloated with
	 * CSS styles for every single subtle change in the theme option(s).
	 *
	 * It is possible to set up a custom JS action, not just CSS styles change. That can be used
	 * to trigger a class on an element, for example.
	 *
	 * If `preview_js => false` set, the change of the theme option won't trigger the customizer
	 * preview refresh. This is useful to disable welcome page, for example.
	 *
	 * The actual JavaScript is outputted in the footer of the page.
	 *
	 * @example
	 *   'preview_js' => array(
	 *
	 *     // Setting CSS styles:
	 *     'css' => array(
	 *
	 *       // CSS variables (the `[[id]]` gets replaced with option ID)
	 * 			 ':root' => array(
	 *         '--[[id]]',
	 *       ),
	 * 			 ':root' => array(
	 *         array(
	 *           'property' => '--[[id]]',
	 *           'suffix'   => 'px',
	 *         ),
	 *       ),
	 *
	 *       // Sets the whole value to the `css-property-name` of the `selector`
	 *       'selector' => array(
	 *         'background-color',...
	 *       ),
	 *
	 *       // Sets the `css-property-name` of the `selector` with specific settings
	 *       'selector' => array(
	 *         array(
	 *           'property'         => 'text-shadow',
	 *           'prefix'           => '0 1px 1px rgba(',
	 *           'suffix'           => ', .5)',
	 *           'process_callback' => 'themeSlug.Customize.hexToRgb',
	 *           'custom'           => '0 0 0 1em [[value]] ), 0 0 0 2em transparent, 0 0 0 3em [[value]]',
	 *         ),...
	 *       ),
	 *
	 *       // Replaces "@" in `selector` for `selector-replace-value` (such as "@ h2, @ h3" to ".footer h2, .footer h3")
	 *       'selector' => array(
	 *         'selector_replace' => 'selector-replace-value',
	 *         'selector_before'  => '@media (min-width: 80em) {',
	 *         'selector_after'   => '}',
	 *         'background-color',...
	 *       ),
	 *
	 *     ),
	 *
	 *     // And/or setting custom JavaScript:
	 *     'custom' => 'JavaScript here', // Such as "$( '.site-header' ).toggleClass( 'sticky' );"
	 *
	 *   );
	 *
	 * @uses  `wmhook_theme_options` global hook
	 *
	 * @since    1.0
	 * @version  1.8.0
	 */
	if ( ! function_exists( 'receptar_theme_customizer_js' ) ) {
		function receptar_theme_customizer_js() {

			// Variables

				$theme_options = (array) apply_filters( 'wmhook_theme_options', array() );

				ksort( $theme_options );

				$output = $output_single = '';


			// Processing

				if (
					is_array( $theme_options )
					&& ! empty( $theme_options )
				) {
					foreach ( $theme_options as $theme_option ) {
						if (
							isset( $theme_option['preview_js'] )
							&& is_array( $theme_option['preview_js'] )
						) {
							$option_id = sanitize_title( $theme_option['id'] );

							$output_single  = "wp.customize("  . PHP_EOL;
							$output_single .= "\t" . "'" . $option_id . "',"  . PHP_EOL;
							$output_single .= "\t" . "function( value ) {"  . PHP_EOL;
							$output_single .= "\t\t" . 'value.bind( function( to ) {' . PHP_EOL;

							// CSS

								if ( isset( $theme_option['preview_js']['css'] ) ) {

									$output_single .= "\t\t\t" . "var newCss = '';" . PHP_EOL.PHP_EOL;
									$output_single .= "\t\t\t" . "if ( $( '#jscss-" . $option_id . "' ).length ) { $( '#jscss-" . $option_id . "' ).remove() }" . PHP_EOL.PHP_EOL;

									foreach ( $theme_option['preview_js']['css'] as $selector => $properties ) {
										if ( is_array( $properties ) ) {
											$output_single_css = $selector_before = $selector_after = '';

											foreach ( $properties as $key => $property ) {

												// Selector setup

													if ( 'selector_replace' === $key ) {
														if ( is_array( $property ) ) {
															$selector_replaced = array();
															foreach ( $property as $replace ) {
																$selector_replaced[] = str_replace( '@', (string) $replace, $selector );
															}
															$selector = implode( ', ', $selector_replaced );
														} else {
															$selector = str_replace( '@', (string) $property, $selector );
														}
														continue;
													}

													if ( 'selector_before' === $key ) {
														$selector_before = $property;
														continue;
													}

													if ( 'selector_after' === $key ) {
														$selector_after = $property;
														continue;
													}

												// CSS properties setup

													if ( ! is_array( $property ) ) {
														$property = array( 'property' => (string) $property );
													}

													$property = wp_parse_args( (array) $property, array(
														'custom'           => '',
														'prefix'           => '',
														'process_callback' => '',
														'property'         => '',
														'suffix'           => '',
													) );

													// Replace `[[id]]` placeholder with an option ID.
													$property['property'] = str_replace(
														'[[id]]',
														$option_id,
														$property['property']
													);

													$value = ( empty( $property['process_callback'] ) ) ? ( 'to' ) : ( trim( $property['process_callback'] ) . '( to )' );

													if ( empty( $property['custom'] ) ) {
														$output_single_css .= $property['property'] . ": " . $property['prefix'] . "' + " . esc_attr( $value ) . " + '" . $property['suffix'] . "; ";
													} else {
														$output_single_css .= $property['property'] . ": " . str_replace( '[[value]]', "' + " . esc_attr( $value ) . " + '", $property['custom'] ) . "; ";
													}

											}

											$output_single .= "\t\t\t" . "newCss += '" . $selector_before . $selector . " { " . $output_single_css . "}" . $selector_after . " ';" . PHP_EOL;

										}
									}

									$output_single .= PHP_EOL . "\t\t\t" . "$( document ).find( 'head' ).append( $( '<style id=\'jscss-" . $option_id . "\'> ' + newCss + '</style>' ) );" . PHP_EOL;

								}

							// Custom JS

								if ( isset( $theme_option['preview_js']['custom'] ) ) {
									$output_single .= "\t\t" . $theme_option['preview_js']['custom'] . PHP_EOL;
								}

							$output_single .= "\t\t" . '} );' . PHP_EOL;
							$output_single .= "\t" . '}'. PHP_EOL;
							$output_single .= ');'. PHP_EOL;

							$output_single  = (string) apply_filters( 'wmhook_receptar_library_customize_preview_scripts_option_' . $option_id, $output_single );

							$output .= $output_single;

						}
					}
				}


			// Output

				if ( $output = trim( $output ) ) {
					echo (string) apply_filters( 'wmhook_receptar_library_customize_preview_scripts_output', '<!-- Theme custom scripts -->' . PHP_EOL . '<script type="text/javascript"><!--' . PHP_EOL . '( function( $ ) {' . PHP_EOL.PHP_EOL . trim( $output ) . PHP_EOL.PHP_EOL . '} )( jQuery );' . PHP_EOL . '//--></script>' );
				}

		}
	} // /receptar_theme_customizer_js





/**
 * 20) Main customizer function
 */

	/**
	 * Registering sections and options for WP Customizer
	 *
	 * @since    1.0.0
	 * @version  1.7.0
	 *
	 * @param  object $wp_customize WP customizer object.
	 */
	if ( ! function_exists( 'receptar_theme_customizer' ) ) {
		function receptar_theme_customizer( $wp_customize ) {

			// Requirements check

				if ( ! isset( $wp_customize ) ) {
					return;
				}


			// Helper variables

				$theme_options = (array) apply_filters( 'wmhook_theme_options', array() );

				ksort( $theme_options );

				$allowed_option_types = apply_filters( 'wmhook_receptar_theme_customizer_allowed_option_types', array(
						'checkbox',
						'color',
						'hidden',
						'html',
						'image',
						'multiselect',
						'radio',
						'range',
						'section',
						'select',
						'text',
						'textarea',
					) );

				// To make sure our customizer sections start after WordPress default ones

					$priority = apply_filters( 'wmhook_receptar_theme_customizer_priority', 0 );

				// Default section name in case not set (should be overwritten anyway)

					$customizer_panel   = '';
					$customizer_section = 'receptar';

				// Option type

					$type = 'theme_mod';


			// Processing

				// Set live preview for predefined controls

					$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
					$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
					$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

				// Move background color setting alongside background image

					$wp_customize->get_control( 'background_color' )->section  = 'background_image';
					$wp_customize->get_control( 'background_color' )->priority = 20;

				// Change background image section priority

					$wp_customize->get_section( 'background_image' )->priority = 30;

				// Change header image section priority

					$wp_customize->get_section( 'header_image' )->priority = 25;

				// Custom controls

					/**
					 * Custom customizer controls
					 *
					 * @link  https://github.com/bueltge/Wordpress-Theme-Customizer-Custom-Controls
					 * @link  http://ottopress.com/2012/making-a-custom-control-for-the-theme-customizer/
					 */

					require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'customizer/controls/class-Customizer_Hidden.php' );
					require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'customizer/controls/class-Customizer_HTML.php' );
					require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'customizer/controls/class-Customizer_Image.php' );
					require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'customizer/controls/class-Customizer_Multiselect.php' );
					require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'customizer/controls/class-Customizer_Select.php' );

					do_action( 'wmhook_receptar_theme_customizer_load_controls', $wp_customize );

				// Generate customizer options

					if ( is_array( $theme_options ) && ! empty( $theme_options ) ) {

						foreach ( $theme_options as $theme_option ) {

							if (
									is_array( $theme_option )
									&& isset( $theme_option['type'] )
									&& in_array( $theme_option['type'], $allowed_option_types )
								) {

								// Helper variables

									$priority++;

									$option_id = $default = $description = '';

									if ( isset( $theme_option['id'] ) ) {
										$option_id = $theme_option['id'];
									}
									if ( isset( $theme_option['default'] ) ) {
										$default = $theme_option['default'];
									}
									if ( isset( $theme_option['description'] ) ) {
										$description = $theme_option['description'];
									}

									$transport = ( isset( $theme_option['preview_js'] ) ) ? ( 'postMessage' ) : ( 'refresh' );



								/**
								 * Panels
								 *
								 * Panels are wrappers for customizer sections.
								 * Note that the panel will not display unless sections are assigned to it.
								 * Set the panel name in the section declaration with `in_panel`:
								 * - if text, this will become a panel title (ID defaults to `theme-options`)
								 * - if array, you can set `title`, `id` and `type` (the type will affect panel class)
								 * Panel has to be defined for each section to prevent all sections within a single panel.
								 *
								 * @link  http://make.wordpress.org/core/2014/07/08/customizer-improvements-in-4-0/
								 */
								if ( isset( $theme_option['in_panel'] ) ) {

									$panel_type = 'theme-options';

									if ( is_array( $theme_option['in_panel'] ) ) {

										$panel_title = isset( $theme_option['in_panel']['title'] ) ? ( $theme_option['in_panel']['title'] ) : ( '&mdash;' );
										$panel_id    = isset( $theme_option['in_panel']['id'] ) ? ( $theme_option['in_panel']['id'] ) : ( $panel_type );
										$panel_type  = isset( $theme_option['in_panel']['type'] ) ? ( $theme_option['in_panel']['type'] ) : ( $panel_type );

									} else {

										$panel_title = $theme_option['in_panel'];
										$panel_id    = $panel_type;

									}

									$panel_type = apply_filters( 'wmhook_receptar_library_customize_panel_type', $panel_type, $theme_option, $theme_options );
									$panel_id   = apply_filters( 'wmhook_receptar_library_customize_panel_id', $panel_id, $theme_option, $theme_options );

									if ( $customizer_panel !== $panel_id ) {

										$wp_customize->add_panel(
												$panel_id,
												array(
													'title'       => esc_html( $panel_title ),
													'description' => ( isset( $theme_option['in_panel-description'] ) ) ? ( $theme_option['in_panel-description'] ) : ( '' ), // Hidden at the top of the panel
													'priority'    => $priority,
													'type'        => $panel_type, // Sets also the panel class
												)
											);

										$customizer_panel = $panel_id;

									}

								}



								/**
								 * Sections
								 */
								if ( isset( $theme_option['create_section'] ) && trim( $theme_option['create_section'] ) ) {

									if ( empty( $option_id ) ) {
										$option_id = sanitize_title( trim( $theme_option['create_section'] ) );
									}

									$customizer_section = array(
											'id'    => $option_id,
											'setup' => array(
													'title'       => $theme_option['create_section'], // Section title
													'description' => ( isset( $theme_option['create_section-description'] ) ) ? ( $theme_option['create_section-description'] ) : ( '' ), // Displayed at the top of section
													'priority'    => $priority,
													'type'        => 'theme-options', // Sets also the section class
												)
										);

									if ( ! isset( $theme_option['in_panel'] ) ) {
										$customizer_panel = '';
									} else {
										$customizer_section['setup']['panel'] = $customizer_panel;
									}

									$wp_customize->add_section(
											$customizer_section['id'],
											$customizer_section['setup']
										);

									$customizer_section = $customizer_section['id'];

								}



								/**
								 * Options generator
								 */
								switch ( $theme_option['type'] ) {

									/**
									 * Color
									 */
									case 'color':

										$wp_customize->add_setting(
												$option_id,
												array(
													'type'                 => 'theme_mod',
													'default'              => trim( $default, '#' ),
													'transport'            => $transport,
													'sanitize_callback'    => 'sanitize_hex_color_no_hash',
													'sanitize_js_callback' => 'maybe_hash_hex_color',
												)
											);

										$wp_customize->add_control( new WP_Customize_Color_Control(
												$wp_customize,
												$option_id,
												array(
													'label'       => $theme_option['label'],
													'description' => $description,
													'section'     => $customizer_section,
													'priority'    => $priority,
												)
											) );

									break;

									/**
									 * Hidden
									 */
									case 'hidden':

										$wp_customize->add_setting(
												$option_id,
												array(
													'type'                 => 'theme_mod',
													'default'              => $default,
													'transport'            => $transport,
													'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_attr' ),
													'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_attr' ),
												)
											);

										$wp_customize->add_control( new Receptar_Customizer_Hidden(
												$wp_customize,
												$option_id,
												array(
													'label'    => 'HIDDEN FIELD',
													'section'  => $customizer_section,
													'priority' => $priority,
												)
											) );

									break;

									/**
									 * HTML
									 */
									case 'html':

										if ( empty( $option_id ) ) {
											$option_id = 'custom-title-' . $priority;
										}

										$wp_customize->add_setting(
												$option_id,
												array(
													'sanitize_callback'    => 'wp_kses_post',
													'sanitize_js_callback' => 'wp_kses_post',
												)
											);

										$wp_customize->add_control( new Receptar_Customizer_HTML(
												$wp_customize,
												$option_id,
												array(
													'label'    => $theme_option['content'],
													'section'  => $customizer_section,
													'priority' => $priority,
												)
											) );

									break;

									/**
									 * Image
									 */
									case 'image':

										$wp_customize->add_setting(
												$option_id,
												array(
													'type'                 => 'theme_mod',
													'default'              => $default,
													'transport'            => $transport,
													'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_url_raw' ),
													'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_url_raw' ),
												)
											);

										$wp_customize->add_control( new Receptar_Customizer_Image(
												$wp_customize,
												$option_id,
												array(
													'label'       => $theme_option['label'],
													'description' => $description,
													'section'     => $customizer_section,
													'priority'    => $priority,
													'context'     => $option_id,
												)
											) );

									break;

									/**
									 * Checkbox, radio
									 */
									case 'checkbox':
									case 'radio':

										$wp_customize->add_setting(
												$option_id,
												array(
													'type'                 => 'theme_mod',
													'default'              => $default,
													'transport'            => $transport,
													'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_attr' ),
													'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_attr' ),
												)
											);

										$wp_customize->add_control(
												$option_id,
												array(
													'label'       => $theme_option['label'],
													'description' => $description,
													'section'     => $customizer_section,
													'priority'    => $priority,
													'type'        => $theme_option['type'],
													'choices'     => ( isset( $theme_option['options'] ) ) ? ( $theme_option['options'] ) : ( '' ),
												)
											);

									break;

									/**
									 * Multiselect
									 */
									case 'multiselect':

										$wp_customize->add_setting(
												$option_id,
												array(
													'type'                 => 'theme_mod',
													'default'              => $default,
													'transport'            => $transport,
													'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'Receptar_Library_Sanitize::multi_array' ),
													'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'Receptar_Library_Sanitize::multi_array' ),
												)
											);

										$wp_customize->add_control( new Receptar_Customizer_Multiselect(
												$wp_customize,
												$option_id,
												array(
													'label'       => $theme_option['label'],
													'description' => $description,
													'section'     => $customizer_section,
													'priority'    => $priority,
													'choices'     => ( isset( $theme_option['options'] ) ) ? ( $theme_option['options'] ) : ( '' ),
												)
											) );

									break;

									/**
									 * Range
									 */
									case 'range':

										$wp_customize->add_setting(
												$option_id,
												array(
													'type'                 => 'theme_mod',
													'default'              => $default,
													'transport'            => $transport,
													'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'absint' ),
													'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'absint' ),
												)
											);

										$wp_customize->add_control(
												$option_id,
												array(
													'label'       => $theme_option['label'],
													'description' => $description,
													'section'     => $customizer_section,
													'priority'    => $priority,
													'type'        => 'range',
													'input_attrs' => array(
														'min'  => ( isset( $theme_option['min'] ) ) ? ( intval( $theme_option['min'] ) ) : ( 0 ),
														'max'  => ( isset( $theme_option['max'] ) ) ? ( intval( $theme_option['max'] ) ) : ( 100 ),
														'step' => ( isset( $theme_option['step'] ) ) ? ( intval( $theme_option['step'] ) ) : ( 1 ),
													),
												)
											);

									break;

									/**
									 * Select (with optgroups)
									 */
									case 'select':

										$wp_customize->add_setting(
												$option_id,
												array(
													'type'                 => 'theme_mod',
													'default'              => $default,
													'transport'            => $transport,
													'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_attr' ),
													'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_attr' ),
												)
											);

										$wp_customize->add_control( new Receptar_Customizer_Select(
												$wp_customize,
												$option_id,
												array(
													'label'       => $theme_option['label'],
													'description' => $description,
													'section'     => $customizer_section,
													'priority'    => $priority,
													'choices'     => ( isset( $theme_option['options'] ) ) ? ( $theme_option['options'] ) : ( '' ),
												)
											) );

									break;

									/**
									 * Text
									 */
									case 'text':

										$wp_customize->add_setting(
												$option_id,
												array(
													'type'                 => 'theme_mod',
													'default'              => $default,
													'transport'            => $transport,
													'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_textarea' ),
													'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_textarea' ),
												)
											);

										$wp_customize->add_control(
												$option_id,
												array(
													'label'       => $theme_option['label'],
													'description' => $description,
													'section'     => $customizer_section,
													'priority'    => $priority,
												)
											);

									break;

									/**
									 * Textarea
									 *
									 * Since WordPress 4.0 this is native input field.
									 */
									case 'textarea':

										$wp_customize->add_setting(
												$option_id,
												array(
													'type'                 => 'theme_mod',
													'default'              => $default,
													'transport'            => $transport,
													'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_textarea' ),
													'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_textarea' ),
												)
											);

										$wp_customize->add_control(
												$option_id,
												array(
													'type'        => 'textarea',
													'label'       => $theme_option['label'],
													'description' => $description,
													'section'     => $customizer_section,
													'priority'    => $priority,
												)
											);

									break;

									/**
									 * Default
									 */
									default:
									break;

								} // /switch

							} // /if suitable option array

						} // /foreach

					} // /if skin options are non-empty array

				// Assets needed for customizer preview

					if ( $wp_customize->is_preview() ) {

						add_action( 'wp_footer', 'receptar_theme_customizer_js', 99 );

					}

		}
	} // /receptar_theme_customizer

	add_action( 'customize_register', 'receptar_theme_customizer' );





/**
 * 30) CSS variables
 */

	/**
	 * Ensure compatibility with older browsers.
	 *
	 * @link  https://github.com/jhildenbiddle/css-vars-ponyfill
	 *
	 * @since    1.7.0
	 * @version  1.8.0
	 */
	if ( ! function_exists( 'receptar_css_vars_compatibility' ) ) {
		function receptar_css_vars_compatibility() {

			// Processing

				wp_enqueue_script(
					'css-vars-ponyfill',
					trailingslashit( get_template_directory_uri() ) . 'assets/js/vendor/css-vars-ponyfill/css-vars-ponyfill.min.js',
					array(),
					'1.16.1'
				);

				wp_add_inline_script(
					'css-vars-ponyfill',
					'window.onload = function() {' . PHP_EOL .
					"\t" . 'cssVars( {' . PHP_EOL .
					"\t\t" . 'onlyVars: true,' . PHP_EOL .
					"\t\t" . 'exclude: \'link:not([href^="' . esc_url_raw( get_theme_root_uri() ) . '"])\'' . PHP_EOL .
					"\t" . '} );' . PHP_EOL .
					'};'
				);

		}
	} // /receptar_css_vars_compatibility

	add_action( 'wp_enqueue_scripts', 'receptar_css_vars_compatibility', 0 );



	/**
	 * Get CSS vars from theme options.
	 *
	 * @since    1.7.0
	 * @version  1.8.0
	 */
	if ( ! function_exists( 'receptar_get_css_vars_from_theme_options' ) ) {
		function receptar_get_css_vars_from_theme_options() {

			// Variables

				$is_customize_preview = is_customize_preview();
				$cache_transient      = receptar_get_transient_key( 'css-vars' );

				$css_vars = (string) get_transient( $cache_transient );


			// Requirements check

				if (
					! empty( $css_vars )
					&& ! $is_customize_preview
				) {
					return (string) $css_vars;
				}


			// Processing

				foreach ( (array) apply_filters( 'wmhook_theme_options', array() ) as $option ) {
					if ( ! isset( $option['css_var'] ) ) {
						continue;
					}

					if ( isset( $option['default'] ) ) {
						$value = $option['default'];
					} else {
						$value = '';
					}

					$mod = get_theme_mod( $option['id'] );
					if (
						isset( $option['validate'] )
						&& is_callable( $option['validate'] )
					) {
						$mod = call_user_func( $option['validate'], $mod );
					}
					if (
						! empty( $mod )
						|| 'checkbox' === $option['type']
					) {
						if ( 'color' === $option['type'] ) {
							$value_check = maybe_hash_hex_color( $value );
							$mod         = maybe_hash_hex_color( $mod );
						} else {
							$value_check = $value;
						}
						// No need to output CSS var if it is the same as default.
						if ( $value_check === $mod ) {
							continue;
						}
						$value = $mod;
					} else {
						// No need to output CSS var if it was not changed in customizer.
						continue;
					}

					// Array value to string. Just in case.
					if ( is_array( $value ) ) {
						$value = (string) implode( ',', (array) $value );
					}

					if ( is_callable( $option['css_var'] ) ) {
						$value = call_user_func( $option['css_var'], $value );
					} else {
						$value = str_replace(
							'[[value]]',
							$value,
							(string) $option['css_var']
						);
					}

					// Do not apply `esc_attr()` as it will escape quote marks, such as in background image URL.
					$css_vars .= ' --' . sanitize_title( $option['id'] ) . ': ' . $value . ';';
				}

				// Cache the results.
				if ( ! $is_customize_preview ) {
					set_transient( $cache_transient, $css_vars );
				}


			// Output

				return (string) $css_vars;

		}
	} // /receptar_get_css_vars_from_theme_options



	/**
	 * Customized styles.
	 *
	 * @since    1.7.0
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_customized_styles' ) ) {
		function receptar_customized_styles() {

			// Processing

				if ( $css_vars = receptar_get_css_vars_from_theme_options() ) {

					$css_vars = (string) apply_filters( 'wmhook_receptar_customized_styles',
						'/* START CSS variables */'
						. PHP_EOL
						. ':root { '
						. PHP_EOL
						. $css_vars
						. PHP_EOL
						. '}'
						. PHP_EOL
						. '/* END CSS variables */'
					);

					wp_add_inline_style(
						'receptar',
						apply_filters( 'wmhook_esc_css', $css_vars )
					);

				}

		}
	} // /receptar_customized_styles

	add_action( 'wp_enqueue_scripts', 'receptar_customized_styles', 105 );



	/**
	 * Customized styles: editor.
	 *
	 * Ajax callback for outputting custom styles for content editor.
	 *
	 * @see  https://github.com/justintadlock/stargazer/blob/master/inc/custom-colors.php
	 *
	 * @since    1.7.0
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_customized_styles_editor' ) ) {
		function receptar_customized_styles_editor() {

			// Processing

				if ( $css_vars = receptar_get_css_vars_from_theme_options() ) {
					header( 'Content-type: text/css' );

					$css_vars = (string) apply_filters( 'wmhook_receptar_customized_styles_editor',
						'/* START CSS variables */'
						. PHP_EOL
						. ':root { '
						. PHP_EOL
						. $css_vars
						. PHP_EOL
						. '}'
						. PHP_EOL
						. '/* END CSS variables */'
					);

					echo (string) apply_filters( 'wmhook_esc_css', $css_vars );
				}

				die();

		}
	} // /receptar_customized_styles_editor

	add_action( 'wp_ajax_receptar_editor_styles',         'receptar_customized_styles_editor' );
	add_action( 'wp_ajax_no_priv_receptar_editor_styles', 'receptar_customized_styles_editor' );



		/**
		 * Enqueue customized styles as editor stylesheet.
		 *
		 * @since    1.7.0
		 * @version  1.7.0
		 *
		 * @param  array $visual_editor_css
		 */
		if ( ! function_exists( 'receptar_customized_styles_editor_enqueue' ) ) {
			function receptar_customized_styles_editor_enqueue( $visual_editor_css = array() ) {

				// Processing

					/**
					 * @see  `stargazer_get_editor_styles` https://github.com/justintadlock/stargazer/blob/master/inc/stargazer.php
					 */
					$visual_editor_css[] = esc_url_raw( add_query_arg(
						array(
							'action' => 'receptar_editor_styles',
							'ver'    => wp_get_theme( get_template() )->get( 'Version' ) . '.' . get_theme_mod( '__customize_timestamp' ),
						),
						admin_url( 'admin-ajax.php' )
					) );


				// Output

					return $visual_editor_css;

			}
		} // /receptar_customized_styles_editor_enqueue

		add_filter( 'wmhook_receptar_setup_visual_editor_css', 'receptar_customized_styles_editor_enqueue' );



	/**
	 * Customizer save timestamp.
	 *
	 * @since    1.7.0
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_customize_timestamp' ) ) {
		function receptar_customize_timestamp() {

			// Processing

				set_theme_mod( '__customize_timestamp', esc_attr( gmdate( 'ymdHis' ) ) );

		}
	} // /receptar_customize_timestamp

	add_action( 'customize_save_after', 'receptar_customize_timestamp' );



	/**
	 * Cache: Flush CSS vars.
	 *
	 * @since    1.7.0
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_cache_flush_css_vars' ) ) {
		function receptar_cache_flush_css_vars() {

			// Processing

				delete_transient( receptar_get_transient_key( 'css-vars' ) );

		}
	} // /receptar_cache_flush_css_vars

	add_action( 'switch_theme',         'receptar_cache_flush_css_vars' );
	add_action( 'customize_save_after', 'receptar_cache_flush_css_vars' );
	add_action( 'wmhook_theme_upgrade', 'receptar_cache_flush_css_vars' );
