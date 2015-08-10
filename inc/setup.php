<?php
/**
 * Theme setup
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.3.5
 *
 * CONTENT:
 * -  10) Actions and filters
 * -  20) Global variables
 * -  30) Theme setup
 * -  40) Assets and design
 * -  50) Site global markup
 * - 100) Other functions
 */





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Styles and scripts
			add_action( 'init',                'receptar_register_assets',           10 );
			add_action( 'wp_enqueue_scripts',  'receptar_enqueue_assets',           100 );
			add_action( 'wp_enqueue_scripts',  'receptar_singular_featured_image',  110 );
			add_action( 'wp_footer',           'receptar_footer_custom_scripts',   9998 );
			add_action( 'comment_form_before', 'receptar_comment_reply_js_enqueue'      );
			add_action( 'switch_theme',        'receptar_image_sizes_reset'             );
		//Customizer assets
			add_action( 'customize_controls_enqueue_scripts', 'receptar_customizer_enqueue_assets'             );
			add_action( 'customize_preview_init',             'receptar_customizer_preview_enqueue_assets', 10 );
		//Theme setup
			add_action( 'after_setup_theme', 'receptar_setup', 10 );
		//Register widget areas
			add_action( 'widgets_init', 'receptar_register_widget_areas', 1 );
		//Sticky posts
			add_action( 'pre_get_posts', 'receptar_posts_query_ignore_sticky_posts' );
		//Pagination fallback
			add_action( 'wmhook_postslist_after', 'receptar_pagination', 10 );
		//Visual Editor addons
			add_action( 'init',                                            'receptar_visual_editor',                  999 );
			add_filter( 'wmhook_receptar_custom_mce_format_style_formats', 'receptar_visual_editor_custom_mce_format'     );
		//Display Settings > Media recommended images sizes notice
			add_action( 'admin_init', 'receptar_image_size_notice' );
		//Website sections
			//DOCTYPE
				add_action( 'wmhook_html_before',               'receptar_doctype',          10 );
			//HEAD
				add_action( 'wp_head',                          'receptar_head',              1 );
			//Body
				add_action( 'wmhook_body_top',                  'receptar_site_top',         10 );
				add_action( 'wmhook_body_bottom',               'receptar_site_bottom',     100 );
			//Header
				add_action( 'wmhook_header_top',                'receptar_header_top',       10 );
				add_action( 'wmhook_header',                    'receptar_logo',             10 );
				add_action( 'wmhook_header',                    'get_sidebar',               20 );
				add_action( 'wmhook_header',                    'receptar_header_widgets',   30 );
				add_action( 'wmhook_header_bottom',             'receptar_header_bottom',    10 );
				add_action( 'wmhook_secondary_content_top',     'receptar_logo',             10 );
				add_action( 'wmhook_secondary_controls_bottom', 'receptar_post_nav',         10 );
				add_action( 'wmhook_secondary_controls_bottom', 'receptar_menu_social',      20 );
			//Content
				add_action( 'wmhook_content_top',               'receptar_content_top',      10 );
				add_action( 'wmhook_entry_top',                 'receptar_entry_top',        10 );
				add_action( 'wmhook_entry_top',                 'receptar_post_title',       20 );
				add_action( 'wmhook_entry_top',                 'receptar_breadcrumbs',      30 );
				add_action( 'wmhook_entry_bottom',              'receptar_entry_bottom',     10 );
				add_action( 'wmhook_comments_before',           'receptar_comments_before',  10 );
				add_action( 'wmhook_comments_after',            'receptar_comments_after',   10 );
				add_action( 'wmhook_content_bottom',            'receptar_content_bottom',  100 );
				add_action( 'wmhook_postslist_before',          'receptar_breadcrumbs',      10 );
				add_action( 'wmhook_postslist_before',          'receptar_breadcrumbs_off',  20 );
			//Footer
				add_action( 'wmhook_footer_top',                'receptar_footer_top',      100 );
				add_action( 'wmhook_footer',                    'receptar_footer',          100 );
				add_action( 'wmhook_footer_bottom',             'receptar_footer_bottom',   100 );



	/**
	 * Filters
	 */

		//Disable TGMPA - not needed
			add_filter( 'wmhook_enable_plugins_integration', '__return_false' );
		//Set up image sizes
			add_filter( 'wmhook_receptar_setup_image_sizes', 'receptar_image_sizes' );
		//Set required Google Fonts
			add_filter( 'wmhook_receptar_google_fonts_url_fonts_setup', 'receptar_google_fonts' );
		//BODY classes
			add_filter( 'body_class', 'receptar_body_classes', 98 );
		//Post classes
			add_filter( 'post_class', 'receptar_post_classes', 98 );
		//Navigation improvements
			add_filter( 'walker_nav_menu_start_el', 'receptar_nav_item_process', 10, 4 );
		//Excerpt modifications
			add_filter( 'the_excerpt',                              'receptar_remove_shortcodes',        10 );
			add_filter( 'the_excerpt',                              'receptar_excerpt',                  20 );
			add_filter( 'excerpt_length',                           'receptar_excerpt_length',           10 );
			add_filter( 'excerpt_more',                             'receptar_excerpt_more',             10 );
			add_filter( 'wmhook_receptar_excerpt_continue_reading', 'receptar_excerpt_continue_reading', 10 );
		//Entry HTML attributes
			add_filter( 'wmhook_entry_container_atts', 'receptar_entry_container_atts', 10 );
		//Post thumbnail
			add_filter( 'wmhook_entry_featured_image_size',         'receptar_post_thumbnail_size'               );
			add_filter( 'wmhook_entry_featured_image_fallback_url', 'receptar_entry_featured_image_fallback_url' );
		//Comments form
			add_filter( 'comment_form_default_fields', 'receptar_comments_form_placeholders' );
			add_filter( 'comment_form_field_comment',  'receptar_comments_form_placeholders' );





/**
 * 20) Global variables
 */

	/**
	 * Max content width
	 *
	 * Required here, because we don't set it up in functions.php.
	 * The $content_width is calculated as golden ratio of the site container width.
	 */

		if ( ! isset( $content_width ) || ! $content_width ) {
			global $content_width;
			$content_width = 960;
		}





/**
 * 30) Theme setup
 */

	/**
	 * Theme setup
	 *
	 * @since    1.0
	 * @version  1.3
	 */
	if ( ! function_exists( 'receptar_setup' ) ) {
		function receptar_setup() {

			//Helper variables
				$image_sizes = array_filter( apply_filters( 'wmhook_receptar_setup_image_sizes', array() ) );

				//WordPress visual editor CSS stylesheets
					$visual_editor_css = array_filter( (array) apply_filters( 'wmhook_receptar_setup_visual_editor_css', array(
							str_replace( ',', '%2C', receptar_google_fonts_url() ),
							esc_url( add_query_arg( array( 'ver' => wp_get_theme()->get( 'Version' ) ), receptar_get_stylesheet_directory_uri( 'genericons/genericons.css' ) ) ),
							esc_url( add_query_arg( array( 'ver' => wp_get_theme()->get( 'Version' ) ), receptar_get_stylesheet_directory_uri( 'css/editor-style.css' ) ) ),
						) ) );

			/**
			 * Localization
			 *
			 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
			 */

				//wp-content/languages/theme-name/it_IT.mo
					load_theme_textdomain( 'receptar', trailingslashit( WP_LANG_DIR ) . 'themes/' . WM_THEME_SHORTNAME );

				//wp-content/themes/child-theme-name/languages/it_IT.mo
					load_theme_textdomain( 'receptar', get_stylesheet_directory() . '/languages' );

				//wp-content/themes/theme-name/languages/it_IT.mo
					load_theme_textdomain( 'receptar', get_template_directory() . '/languages' );

			//Title tag
				add_theme_support( 'title-tag' );

			//Visual editor styles
				add_editor_style( $visual_editor_css );

			//Feed links
				add_theme_support( 'automatic-feed-links' );

			//Enable HTML5 markup
				add_theme_support( 'html5', array(
						'comment-list',
						'comment-form',
						'search-form',
						'gallery',
						'caption',
					) );

			//Custom menus
				register_nav_menus( apply_filters( 'wmhook_receptar_setup_menus', array(
						'primary' => esc_html__( 'Primary Menu', 'receptar' ),
						'social'  => esc_html__( 'Social Links Menu', 'receptar' ),
					) ) );

			//Custom header
				add_theme_support( 'custom-header', apply_filters( 'wmhook_receptar_setup_custom_background_args', array(
						'default-image' => receptar_get_stylesheet_directory_uri( 'images/header.jpg' ),
						'header-text'   => false,
						'width'         => 1920,
						'height'        => 640, //Approx. 62% of desktop viewport height (16:9)
						'flex-height'   => false,
						'flex-width'    => true,
					) ) );

			//Custom background
				add_theme_support( 'custom-background', apply_filters( 'wmhook_receptar_setup_custom_background_args', array(
						'default-color' => 'f5f7f9',
					) ) );

			//Post types supports
				add_post_type_support( 'attachment', 'custom-fields' );

			//Thumbnails support
				add_post_type_support( 'attachment:audio', 'thumbnail' );
				add_post_type_support( 'attachment:video', 'thumbnail' );

				add_theme_support( 'post-thumbnails', array( 'attachment:audio', 'attachment:video' ) );
				add_theme_support( 'post-thumbnails' );

				//Image sizes (x, y, crop)
					if ( ! empty( $image_sizes ) ) {

						foreach ( $image_sizes as $size => $setup ) {

							if (
									in_array( $size, array( 'thumbnail', 'medium', 'large' ) )
									&& ! get_theme_mod( '__image_size-' . $size )
								) {

								/**
								 * Force the default image sizes on theme installation only.
								 * This allows users to set their own sizes later, but a notification is displayed.
								 */

								$original_image_width = get_option( $size . '_size_w' );

									if ( $image_sizes[ $size ][0] != $original_image_width ) {
										update_option( $size . '_size_w', $image_sizes[ $size ][0] );
									}

								$original_image_height = get_option( $size . '_size_h' );

									if ( $image_sizes[ $size ][1] != $original_image_height ) {
										update_option( $size . '_size_h', $image_sizes[ $size ][1] );
									}

								$original_image_crop = get_option( $size . '_crop' );

									if ( $image_sizes[ $size ][2] != $original_image_crop ) {
										update_option( $size . '_crop', $image_sizes[ $size ][2] );
									}

								set_theme_mod(
										'__image_size_' . $size,
										array(
											$original_image_width,
											$original_image_height,
											$original_image_crop
										)
									);

							} else {

								add_image_size(
										$size,
										$image_sizes[ $size ][0],
										$image_sizes[ $size ][1],
										$image_sizes[ $size ][2]
									);

							}

						} // /foreach

					}

		}
	} // /receptar_setup



	/**
	 * Setup images
	 */

		/**
		 * Image sizes
		 *
		 * @example
		 *
		 *   $image_sizes = array(
		 *     'image_size_id' => array(
		 *       absint( width ),
		 *       absint( height ),
		 *       (bool) cropped?,
		 *       (string) optional_theme_usage_explanation_text
		 *     )
		 *   );
		 *
		 * @since    1.0
		 * @version  1.3
		 *
		 * @param  array $image_sizes
		 */
		if ( ! function_exists( 'receptar_image_sizes' ) ) {
			function receptar_image_sizes( $image_sizes ) {
				//Helper variables
					global $content_width;

				//Preparing output
					/**
					 * image_size = array(
					 *   width,
					 *   height,
					 *   cropped?,
					 *   theme_usage //Optional
					 * )
					 */
					$image_sizes = array(
							'thumbnail' => array(
									480,
									640,
									true,
									esc_html__( 'In posts list.', 'receptar' )
								),
							'medium' => array(
									absint( $content_width * .62 ),
									9999,
									false
								),
							'large' => array(
									absint( $content_width ),
									9999,
									false,
									esc_html__( 'In single post page.', 'receptar' )
								),
							'receptar-banner' => array(
									1920,
									640, //Approx. 62% of desktop viewport height (16:9)
									true,
									esc_html__( 'In front (and blog) page banner.', 'receptar' )
								),
							'receptar-featured' => array(
									absint( $content_width ),
									absint( $content_width / 3 * 2 ),
									true,
									esc_html__( 'In single post page on mobile devices only.', 'receptar' )
								),
						);

				//Output
					return $image_sizes;
			}
		} // /receptar_image_sizes



		/**
		 * Reset predefined image sizes to their original values
		 *
		 * @since    1.3.1
		 * @version  1.3.1
		 */
		if ( ! function_exists( 'receptar_image_sizes_reset' ) ) {
			function receptar_image_sizes_reset() {

				// Helper variables

					$image_sizes = array( 'thumbnail', 'medium', 'large' );
					$theme_old   = get_option( 'theme_switched' );
					$theme_mods  = get_option( 'theme_mods_' . $theme_old );

					$update_theme_mods = false;


				// Processing

					foreach ( $image_sizes as $size ) {

						$values = (array) ( isset( $theme_mods[ '__image_size_' . $size ] ) ) ? ( $theme_mods[ '__image_size_' . $size ] ) : ( array() );

						// Skip processing if we do not have the image height and crop value

							if ( ! isset( $values[1] ) || ! isset( $values[2] ) ) {
								continue;
							}

						// Old image width

							if ( $values[0] ) {
								update_option( $size . '_size_w', $values[0] );
							}

						// Old image height

							if ( $values[1] ) {
								update_option( $size . '_size_h', $values[1] );
							}

						// Old image crop

							if ( $values[2] ) {
								update_option( $size . '_crop', $values[2] );
							}

						// Remove the image settings from theme mods for future reset

							unset( $theme_mods[ '__image_size_' . $size ] );

							$update_theme_mods = true;

					} // /foreach

					if ( $update_theme_mods ) {
						update_option( 'theme_mods_' . $theme_old, $theme_mods );
					}

			}
		} // /receptar_image_sizes_reset



		/**
		 * Register recommended image sizes notice
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_image_size_notice' ) ) {
			function receptar_image_size_notice() {
				add_settings_field(
						//$id
						'recommended-image-sizes',
						//$title
						'',
						//$callback
						'receptar_image_size_notice_html',
						//$page
						'media',
						//$section
						'default',
						//$args
						array()
					);

				register_setting(
						//$option_group
						'media',
						//$option_name
						'recommended-image-sizes',
						//$sanitize_callback
						'esc_attr'
					);
			}
		} // /receptar_image_size_notice



		/**
		 * Display recommended image sizes notice
		 *
		 * @since    1.0
		 * @version  1.3
		 */
		if ( ! function_exists( 'receptar_image_size_notice_html' ) ) {
			function receptar_image_size_notice_html() {
				//Helper variables
					$default_image_size_names = array(
							'thumbnail' => esc_html_x( 'Thumbnail size', 'WordPress predefined image size name.', 'receptar' ),
							'medium'    => esc_html_x( 'Medium size', 'WordPress predefined image size name.', 'receptar' ),
							'large'     => esc_html_x( 'Large size', 'WordPress predefined image size name.', 'receptar' ),
						);

					$image_sizes = array_filter( apply_filters( 'wmhook_receptar_setup_image_sizes', array() ) );

				//Requirements check
					if ( empty( $image_sizes ) ) {
						return;
					}

				//Output
					echo '<style type="text/css" media="screen">'
						. '.recommended-image-sizes { display: inline-block; padding: 1.62em; border: 2px solid #dadcde; }'
						. '.recommended-image-sizes h3:first-child { margin-top: 0; }'
						. '.recommended-image-sizes table { margin-top: 1em; }'
						. '.recommended-image-sizes th, .recommended-image-sizes td { width: auto; padding: .19em 1em; border-bottom: 2px dotted #dadcde; vertical-align: top; }'
						. '.recommended-image-sizes thead th { padding: .62em 1em; border-bottom-style: solid; }'
						. '.recommended-image-sizes tr[title] { cursor: help; }'
						. '.recommended-image-sizes .small, .recommended-image-sizes tr[title] th, .recommended-image-sizes tr[title] td { font-size: .81em; }'
						. '</style>';

					echo '<div class="recommended-image-sizes">';

						do_action( 'wmhook_receptar_image_size_notice_html_top' );

						echo '<h3>' . esc_html__( 'Recommended image sizes', 'receptar' ) . '</h3>'
							. '<p>' . esc_html__( 'For the theme to work correctly, please, set these recommended image sizes:', 'receptar' ) . '</p>';

						echo '<table>';

							echo '<thead>'
								. '<tr>'
								. '<th>' . esc_html__( 'Size name', 'receptar' ) . '</th>'
								. '<th>' . esc_html__( 'Size parameters', 'receptar' ) . '</th>'
								. '<th>' . esc_html__( 'Theme usage', 'receptar' ) . '</th>'
								. '</tr>'
								. '</thead>';

							echo '<tbody>';

								foreach ( $image_sizes as $size => $setup ) {

									$crop = ( $setup[2] ) ? ( esc_html__( 'cropped', 'receptar' ) ) : ( esc_html__( 'scaled', 'receptar' ) );

									if ( isset( $default_image_size_names[ $size ] ) ) {

										echo '<tr><th>' . esc_html( $default_image_size_names[ $size ] ) . ':</th>';

									} else {

										echo '<tr title="' . esc_attr__( 'Additional image size added by the theme. Can not be changed on this page.', 'receptar' ) . '"><th><code>' . esc_html( $size ) . '</code>:</th>';

									}

									echo '<td>' . sprintf(
											esc_html_x( '%1$d &times; %2$d, %3$s', '1: image width, 2: image height, 3: cropped or scaled?', 'receptar' ),
											absint( $setup[0] ),
											absint( $setup[1] ),
											$crop
										) . '</td>'
										. '<td class="small">' . ( ( isset( $setup[3] ) ) ? ( $setup[3] ) : ( '&mdash;' ) ) . '</td>'
										. '</tr>';

								} // /foreach

							echo '</tbody>';

						echo '</table>';

						do_action( 'wmhook_receptar_image_size_notice_html_bottom' );

					echo '</div>';
			}
		} // /receptar_image_size_notice_html



	/**
	 * Setup typography
	 */

		/**
		 * Google Fonts
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array $fonts_setup
		 */
		if ( ! function_exists( 'receptar_google_fonts' ) ) {
			function receptar_google_fonts( $fonts_setup ) {
				return array( 'Roboto', 'Roboto Condensed:400,300', 'Alegreya:400,700' );
			}
		} // /receptar_google_fonts





/**
 * 40) Assets and design
 */

	/**
	 * Registering theme styles and scripts
	 *
	 * @since    1.0
	 * @version  1.2.1
	 */
	if ( ! function_exists( 'receptar_register_assets' ) ) {
		function receptar_register_assets() {

			//Helper variables

				$version = esc_attr( trim( wp_get_theme()->get( 'Version' ) ) );

			/**
			 * Styles
			 */

				$register_styles = apply_filters( 'wmhook_receptar_register_assets_register_styles', array(
						'receptar-genericons'   => array( receptar_get_stylesheet_directory_uri( 'genericons/genericons.css' ) ),
						'receptar-google-fonts' => array( receptar_google_fonts_url() ),
						'receptar-starter'      => array( receptar_get_stylesheet_directory_uri( 'css/starter.css' ) ),
						'receptar-stylesheet'   => array( 'src' => get_stylesheet_uri(), 'deps' => array( 'receptar-genericons', 'receptar-starter' ) ),
						'receptar-colors'       => array( receptar_get_stylesheet_directory_uri( 'css/colors.css' ), 'deps' => array( 'receptar-stylesheet' ) ),
						'receptar-slick'        => array( receptar_get_stylesheet_directory_uri( 'css/slick.css' ) ),
					) );

				foreach ( $register_styles as $handle => $atts ) {
					$src   = ( isset( $atts['src'] )   ) ? ( $atts['src']   ) : ( $atts[0] );
					$deps  = ( isset( $atts['deps'] )  ) ? ( $atts['deps']  ) : ( false    );
					$ver   = ( isset( $atts['ver'] )   ) ? ( $atts['ver']   ) : ( $version );
					$media = ( isset( $atts['media'] ) ) ? ( $atts['media'] ) : ( 'all'    );

					wp_register_style( $handle, $src, $deps, $ver, $media );
				}

			/**
			 * Scripts
			 */

				$register_scripts = apply_filters( 'wmhook_receptar_register_assets_register_scripts', array(
						'receptar-slick'               => array( receptar_get_stylesheet_directory_uri( 'js/slick.min.js' ) ),
						'receptar-scripts-global'      => array( receptar_get_stylesheet_directory_uri( 'js/scripts-global.js' ) ),
						'receptar-skip-link-focus-fix' => array( receptar_get_stylesheet_directory_uri( 'js/skip-link-focus-fix.js' ) ),
					) );

				foreach ( $register_scripts as $handle => $atts ) {
					$src       = ( isset( $atts['src'] )       ) ? ( $atts['src']       ) : ( $atts[0]          );
					$deps      = ( isset( $atts['deps'] )      ) ? ( $atts['deps']      ) : ( array( 'jquery' ) );
					$ver       = ( isset( $atts['ver'] )       ) ? ( $atts['ver']       ) : ( $version          );
					$in_footer = ( isset( $atts['in_footer'] ) ) ? ( $atts['in_footer'] ) : ( true              );

					wp_register_script( $handle, $src, $deps, $ver, $in_footer );
				}

		}
	} // /receptar_register_assets



	/**
	 * Frontend HTML head assets enqueue
	 *
	 * @since    1.0
	 * @version  1.2.1
	 */
	if ( ! function_exists( 'receptar_enqueue_assets' ) ) {
		function receptar_enqueue_assets() {

			//Helper variables
				$enqueue_styles = $enqueue_scripts = array();

				$custom_styles = receptar_custom_styles();

				$inline_styles_handle = ( wp_style_is( 'receptar-colors', 'registered' ) ) ? ( 'receptar-colors' ) : ( 'receptar-stylesheet' );
				$inline_styles_handle = apply_filters( 'wmhook_receptar_enqueue_assets_inline_styles_handle', $inline_styles_handle );

			/**
			 * Styles
			 */

				//Google Fonts
					if ( receptar_google_fonts_url() ) {
						$enqueue_styles[] = 'receptar-google-fonts';
					}

				//Banner slider
					if (
							( is_front_page() || is_home() )
							&& receptar_has_banner_posts( 2 )
						) {
						$enqueue_styles[] = 'receptar-slick';
					}

				//Main
					$enqueue_styles[] = 'receptar-stylesheet';

				//Colors
					if ( 'receptar-colors' === $inline_styles_handle ) {
						$enqueue_styles[] = 'receptar-colors';
					}

				$enqueue_styles = apply_filters( 'wmhook_receptar_enqueue_assets_enqueue_styles', $enqueue_styles );

				foreach ( $enqueue_styles as $handle ) {
					wp_enqueue_style( $handle );
				}

			/**
			 * Styles - inline
			 */

				//Customizer setup custom styles
					if ( $custom_styles ) {
						wp_add_inline_style(
								$inline_styles_handle,
								"\r\n" . apply_filters( 'wmhook_esc_css', $custom_styles ) . "\r\n"
							);
					}

				//Custom styles set in post/page 'custom-css' custom field
					if (
							is_singular()
							&& $output = get_post_meta( get_the_ID(), 'custom_css', true )
						) {
						$output = apply_filters( 'wmhook_receptar_enqueue_assets_styles_inline_singular', "\r\n\r\n/* Custom singular styles */\r\n" . $output . "\r\n" );

						wp_add_inline_style(
								$inline_styles_handle,
								apply_filters( 'wmhook_esc_css', $output ) . "\r\n"
							);
					}

			/**
			 * Scripts
			 */

				//Banner slider
					if (
							( is_front_page() || is_home() )
							&& receptar_has_banner_posts( 2 )
						) {
						$enqueue_scripts[] = 'receptar-slick';
					}

				//Global theme scripts
					$enqueue_scripts[] = 'receptar-scripts-global';

				//Skip link focus fix
					$enqueue_scripts[] = 'receptar-skip-link-focus-fix';

				$enqueue_scripts = apply_filters( 'wmhook_receptar_enqueue_assets_enqueue_scripts', $enqueue_scripts );

				foreach ( $enqueue_scripts as $handle ) {
					wp_enqueue_script( $handle );
				}

		}
	} // /receptar_enqueue_assets



	/**
	 * Enqueue comment-reply.js the right way
	 *
	 * @since    1.2.1
	 * @version  1.2.1
	 */
	if ( ! function_exists( 'receptar_comment_reply_js_enqueue' ) ) {
		function receptar_comment_reply_js_enqueue() {
			if ( get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}
	} // /receptar_comment_reply_js_enqueue



	/**
	 * Customizer controls assets enqueue
	 *
	 * @since    1.0
	 * @version  1.2.1
	 */
	if ( ! function_exists( 'receptar_customizer_enqueue_assets' ) ) {
		function receptar_customizer_enqueue_assets() {
			//Styles
				wp_enqueue_style(
						'receptar-customizer',
						get_template_directory_uri() . '/css/customizer.css',
						false,
						esc_attr( trim( wp_get_theme()->get( 'Version' ) ) ),
						'all'
					);
		}
	} // /receptar_customizer_enqueue_assets



		/**
		 * Customizer preview assets enqueue
		 *
		 * @since    1.0
		 * @version  1.2.1
		 */
		if ( ! function_exists( 'receptar_customizer_preview_enqueue_assets' ) ) {
			function receptar_customizer_preview_enqueue_assets() {
				//Scripts
					wp_enqueue_script(
							'receptar-customizer-preview',
							receptar_get_stylesheet_directory_uri( 'js/customizer-preview.js' ),
							array( 'customize-preview' ),
							esc_attr( trim( wp_get_theme()->get( 'Version' ) ) ),
							true
						);
			}
		} // /receptar_customizer_preview_enqueue_assets



	/**
	 * HTML Body classes
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $classes
	 */
	if ( ! function_exists( 'receptar_body_classes' ) ) {
		function receptar_body_classes( $classes ) {
			//Helper variables
				$body_classes = array();

				$i = 0;

			//Preparing output
				//Is not front page?
					if ( ! is_front_page() ) {
						$body_classes['not-front-page'] = ++$i;
					}

				//Singular?
					if ( is_singular() ) {
						$body_classes['is-singular'] = ++$i;
					} else {
						$body_classes['is-not-singular'] = ++$i;
					}

				//Has featured image?
					if ( is_singular() && has_post_thumbnail() ) {
						$body_classes['has-post-thumbnail'] = ++$i;
					}

				//Is posts list?
					if ( is_archive() || is_search() ) {
						$body_classes['is-posts-list'] = ++$i;
					}

				//Featured posts
					if (
							class_exists( 'NS_Featured_Posts' )
							&& (
									is_home()
									|| is_archive()
									|| is_search()
								)
						) {
						$body_classes['has-featured-posts'] = ++$i;
					}

			//Output
				$body_classes = array_filter( (array) apply_filters( 'wmhook_receptar_body_classes_output', $body_classes ) );
				$classes      = array_merge( $classes, array_flip( $body_classes ) );

				asort( $classes );

				return $classes;
		}
	} // /receptar_body_classes



	/**
	 * Post classes
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $classes
	 */
	if ( ! function_exists( 'receptar_post_classes' ) ) {
		function receptar_post_classes( $classes ) {
			//Preparing output
				//Sticky post
					/**
					 * On paginated posts list the sticky class is not
					 * being applied, so, we need to compensate.
					 */
					if ( is_sticky() ) {
						$classes[] = 'is-sticky';
					}

				//Featured post
					if (
							class_exists( 'NS_Featured_Posts' )
							&& get_post_meta( get_the_ID(), '_is_ns_featured_post', true )
						) {
						$classes[] = 'is-featured';
					}

			//Output
				return $classes;
		}
	} // /receptar_post_classes



	/**
	 * Singular view featured image
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'receptar_singular_featured_image' ) ) {
		function receptar_singular_featured_image() {
			//Requrements check
				if (
						( ! is_singular() && ! is_attachment() )
						|| is_front_page()
					) {
					return;
				}

			//Helper variables
				$output = array( apply_filters( 'wmhook_entry_featured_image_fallback_url', '' ) );

				if (
						is_singular()
						&& has_post_thumbnail()
					) {

					$output = wp_get_attachment_image_src(
							get_post_thumbnail_id( get_the_ID() ),
							apply_filters( 'wmhook_receptar_enqueue_assets_styles_inline_featured_image_size', 'large' )
						);

				} else if ( is_attachment() ) {

					$output = wp_get_attachment_image_src(
							get_the_ID(),
							apply_filters( 'wmhook_receptar_enqueue_assets_styles_inline_featured_image_size', 'large' )
						);

				}

			//Preparing output

				$output = "\r\n\r\n/* Singular featured image styles */\r\n.entry-media { background-image: url('" . $output[0] . "'); }\r\n";

				$output = apply_filters( 'wmhook_receptar_singular_featured_image_output', $output );

			//Output
				wp_add_inline_style(
						'receptar-stylesheet',
						apply_filters( 'wmhook_esc_css', $output ) . "\r\n"
					);
		}
	} // /receptar_singular_featured_image





/**
 * 50) Site global markup
 */

	/**
	 * Website DOCTYPE
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'receptar_doctype' ) ) {
		function receptar_doctype() {
			echo '<!doctype html>';
		}
	} // /receptar_doctype



	/**
	 * Website HEAD
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'receptar_head' ) ) {
		function receptar_head() {
			//Helper variables
				$output = array();

			//Preparing output
				$output[10] = '<meta charset="' . get_bloginfo( 'charset' ) . '" />';
				$output[20] = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
				$output[30] = '<link rel="profile" href="http://gmpg.org/xfn/11" />';
				$output[40] = '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />';

				//Filter output array
					$output = apply_filters( 'wmhook_receptar_head_output_array', $output );

			//Output
				echo apply_filters( 'wmhook_receptar_head_output', implode( "\r\n", $output ) . "\r\n" );
		}
	} // /receptar_head



	/**
	 * Body top
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'receptar_site_top' ) ) {
		function receptar_site_top() {
			//Helper variables
				$output  = '<div id="page" class="hfeed site">' . "\r\n";
				$output .= "\t" . '<div class="site-inner">' . "\r\n";

			//Output
				echo $output;
		}
	} // /receptar_site_top



		/**
		 * Body bottom
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_site_bottom' ) ) {
			function receptar_site_bottom() {
				//Helper variables
					$output  = "\r\n\t" . '</div><!-- /.site-inner -->';
					$output .= "\r\n" . '</div><!-- /#page -->' . "\r\n\r\n";

				//Output
					echo $output;
			}
		} // /receptar_site_bottom



	/**
	 * Header top
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'receptar_header_top' ) ) {
		function receptar_header_top() {
			//Preparing output
				$output = "\r\n\r\n" . '<header id="masthead" class="site-header" role="banner"' . receptar_schema_org( 'WPHeader' ) . '>' . "\r\n\r\n";

			//Output
				echo $output;
		}
	} // /receptar_header_top



		/**
		 * Header bottom
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_header_bottom' ) ) {
			function receptar_header_bottom() {
				//Helper variables
					$output = "\r\n\r\n" . '</header>' . "\r\n\r\n";

				//Output
					echo $output;
			}
		} // /receptar_header_bottom



		/**
		 * Display header widgets
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_header_widgets' ) ) {
			function receptar_header_widgets() {
				get_sidebar( 'header' );
			}
		} // /receptar_header_widgets



		/**
		 * Display social links
		 *
		 * @since    1.0
		 * @version  1.3
		 */
		if ( ! function_exists( 'receptar_menu_social' ) ) {
			function receptar_menu_social() {
				get_template_part( 'template-parts/menu', 'social' );
			}
		} // /receptar_menu_social



	/**
	 * Navigation item improvements
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $item_output
	 * @param  object $item
	 * @param  int    $depth
	 * @param  array  $args
	 */
	if ( ! function_exists( 'receptar_nav_item_process' ) ) {
		function receptar_nav_item_process( $item_output, $item, $depth, $args ) {
			//Preparing output
				//Display item description
					if (
							'primary' == $args->theme_location
							&& trim( $item->description )
						) {
						$item_output = str_replace( $args->link_after . '</a>', '<span class="menu-item-description">' . trim( $item->description ) . '</span>' . $args->link_after . '</a>', $item_output );
					}

			//Output
				return $item_output;
		}
	} // /receptar_nav_item_process



	/**
	 * Post/page heading (title)
	 *
	 * @since    1.0
	 * @version  1.3
	 *
	 * @param  array $args Heading setup arguments
	 */
	if ( ! function_exists( 'receptar_post_title' ) ) {
		function receptar_post_title( $args = array() ) {
			//Helper variables
				global $post;

				//Requirements check
					if (
							! ( $title = get_the_title() )
							|| apply_filters( 'wmhook_receptar_post_title_disable', false )
						) {
						return;
					}

				$output = $meta = '';

				$args = wp_parse_args( $args, apply_filters( 'wmhook_receptar_post_title_defaults', array(
						'class'           => 'entry-title',
						'class_container' => 'entry-header',
						'link'            => esc_url( get_permalink() ),
						'output'          => '<header class="{class_container}"><{tag} class="{class}"' . receptar_schema_org( 'name' ) . '>{title}</{tag}>{meta}</header>',
						'tag'             => 'h1',
						'title'           => '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $title . '</a>',
					) ) );

			//Preparing output
				//Singular title (no link applied)
					if (
							is_single()
							|| ( is_page() && 'page' === get_post_type() ) //not to display the below stuff on posts list on static front page
						) {

						if ( $suffix = receptar_paginated_suffix( 'small' ) ) {
							$args['title'] .= $suffix;
						} else {
							$args['title'] = $title;
						}

						if ( ( $helper = get_edit_post_link( get_the_ID() ) ) && is_page() ) {
							$args['title'] .= ' <a href="' . esc_url( $helper ) . '" class="entry-edit" title="' . esc_attr( sprintf( esc_html__( 'Edit the "%s"', 'receptar' ), the_title_attribute( array( 'echo' => false ) ) ) ) . '"><span>' . esc_html_x( 'Edit', 'Edit post link.', 'receptar' ) . '</span></a>';
						}

					}

				//Post meta
					if ( is_single() ) {

						$meta = receptar_post_meta( array(
								'class' => 'entry-category',
								'meta'  => array( 'category' ),
							) );

					}

				//Filter processed $args
					$args = apply_filters( 'wmhook_receptar_post_title_args', $args );

				//Generating output HTML
					$replacements = apply_filters( 'wmhook_receptar_post_title_replacements', array(
							'{class}'           => esc_attr( $args['class'] ),
							'{class_container}' => esc_attr( $args['class_container'] ),
							'{meta}'            => $meta,
							'{tag}'             => esc_attr( $args['tag'] ),
							'{title}'           => do_shortcode( $args['title'] ),
						), $args );
					$output = strtr( $args['output'], $replacements );

			//Output
				echo apply_filters( 'wmhook_receptar_post_title_output', $output, $args );
		}
	} // /receptar_post_title



	/**
	 * Content top
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'receptar_content_top' ) ) {
		function receptar_content_top() {
			//Helper variables
				$output  = "\r\n\r\n" . '<div id="content" class="site-content">';
				$output .= "\r\n\t"   . '<div id="primary" class="content-area">';
				$output .= "\r\n\t\t" . '<main id="main" class="site-main clearfix" role="main">' . "\r\n\r\n";

			//Output
				echo $output;
		}
	} // /receptar_content_top



		/**
		 * Content bottom
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_content_bottom' ) ) {
			function receptar_content_bottom() {
				//Helper variables
					$output  = "\r\n\r\n\t\t" . '</main><!-- /#main -->';
					$output .= "\r\n\t"       . '</div><!-- /#primary -->';
					$output .= "\r\n"         . '</div><!-- /#content -->' . "\r\n\r\n";

				//Output
					echo $output;
			}
		} // /receptar_content_bottom



		/**
		 * Breadcrumbs
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_breadcrumbs' ) ) {
			function receptar_breadcrumbs() {
				if (
						function_exists( 'bcn_display' )
						&& ! is_front_page()
						&& ( is_singular() || is_archive() || is_search() )
						&& apply_filters( 'wmhook_receptar_breadcrumbs_enabled', true )
					) {
					echo '<div class="breadcrumbs-container"><nav class="breadcrumbs" itemprop="breadcrumbs">' . bcn_display( true ) . '</nav></div>';
				}
			}
		} // /receptar_breadcrumbs



			/**
			 * Remove breadcrumbs in posts list items
			 *
			 * @since    1.0
			 * @version  1.0
			 */
			if ( ! function_exists( 'receptar_breadcrumbs_off' ) ) {
				function receptar_breadcrumbs_off() {
					add_filter( 'wmhook_receptar_breadcrumbs_enabled', '__return_false' );
				}
			} // /receptar_breadcrumbs_off



		/**
		 * Entry container attributes
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_entry_container_atts' ) ) {
			function receptar_entry_container_atts() {
				return receptar_schema_org( 'entry' );
			}
		} // /receptar_entry_container_atts



		/**
		 * Entry top
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_entry_top' ) ) {
			function receptar_entry_top() {
				//Post content inner wrapper
					if (
							! is_single( get_the_ID() )
							&& ! is_page()
						) {
						echo '<div class="entry-inner-content">';
					}
			}
		} // /receptar_entry_top



			/**
			 * Entry bottom
			 *
			 * @since    1.0
			 * @version  1.0
			 */
			if ( ! function_exists( 'receptar_entry_bottom' ) ) {
				function receptar_entry_bottom() {
					//Post meta
						if ( in_array( get_post_type(), apply_filters( 'wmhook_receptar_entry_bottom_meta_post_types', array( 'post' ) ) ) ) {
							if ( is_single() ) {

								echo receptar_post_meta( apply_filters( 'wmhook_receptar_entry_bottom_meta', array(
										'class' => 'entry-meta entry-meta-bottom',
										'meta'  => array( 'edit', 'date', 'likes', 'author', 'tags' ),
									) ) );

							}
						}

					//Comments
						comments_template( '', true );

					//Post content inner wrapper end
						if (
								! is_single( get_the_ID() )
								&& ! is_page()
							) {
							echo '</div>';
						}
				}
			} // /receptar_entry_bottom



		/**
		 * Comments section wrapper
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_comments_before' ) ) {
			function receptar_comments_before() {
				echo '<div class="comments-area-wrapper">';
			}
		} // /receptar_comments_before



			/**
			 * Comments section wrapper end
			 *
			 * @since    1.0
			 * @version  1.0
			 */
			if ( ! function_exists( 'receptar_comments_after' ) ) {
				function receptar_comments_after() {
					echo '</div>';
				}
			} // /receptar_comments_after



		/**
		 * Post thumbnail (featured image) display size
		 *
		 * @since    1.0
		 * @version  1.3.5
		 *
		 * @param  string $image_size
		 */
		if ( ! function_exists( 'receptar_post_thumbnail_size' ) ) {
			function receptar_post_thumbnail_size( $image_size ) {
				//Preparing output
					if (
							is_single( get_the_ID() )
							|| is_page( get_the_ID() )
						) {

						$image_size = 'receptar-featured';

					} else {

						$image_size = 'thumbnail';

					}

				//Output
					return $image_size;
			}
		} // /receptar_post_thumbnail_size



		/**
		 * Excerpt
		 *
		 * Displays the excerpt properly.
		 * If the post is password protected, display a message.
		 * If the post has more tag, display the content appropriately.
		 *
		 * @since    1.0
		 * @version  1.3
		 *
		 * @param  string $excerpt
		 */
		if ( ! function_exists( 'receptar_excerpt' ) ) {
			function receptar_excerpt( $excerpt ) {
				//Requirements check
					if ( post_password_required() ) {
						if ( ! is_single() ) {
							return esc_html__( 'This content is password protected.', 'receptar' ) . ' <a href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Enter the password to view it.', 'receptar' ) . '</a>';
						}
						return;
					}

				//Preparing output
					if (
							! is_single()
							&& receptar_has_more_tag()
						) {

						/**
						 * Post has more tag
						 */

							//Required for <!--more--> tag to work
								global $more;
								$more = 0;

							if ( has_excerpt() ) {
								$excerpt = '<p class="post-excerpt has-more-tag">' . get_the_excerpt() . '</p>';
							}
							$excerpt = apply_filters( 'the_content', $excerpt . get_the_content( '' ) );

					} else {

						/**
						 * Default excerpt for posts without more tag
						 */

							$excerpt = strtr( $excerpt, apply_filters( 'wmhook_receptar_excerpt_replacements', array( '<p' => '<p class="post-excerpt"' ) ) );

					}

					//Adding "Continue reading" link
						if (
								! is_single()
								&& in_array( get_post_type(), apply_filters( 'wmhook_receptar_excerpt_continue_reading_post_type', array( 'post', 'page' ) ) )
							) {
							$excerpt .= apply_filters( 'wmhook_receptar_excerpt_continue_reading', '' );
						}

				//Output
					return $excerpt;
			}
		} // /receptar_excerpt



			/**
			 * Excerpt length
			 *
			 * @since    1.0
			 * @version  1.0
			 *
			 * @param  absint $length
			 */
			if ( ! function_exists( 'receptar_excerpt_length' ) ) {
				function receptar_excerpt_length( $length ) {
					return 12;
				}
			} // /receptar_excerpt_length



			/**
			 * Excerpt more
			 *
			 * @since    1.0
			 * @version  1.0
			 *
			 * @param  string $more
			 */
			if ( ! function_exists( 'receptar_excerpt_more' ) ) {
				function receptar_excerpt_more( $more ) {
					return '&hellip;';
				}
			} // /receptar_excerpt_more



			/**
			 * Excerpt "Continue reading" text
			 *
			 * @since    1.0
			 * @version  1.3
			 *
			 * @param  string $continue
			 */
			if ( ! function_exists( 'receptar_excerpt_continue_reading' ) ) {
				function receptar_excerpt_continue_reading( $continue ) {
					return '<div class="link-more"><a href="' . esc_url( get_permalink() ) . '">' . sprintf( esc_html__( 'Continue reading%s&hellip;', 'receptar' ), '<span class="screen-reader-text"> "' . get_the_title() . '"</span>' ) . '</a></div>';
				}
			} // /receptar_excerpt_continue_reading



		/**
		 * Previous and next post links
		 *
		 * Since WordPress 4.1 you can use the_post_navigation() and/or get_the_post_navigation().
		 * However, you are modifying markup by applying custom classes, so stick with this
		 * cusotm function for now.
		 *
		 * @todo  Transfer to WordPress 4.1+ core functionality.
		 *
		 * @since    1.0
		 * @version  1.3.4
		 */
		if ( ! function_exists( 'receptar_post_nav' ) ) {
			function receptar_post_nav() {
				//Requirements check
					if ( ! is_singular() || is_page() ) {
						return;
					}

				//Helper variables
					$output = $prev_class = $next_class = '';

					$previous = ( is_attachment() ) ? ( get_post( get_post()->post_parent ) ) : ( get_adjacent_post( false, '', true ) );
					$next     = get_adjacent_post( false, '', false );

				//Requirements check
					if (
							( ! $next && ! $previous )
							|| ( is_attachment() && 'attachment' == $previous->post_type )
						) {
						return;
					}

					$links_count = absint( (bool) $next ) + absint( (bool) $previous );

				//Preparing output
					if ( $previous && has_post_thumbnail( $previous->ID ) ) {
						$prev_class = " has-post-thumbnail";
					}
					if ( $next && has_post_thumbnail( $next->ID ) ) {
						$next_class = " has-post-thumbnail";
					}

					if ( is_attachment() ) {

						$output .= get_previous_post_link(
								'<div class="nav-previous nav-link' . esc_attr( $prev_class ) . '">%link</div>',
								wp_kses(
									__( '<span class="post-title"><span class="meta-nav">Published In: </span>%title</span>', 'receptar' ),
									array( 'span' => array( 'class' => array() ) )
								)
							);

					} else {

						$output .= get_next_post_link(
								'<div class="nav-next nav-link' . esc_attr( $next_class ) . '">%link</div>',
								wp_kses(
									__( '<span class="post-title"><span class="meta-nav">Next: </span>%title</span>', 'receptar' ),
									array( 'span' => array( 'class' => array() ) )
								)
							);
						$output .= get_previous_post_link(
								'<div class="nav-previous nav-link' . esc_attr( $prev_class ) . '">%link</div>',
								wp_kses(
									__( '<span class="post-title"><span class="meta-nav">Previous: </span>%title</span>', 'receptar' ),
									array( 'span' => array( 'class' => array() ) )
								)
							);

					}

					if ( $output ) {
						$output = '<nav class="navigation post-navigation links-count-' . $links_count . '" role="navigation"><h1 class="screen-reader-text">' . esc_html__( 'Post navigation', 'receptar' ) . '</h1><div class="nav-links">' . $output . '</div></nav>';
					}

				//Output
					echo apply_filters( 'wmhook_receptar_post_nav_output', $output );
			}
		} // /receptar_post_nav



		/**
		 * Pagination
		 *
		 * @since    1.0
		 * @version  1.1
		 */
		if ( ! function_exists( 'receptar_pagination' ) ) {
			function receptar_pagination() {
				//Requirements check
					if ( class_exists( 'The_Neverending_Home_Page' ) ) {
						//Don't display pagination if Jetpack Infinite Scroll in use
							return;
					}

				//Helper variables
					global $wp_query, $wp_rewrite;

					$output = '';

					$pagination = array(
							'prev_text' => '&laquo;',
							'next_text' => '&raquo;',
						);

				//Preparing output
					if ( $output = paginate_links( $pagination ) ) {
						$output = '<div class="pagination">' . $output . '</div>';
					}

				//Output
					echo $output;
			}
		} // /receptar_pagination



	/**
	 * Footer
	 *
	 * Theme author credits:
	 * =====================
	 * It is completely optional, but if you like this WordPress theme,
	 * I would appreciate it if you keep the credit link in the footer.
	 *
	 * @since    1.0
	 * @version  1.3
	 */
	if ( ! function_exists( 'receptar_footer' ) ) {
		function receptar_footer() {
			//Credits
				echo '<div class="site-footer-area footer-area-site-info">';
					echo '<div class="site-info-container">';
						echo '<div class="site-info" role="contentinfo">';
							echo apply_filters( 'wmhook_receptar_credits_output',
									'&copy; ' . date( 'Y' ) . ' <a href="' . home_url( '/' ) . '" title="' . get_bloginfo( 'name' ) . '">' . get_bloginfo( 'name' ) . '</a>. '
									. sprintf(
											esc_html__( 'Powered by %s.', 'receptar' ),
											'<a href="https://wordpress.org">WordPress</a>'
										)
									. ' '
									. sprintf(
											esc_html__( 'Theme by %s.', 'receptar' ),
											'<a href="' . esc_url( wp_get_theme()->get( 'AuthorURI' ) ) . '">WebMan Design</a>'
										)
								);
						echo '</div>';
					echo '</div>';
				echo '</div>';
		}
	} // /receptar_footer



		/**
		 * Footer top
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_footer_top' ) ) {
			function receptar_footer_top() {
				//Preparing output
					$output = "\r\n\r\n" . '<footer id="colophon" class="site-footer"' . receptar_schema_org( 'WPFooter' ) . '>' . "\r\n\r\n";

				//Output
					echo $output;
			}
		} // /receptar_footer_top



		/**
		 * Footer bottom
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_footer_bottom' ) ) {
			function receptar_footer_bottom() {
				//Preparing output
					$output = "\r\n\r\n" . '</footer>' . "\r\n\r\n";

				//Output
					echo $output;
			}
		} // /receptar_footer_bottom



		/**
		 * Website footer custom scripts
		 *
		 * Outputs custom scripts set in post/page 'custom-js' custom field.
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_footer_custom_scripts' ) ) {
			function receptar_footer_custom_scripts() {
				//Requirements check
					if (
							! is_singular()
							|| ! ( $output = get_post_meta( get_the_ID(), 'custom_js', true ) )
						) {
						return;
					}

				//Helper variables
					$output = "\r\n\r\n<!--Custom singular JS -->\r\n<script type='text/javascript'>\r\n/* <![CDATA[ */\r\n" . wp_unslash( esc_js( str_replace( array( "\r", "\n", "\t" ), '', $output ) ) ) . "\r\n/* ]]> */\r\n</script>\r\n";

				//Output
					echo apply_filters( 'wmhook_receptar_footer_custom_scripts_output', $output );
			}
		} // /receptar_footer_custom_scripts





/**
 * 100) Other functions
 */

	/**
	 * Register predefined widget areas (sidebars)
	 *
	 * @since    1.0
	 * @version  1.3
	 */
	if ( ! function_exists( 'receptar_register_widget_areas' ) ) {
		function receptar_register_widget_areas() {
			//Secondary
				register_sidebar( array(
						'id'            => 'sidebar',
						'name'          => esc_html__( 'Sidebar', 'receptar' ),
						'description'   => esc_html__( 'Displayed in hidden sidebar on left below the primary navigation.', 'receptar' ),
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h2 class="widget-title">',
						'after_title'   => '</h2>'
					) );

			//Header
				register_sidebar( array(
						'id'            => 'header',
						'name'          => esc_html__( 'Header Widgets', 'receptar' ),
						'description'   => esc_html__( 'Display widgets in the site header.', 'receptar' ),
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h2 class="widget-title">',
						'after_title'   => '</h2>'
					) );
		}
	} // /receptar_register_widget_areas



	/**
	 * Ignore sticky posts in main loop
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  obj $query
	 */
	if ( ! function_exists( 'receptar_posts_query_ignore_sticky_posts' ) ) {
		function receptar_posts_query_ignore_sticky_posts( $query ) {
			if ( $query->is_main_query() ) {
				$query->set( 'ignore_sticky_posts', 1 );
			}
		}
	} // /receptar_posts_query_ignore_sticky_posts



	/**
	 * Include Visual Editor addons
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'receptar_visual_editor' ) ) {
		function receptar_visual_editor() {
			if ( is_admin() || isset( $_GET['fl_builder'] ) ) {
				locate_template( WM_INC_DIR . 'lib/visual-editor.php', true );
			}
		}
	} // /receptar_visual_editor



		/**
		 * Adding additional formats to TinyMCE editor
		 *
		 * @since    1.0
		 * @version  1.3
		 *
		 * @param  array $formats
		 */
		if ( ! function_exists( 'receptar_visual_editor_custom_mce_format' ) ) {
			function receptar_visual_editor_custom_mce_format( $formats ) {
				//Preparing output
					$formats[] = array(
							'title' => esc_html__( 'Dropcaps', 'receptar' ),
							'items' => array(

								array(
									'title'    => esc_html__( 'Dropcap text', 'receptar' ),
									'selector' => 'p',
									'classes'  => 'dropcap-text',
								),

							),
						);

				//Return
					return $formats;
			}
		} // /receptar_visual_editor_custom_mce_format



	/**
	 * Default featured image URL
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'receptar_entry_featured_image_fallback_url' ) ) {
		function receptar_entry_featured_image_fallback_url() {
			//Helper variables
				$output = trailingslashit( get_stylesheet_directory_uri() ) . 'images/featured.jpg';

				$header_image_data = (array) get_custom_header();

			//Preparing output
				if (
						! empty( $header_image_data )
						&& isset( $header_image_data['attachment_id'] )
						&& $header_image_data['attachment_id']
					) {

					$image_size = ( is_singular() ) ? ( 'full' ) : ( 'thumbnail' ); //Using 'full' because this is a banner-cropped image already.

					$output = wp_get_attachment_image_src(
							absint( $header_image_data['attachment_id'] ),
							apply_filters( 'wmhook_receptar_enqueue_assets_styles_inline_featured_image_size', $image_size )
						);
					$output = $output[0];

				}

			//Output
				return esc_url( $output );
		}
	} // /receptar_entry_featured_image_fallback_url



	/**
	 * Add form field placeholders to comments form
	 *
	 * @since    1.0
	 * @version  1.3
	 *
	 * @param  mixed $fields
	 */
	if ( ! function_exists( 'receptar_comments_form_placeholders' ) ) {
		function receptar_comments_form_placeholders( $fields ) {
			//Preparing output
				if ( is_string( $fields ) ) {

					//Comment
						$fields = str_replace(
								'<textarea',
								'<textarea placeholder="' . esc_html_x( 'Comment', 'Comment form field placeholder text.', 'receptar' ) . '"',
								$fields
							);
						$fields = str_replace(
								'rows="8"',
								'rows="4"',
								$fields
							);

				} else {

					//Name
						if ( isset( $fields['author'] ) ) {
							$fields['author'] = str_replace(
									'<input',
									'<input placeholder="' . esc_html_x( 'Name', 'Comment form field placeholder text.', 'receptar' ) . '"',
									$fields['author']
								);
						}

					//Email
						if ( isset( $fields['author'] ) ) {
							$fields['email'] = str_replace(
									'<input',
									'<input placeholder="' . esc_html_x( 'Email', 'Comment form field placeholder text.', 'receptar' ) . '"',
									$fields['email']
								);
						}

					//Website
						if ( isset( $fields['author'] ) ) {
							$fields['url'] = str_replace(
									'<input',
									'<input placeholder="' . esc_html_x( 'Website', 'Comment form field placeholder text.', 'receptar' ) . '"',
									$fields['url']
								);
						}

				}

			//Output
				return $fields;
		}
	} // /receptar_comments_form_placeholders

?>