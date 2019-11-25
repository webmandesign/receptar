<?php
/**
 * Theme setup
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.8.3
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

		add_action( 'load-themes.php', 'receptar_admin_notice_welcome_activation' );

		//Styles and scripts
			add_action( 'init',                'receptar_register_assets',           10 );
			add_action( 'wp_enqueue_scripts',  'receptar_enqueue_assets',           100 );
			add_action( 'wp_enqueue_scripts',  'receptar_singular_featured_image',  110 );
			add_action( 'comment_form_before', 'receptar_comment_reply_js_enqueue'      );
		//Customizer assets
			add_action( 'customize_controls_enqueue_scripts', 'receptar_customizer_enqueue_assets'             );
			add_action( 'customize_preview_init',             'receptar_customizer_preview_enqueue_assets', 10 );
		//Theme setup
			add_action( 'after_setup_theme', 'receptar_setup', 10 );
		//Register widget areas
			add_action( 'widgets_init', 'receptar_register_widget_areas', 1 );
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
				add_action( 'wmhook_header',                    'receptar_logo',             10, 0 );
				add_action( 'wmhook_header',                    'get_sidebar',               20 );
				add_action( 'wmhook_header',                    'receptar_header_widgets',   30 );
				add_action( 'wmhook_header_bottom',             'receptar_header_bottom',    10 );
				add_action( 'wmhook_secondary_content_top',     'receptar_logo',             10, 0 );
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

		add_filter( 'wmhook_esc_css', 'wp_strip_all_tags' );

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
			add_filter( 'the_excerpt', 'receptar_remove_shortcodes', 10 );
			add_filter( 'the_excerpt', 'receptar_excerpt', 20 );
			add_filter( 'get_the_excerpt', 'receptar_wrap_excerpt', 20 );
			add_filter( 'get_the_excerpt', 'receptar_excerpt_continue_reading', 30, 2 );
			add_filter( 'excerpt_length', 'receptar_excerpt_length', 10 );
			add_filter( 'excerpt_more', 'receptar_excerpt_more', 10 );
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
	 * @since    1.0.0
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_setup' ) ) {
		function receptar_setup() {

			// Variables

				$image_sizes = array_filter( apply_filters( 'wmhook_receptar_setup_image_sizes', array() ) );

				$version = esc_attr( trim( wp_get_theme()->get( 'Version' ) ) );
				$visual_editor_css = array_filter( (array) apply_filters( 'wmhook_receptar_setup_visual_editor_css', array(
					str_replace( ',', '%2C', receptar_google_fonts_url() ),
					esc_url_raw( add_query_arg(
						array( 'ver' => $version ),
						get_theme_file_uri( 'assets/fonts/genericons-neue/genericons-neue.css' )
					) ),
					esc_url_raw( add_query_arg(
						array( 'ver' => $version ),
						get_theme_file_uri( 'assets/css/starter.css' )
					) ),
					esc_url_raw( add_query_arg(
						array( 'ver' => $version ),
						get_theme_file_uri( 'assets/css/colors.css' )
					) ),
					esc_url_raw( add_query_arg(
						array( 'ver' => $version ),
						get_theme_file_uri( 'assets/css/editor-style.css' )
					) ),
				) ) );


			// Processing

				current_theme_supports( 'child-theme-stylesheet' );

				// Localization

					// Note: the first-loaded translation file overrides any following ones if the same translation is present.
					// wp-content/languages/theme-name/it_IT.mo
					load_theme_textdomain( 'receptar', trailingslashit( WP_LANG_DIR ) . 'themes/' . WM_THEME_SHORTNAME );
					// wp-content/themes/child-theme-name/languages/it_IT.mo
					load_theme_textdomain( 'receptar', get_stylesheet_directory() . '/languages' );
					// wp-content/themes/theme-name/languages/it_IT.mo
					load_theme_textdomain( 'receptar', get_template_directory() . '/languages' );

				// Title tag
				add_theme_support( 'title-tag' );

				// Site logo
				add_theme_support( 'custom-logo' );

				// Visual editor styles
				add_editor_style( $visual_editor_css );

				// Feed links
				add_theme_support( 'automatic-feed-links' );

				// Enable HTML5 markup
				add_theme_support( 'html5', array(
					'comment-list',
					'comment-form',
					'search-form',
					'gallery',
					'caption',
				) );

				// Custom menus
				register_nav_menus( apply_filters( 'wmhook_receptar_setup_menus', array(
					'primary' => esc_html__( 'Primary Menu', 'receptar' ),
					'social'  => esc_html__( 'Social Links Menu', 'receptar' ),
				) ) );

				// Custom header
				add_theme_support( 'custom-header', apply_filters( 'wmhook_receptar_setup_custom_header_args', array(
					'default-image' => get_theme_file_uri( 'assets/images/header.jpg' ),
					'header-text'   => false,
					'width'         => 1920,
					'height'        => 640, //Approx. 62% of desktop viewport height (16:9)
					'flex-height'   => false,
					'flex-width'    => true,
				) ) );

				// Custom background
				add_theme_support( 'custom-background', apply_filters( 'wmhook_receptar_setup_custom_background_args', array(
					'default-color' => 'f5f7f9',
				) ) );

				// Post types supports
				add_post_type_support( 'attachment', 'custom-fields' );

				// Thumbnails support

					add_post_type_support( 'attachment:audio', 'thumbnail' );
					add_post_type_support( 'attachment:video', 'thumbnail' );

					add_theme_support( 'post-thumbnails', array( 'attachment:audio', 'attachment:video' ) );
					add_theme_support( 'post-thumbnails' );

					// Image sizes (x, y, crop)
					if ( ! empty( $image_sizes ) ) {
						foreach ( $image_sizes as $size => $setup ) {
							if ( ! in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
								add_image_size(
									$size,
									$image_sizes[ $size ][0],
									$image_sizes[ $size ][1],
									$image_sizes[ $size ][2]
								);
							}
						}
					}

		}
	} // /receptar_setup



	/**
	 * Initiate "Welcome" admin notice
	 *
	 * @since    1.8.0
	 * @version  1.8.0
	 */
	if ( ! function_exists( 'receptar_admin_notice_welcome_activation' ) ) {
		function receptar_admin_notice_welcome_activation() {

			// Processing

				global $pagenow;

				if (
					is_admin()
					&& 'themes.php' == $pagenow
					&& isset( $_GET['activated'] )
				) {

					add_action( 'admin_notices', 'receptar_admin_notice_welcome', 99 );

				}

		}
	} // /receptar_admin_notice_welcome_activation



		/**
		 * Display "Welcome" admin notice
		 *
		 * @since    1.8.0
		 * @version  1.8.0
		 */
		if ( ! function_exists( 'receptar_admin_notice_welcome' ) ) {
			function receptar_admin_notice_welcome() {

				// Processing

					get_template_part( 'template-parts/component-notice', 'welcome' );

			}
		} // /receptar_admin_notice_welcome



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
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_register_assets' ) ) {
		function receptar_register_assets() {

			// Variables

				$version = esc_attr( trim( wp_get_theme()->get( 'Version' ) ) );

			/**
			 * Styles
			 */

				$register_styles = apply_filters( 'wmhook_receptar_register_assets_register_styles', array(

					'receptar' => array( 'src' => '' ), // For wp_add_inline_style().

					'genericons-neue' => array( 'src' => get_theme_file_uri( 'assets/fonts/genericons-neue/genericons-neue.css' ) ),

					'receptar-google-fonts' => array( 'src' => receptar_google_fonts_url() ),
					'receptar-slick'        => array( 'src' => get_theme_file_uri( 'assets/css/slick.css' ) ),

					'receptar-starter' => array( 'src' => get_theme_file_uri( 'assets/css/starter.css' ) ),
					'receptar-main'    => array( 'src' => get_theme_file_uri( 'assets/css/main.css' ), 'deps' => array( 'receptar-starter' ) ),
					'receptar-colors'  => array( 'src' => get_theme_file_uri( 'assets/css/colors.css' ) ),

					'receptar-stylesheet' => array( 'src' => get_stylesheet_uri() ),

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

					'slick' => array( get_theme_file_uri( 'assets/js/slick.min.js' ) ),

					'receptar-scripts-global'      => array( get_theme_file_uri( 'assets/js/scripts-global.js' ) ),
					'receptar-skip-link-focus-fix' => array( get_theme_file_uri( 'assets/js/skip-link-focus-fix.js' ) ),

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
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_enqueue_assets' ) ) {
		function receptar_enqueue_assets() {

			// Variables

				$enqueue_styles = $enqueue_scripts = array();

			/**
			 * Styles
			 */

				// Google Fonts
				if ( receptar_google_fonts_url() ) {
					$enqueue_styles[] = 'receptar-google-fonts';
				}

				// Banner slider
				if (
					( is_front_page() || is_home() )
					&& receptar_has_banner_posts( 2 )
				) {
					$enqueue_styles[] = 'receptar-slick';
				}

				// Genericons Neue
				$enqueue_styles[] = 'genericons-neue';

				// Main
				$enqueue_styles[] = 'receptar-main';

				// Colors
				$enqueue_styles[] = 'receptar-colors';

				// Inline styles handle
				$enqueue_styles[] = 'receptar';

				// Colors
				$enqueue_styles[] = 'receptar-stylesheet';

				$enqueue_styles = apply_filters( 'wmhook_receptar_enqueue_assets_enqueue_styles', $enqueue_styles );

				foreach ( $enqueue_styles as $handle ) {
					wp_enqueue_style( $handle );
				}

			/**
			 * Scripts
			 */

				// Banner slider
				if (
					( is_front_page() || is_home() )
					&& receptar_has_banner_posts( 2 )
				) {
					$enqueue_scripts[] = 'slick';
				}

				// Global theme scripts
				$enqueue_scripts[] = 'receptar-scripts-global';

				// Skip link focus fix
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
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_customizer_enqueue_assets' ) ) {
		function receptar_customizer_enqueue_assets() {

			// Processing

				wp_enqueue_style(
					'receptar-customizer',
					get_theme_file_uri( 'assets/css/customizer.css' ),
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
		 * @version  1.7.0
		 */
		if ( ! function_exists( 'receptar_customizer_preview_enqueue_assets' ) ) {
			function receptar_customizer_preview_enqueue_assets() {

				// Processing

					wp_enqueue_script(
						'receptar-customizer-preview',
						get_theme_file_uri( 'assets/js/customizer-preview.js' ),
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
	 * @version  1.8.2
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
	 * @since    1.0.0
	 * @version  1.4.0
	 *
	 * @param  array $classes
	 */
	if ( ! function_exists( 'receptar_post_classes' ) ) {
		function receptar_post_classes( $classes ) {

			// Processing

				// A generic class for easy styling

					$classes[] = 'entry';

				// Sticky post

					/**
					 * On paginated posts list the sticky class is not
					 * being applied, so, we need to compensate.
					 */
					if ( is_sticky() ) {
						$classes[] = 'is-sticky';
					}

				// Featured post

					if (
						class_exists( 'NS_Featured_Posts' )
						&& get_post_meta( get_the_ID(), '_is_ns_featured_post', true )
					) {
						$classes[] = 'is-featured';
					}


			// Output

				return $classes;

		}
	} // /receptar_post_classes



	/**
	 * Singular view featured image
	 *
	 * @since    1.0
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_singular_featured_image' ) ) {
		function receptar_singular_featured_image() {

			// Requrements check

				if (
					( ! is_singular() && ! is_attachment() )
					|| is_front_page()
				) {
					return;
				}


			// Variables

				$output = array( apply_filters( 'wmhook_entry_featured_image_fallback_url', '' ) );


			// Processing

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

				$output = "\r\n\r\n/* Singular featured image styles */\r\n.entry-media { background-image: url('" . $output[0] . "'); }\r\n";
				$output = apply_filters( 'wmhook_receptar_singular_featured_image_output', $output );

				wp_add_inline_style(
					'receptar',
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
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_site_top' ) ) {
		function receptar_site_top() {

			// Output

				echo '<div id="page" class="hfeed site">' . "\r\n";
				echo "\t" . '<div class="site-inner">' . "\r\n";

		}
	} // /receptar_site_top



		/**
		 * Body bottom
		 *
		 * @since    1.0
		 * @version  1.7.0
		 */
		if ( ! function_exists( 'receptar_site_bottom' ) ) {
			function receptar_site_bottom() {

				// Output

					echo "\r\n\t" . '</div><!-- /.site-inner -->';
					echo "\r\n" . '</div><!-- /#page -->' . "\r\n\r\n";

			}
		} // /receptar_site_bottom



	/**
	 * Header top
	 *
	 * @since    1.0.0
	 * @version  1.4.0
	 */
	if ( ! function_exists( 'receptar_header_top' ) ) {
		function receptar_header_top() {

			// Output

				echo "\r\n\r\n" . '<header id="masthead" class="site-header">' . "\r\n\r\n";

		}
	} // /receptar_header_top



		/**
		 * Header bottom
		 *
		 * @since    1.0
		 * @version  1.7.0
		 */
		if ( ! function_exists( 'receptar_header_bottom' ) ) {
			function receptar_header_bottom() {

				// Output

					echo "\r\n\r\n" . '</header>' . "\r\n\r\n";

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
		 * Social menu args.
		 *
		 * @since    1.6.1
		 * @version  1.6.1
		 *
		 * @param  string $items_wrap
		 */
		function receptar_social_menu_args( $items_wrap = '<ul data-id="%1$s" class="%2$s">%3$s</ul>' ) {

			// Output

				return (array) apply_filters( 'wmhook_receptar_social_menu_args', array(
					'theme_location'  => 'social',
					'container'       => 'div',
					'container_id'    => '',
					'container_class' => 'social-links',
					'menu_class'      => 'social-links-items',
					'depth'           => 1,
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span><!--{{icon}}-->',
					'fallback_cb'     => false,
					'items_wrap'      => (string) $items_wrap,
				) );

		} // /receptar_social_menu_args



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
			 * Social links supported icons
			 *
			 * @since    1.6.0
			 * @version  1.8.2
			 */
			function receptar_social_links_icons() {

				// Output

					return array(
						'behance.net'       => 'behance',
						'bitbucket.org'     => 'bitbucket',
						'codepen.io'        => 'codepen',
						'deviantart.com'    => 'deviantart',
						'digg.com'          => 'digg',
						'docker.com'        => 'dockerhub',
						'dribbble.com'      => 'dribbble',
						'dropbox.com'       => 'dropbox',
						'facebook.com'      => 'facebook',
						'flickr.com'        => 'flickr',
						'foursquare.com'    => 'foursquare',
						'plus.google.'      => 'google-plus',
						'google.'           => 'google',
						'github.com'        => 'github',
						'instagram.com'     => 'instagram',
						'linkedin.com'      => 'linkedin',
						'mailto:'           => 'envelope',
						'medium.com'        => 'medium',
						'paypal.com'        => 'paypal',
						'pscp.tv'           => 'periscope',
						'tel:'              => 'phone',
						'pinterest.com'     => 'pinterest',
						'getpocket.com'     => 'get-pocket',
						'reddit.com'        => 'reddit',
						'/feed'             => 'rss',
						'skype.com'         => 'skype',
						'skype:'            => 'skype',
						'slack.com'         => 'slack',
						'slideshare.net'    => 'slideshare',
						'snapchat.com'      => 'snapchat',
						'soundcloud.com'    => 'soundcloud',
						'spotify.com'       => 'spotify',
						'stackoverflow.com' => 'stack-overflow',
						'stumbleupon.com'   => 'stumbleupon',
						'trello.com'        => 'trello',
						'tripadvisor.'      => 'tripadvisor',
						'tumblr.com'        => 'tumblr',
						'twitch.tv'         => 'twitch',
						'twitter.com'       => 'twitter',
						'vimeo.com'         => 'vimeo',
						'vine.co'           => 'vine',
						'vk.com'            => 'vk',
						'wa.me'             => 'whatsapp',
						'wordpress.org'     => 'wordpress',
						'wordpress.com'     => 'wordpress',
						'xing.com'          => 'xing',
						'yelp.com'          => 'yelp',
						'youtube.com'       => 'youtube',
					);

			} // /receptar_social_links_icons

			add_filter( 'wmhook_receptar_svg_get_social_icons', 'receptar_social_links_icons' );



			/**
			 * Display SVG icons in social links menu
			 *
			 * @since    1.6.0
			 * @version  1.6.1
			 *
			 * @param  string  $item_output The menu item output.
			 * @param  WP_Post $item        Menu item object.
			 * @param  int     $depth       Depth of the menu.
			 * @param  array   $args        wp_nav_menu() arguments.
			 */
			function receptar_nav_menu_social_icons( $item_output, $item, $depth, $args ) {

				// Requirements check

					if ( false === strpos( $item_output, '<!--{{icon}}-->' ) ) {
						return $item_output;
					}


				// Variables

					$social_icons = Receptar_SVG::get_social_icons();
					$social_icon  = 'chain';


				// Processing

					foreach ( $social_icons as $url => $icon ) {
						if ( false !== strpos( $item_output, $url ) ) {
							$social_icon = $icon;
							break;
						}
					}

					$item_output = str_replace(
						'<!--{{icon}}-->',
						'<!--{{icon}}-->' . Receptar_SVG::get( array(
							'icon' => esc_attr( $social_icon ),
							'base' => 'social-icon',
						) ),
						$item_output
					);


				// Output

					return $item_output;

			} // /receptar_nav_menu_social_icons

			add_filter( 'walker_nav_menu_start_el', 'receptar_nav_menu_social_icons', 10, 4 );



			/**
			 * Display social links in Navigation Menu widget
			 *
			 * @subpackage  Widgets
			 *
			 * @since    1.6.0
			 * @version  1.6.1
			 *
			 * @param  array  $nav_menu_args Array of parameters for `wp_nav_menu()` function.
			 * @param  string $nav_menu      Menu slug assigned in the widget.
			 * @param  array  $args          Widget parameters.
			 */
			function receptar_social_widget( $nav_menu_args, $nav_menu, $args ) {

				// Variables

					$locations = get_nav_menu_locations();

					$locations['social'] = ( isset( $locations['social'] ) ) ? ( $locations['social'] ) : ( false );


				// Requirements check

					if (
						! isset( $nav_menu->term_id )
						|| (
							false === stripos( $nav_menu->name, '[soc]' )
							&& $locations['social'] !== $nav_menu->term_id
						)
					) {
						return $nav_menu_args;
					}


				// Processing

					$menu_args = receptar_social_menu_args();

					$nav_menu_args['container_class'] = 'social-links';
					$nav_menu_args['menu_class']      = 'social-links-items';
					$nav_menu_args['depth']           = $menu_args['depth'];
					$nav_menu_args['link_before']     = $menu_args['link_before'];
					$nav_menu_args['link_after']      = $menu_args['link_after'];
					$nav_menu_args['items_wrap']      = $menu_args['items_wrap'];


				// Output

					return $nav_menu_args;

			} // /receptar_social_widget

			add_filter( 'widget_nav_menu_args', 'receptar_social_widget', 10, 3 );



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
	 * @since    1.0.0
	 * @version  1.4.0
	 *
	 * @param  array $args Heading setup arguments
	 */
	if ( ! function_exists( 'receptar_post_title' ) ) {
		function receptar_post_title( $args = array() ) {

			// Helper variables

				global $post;

				// Requirements check

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
					'output'          => '<header class="{class_container}"><{tag} class="{class}">{title}</{tag}>{meta}</header>',
					'tag'             => 'h1',
					'title'           => '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $title . '</a>',
				) ) );


			// Processing

				// Singular title (no link applied)

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

				// Post meta

					if ( is_single() ) {

						$meta = receptar_post_meta( array(
								'class' => 'entry-category',
								'meta'  => array( 'category' ),
							) );

					}

				// Filter processed $args

					$args = apply_filters( 'wmhook_receptar_post_title_args', $args );

				// Generating output HTML

					$replacements = apply_filters( 'wmhook_receptar_post_title_replacements', array(
						'{class}'           => esc_attr( $args['class'] ),
						'{class_container}' => esc_attr( $args['class_container'] ),
						'{meta}'            => $meta,
						'{tag}'             => esc_attr( $args['tag'] ),
						'{title}'           => do_shortcode( $args['title'] ),
					), $args );
					$output = strtr( $args['output'], $replacements );


			// Output

				echo apply_filters( 'wmhook_receptar_post_title_output', $output, $args );

		}
	} // /receptar_post_title



	/**
	 * Content top
	 *
	 * @since    1.0
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_content_top' ) ) {
		function receptar_content_top() {

			// Output

				echo "\r\n\r\n" . '<div id="content" class="site-content">';
				echo "\r\n\t"   . '<div id="primary" class="content-area">';
				echo "\r\n\t\t" . '<main id="main" class="site-main clearfix">' . "\r\n\r\n";

		}
	} // /receptar_content_top



		/**
		 * Content bottom
		 *
		 * @since    1.0
		 * @version  1.7.0
		 */
		if ( ! function_exists( 'receptar_content_bottom' ) ) {
			function receptar_content_bottom() {

				// Output

					echo "\r\n\r\n\t\t" . '</main><!-- /#main -->';
					echo "\r\n\t"       . '</div><!-- /#primary -->';
					echo "\r\n"         . '</div><!-- /#content -->' . "\r\n\r\n";

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
		 * @version  1.8.0
		 *
		 * @param  string $excerpt
		 */
		if ( ! function_exists( 'receptar_excerpt' ) ) {
			function receptar_excerpt( $excerpt = '' ) {

				// Variables

					$post_id = get_the_ID();


				// Requirements check

					if ( post_password_required( $post_id ) ) {
						if ( ! is_single( $post_id ) ) {
							return esc_html__( 'This content is password protected.', 'receptar' )
							       . ' <a href="' . esc_url( get_permalink() ) . '">'
							       . esc_html__( 'Enter the password to view it.', 'receptar' )
							       . '</a>';
						}
						return;
					}


				// Processing

					if (
						! is_single( $post_id )
						&& receptar_has_more_tag()
					) {

						if ( has_excerpt( $post_id ) ) {
							$excerpt = str_replace(
								'entry-summary',
								'entry-summary has-more-tag',
								$excerpt
							);
						} else {
							$excerpt = '';
						}

						$excerpt = apply_filters( 'the_content', $excerpt . get_the_content( '' ) . receptar_get_continue_reading_html() );

					}


				// Output

					return $excerpt;

			}
		} // /receptar_excerpt



			/**
			 * Wrap excerpt within a `div.entry-summary`.
			 *
			 * Line breaks are required for proper functionality of `wpautop()` later on.
			 *
			 * @since    1.8.0
			 * @version  1.8.3
			 *
			 * @param  string $post_excerpt
			 */
			if ( ! function_exists( 'receptar_wrap_excerpt' ) ) {
				function receptar_wrap_excerpt( $post_excerpt = '' ) {

					// Requirements check

						if ( empty( $post_excerpt ) ) {
							return $post_excerpt;
						}


					// Output

						return '<div class="entry-summary">' . PHP_EOL . $post_excerpt . PHP_EOL . '</div>';

				}
			} // /receptar_wrap_excerpt



			/**
			 * Adding "Continue reading" link to excerpt
			 *
			 * @since    1.0.0
			 * @version  1.8.0
			 *
			 * @param  string  $post_excerpt  The post excerpt.
			 * @param  WP_Post $post          Post object.
			 */
			if ( ! function_exists( 'receptar_excerpt_continue_reading' ) ) {
				function receptar_excerpt_continue_reading( $post_excerpt = '', $post = null ) {

					// Variables

						$post_id = get_the_ID();


					// Processing

						if (
							! post_password_required( $post_id )
							&& ! is_single( $post_id )
							&& ! receptar_has_more_tag()
							&& in_array(
								get_post_type( $post_id ),
								(array) apply_filters( 'wmhook_receptar_excerpt_continue_reading_post_type', array( 'post', 'page' ) )
							)
						) {
							$post_excerpt .= receptar_get_continue_reading_html( $post );
						}


					// Output

						return $post_excerpt;

				}
			} // /receptar_excerpt_continue_reading



			/**
			 * Get "Continue reading" HTML.
			 *
			 * @since    1.8.0
			 * @version  1.8.0
			 *
			 * @param  WP_Post $post   Post object.
			 * @param  string  $scope  Optional identification of specific "Continue reading" text for better filtering.
			 */
			if ( ! function_exists( 'receptar_get_continue_reading_html' ) ) {
				function receptar_get_continue_reading_html( $post = null, $scope = '' ) {

					// Pre

						$pre = apply_filters( 'wmhook_receptar_get_continue_reading_html_pre', false, $post, $scope );

						if ( false !== $pre ) {
							return $pre;
						}


					// Variables

						$html     = '';
						$scope    = (string) $scope;
						$template = 'template-parts/component-link-more';


					// Processing

						ob_start();

						if ( $scope && locate_template( $template . '-' . $scope . '.php' ) ) {
							get_template_part( $template, $scope );
						} else {
							get_template_part( $template, get_post_type() );
						}

						/**
						 * Stripping all new line and tab characters to prevent `wpautop()` messing things up later.
						 *
						 * "\t" - a tab.
						 * "\n" - a new line (line feed).
						 * "\r" - a carriage return.
						 * "\x0B" - a vertical tab.
						 */
						$html = str_replace(
							array( "\t", "\n", "\r", "\x0B" ),
							'',
							ob_get_clean()
						);


					// Output

						return (string) apply_filters( 'wmhook_receptar_get_continue_reading_html', $html, $post, $scope );

				}
			} // /receptar_get_continue_reading_html



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
		 * Previous and next post links
		 *
		 * Since WordPress 4.1 you can use the_post_navigation() and/or get_the_post_navigation().
		 * However, you are modifying markup by applying custom classes, so stick with this
		 * cusotm function for now.
		 *
		 * @todo  Transfer to WordPress 4.1+ core functionality.
		 *
		 * @since    1.0
		 * @version  1.7.0
		 */
		if ( ! function_exists( 'receptar_post_nav' ) ) {
			function receptar_post_nav() {

				// Requirements check

					if (
						! is_singular()
						|| is_page()
					) {
						return;
					}


				// Variables

					$output = $prev_class = $next_class = '';

					$previous = ( is_attachment() ) ? ( get_post( get_post()->post_parent ) ) : ( get_adjacent_post( false, '', true ) );
					$next     = get_adjacent_post( false, '', false );


				// Requirements check

					if (
						( ! $next && ! $previous )
						|| ( is_attachment() && 'attachment' == $previous->post_type )
					) {
						return;
					}

					$links_count = absint( (bool) $next ) + absint( (bool) $previous );


				// Processing

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
						$output = '<nav class="navigation post-navigation links-count-' . $links_count . '"><h1 class="screen-reader-text">' . esc_html__( 'Post navigation', 'receptar' ) . '</h1><div class="nav-links">' . $output . '</div></nav>';
					}


				// Output

					echo apply_filters( 'wmhook_receptar_post_nav_output', $output );

			}
		} // /receptar_post_nav



		/**
		 * Pagination
		 *
		 * @since    1.0
		 * @version  1.7.0
		 */
		if ( ! function_exists( 'receptar_pagination' ) ) {
			function receptar_pagination() {

				// Requirements check

					if ( class_exists( 'The_Neverending_Home_Page' ) ) {
						// Don't display pagination if Jetpack Infinite Scroll in use
						return;
					}


				// Variables

					$output = '';

					$pagination = array(
						'prev_text' => '&laquo;',
						'next_text' => '&raquo;',
					);


				// Processing

					if ( $output = paginate_links( $pagination ) ) {
						$output = '<div class="pagination">' . $output . '</div>';
					}


				// Output

					echo $output; // WPCS: XSS OK.

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
	 * @since    1.0.0
	 * @version  1.4.0
	 */
	if ( ! function_exists( 'receptar_footer' ) ) {
		function receptar_footer() {

			// Output

				get_template_part( 'template-parts/footer/site', 'info' );

		}
	} // /receptar_footer



		/**
		 * Footer top
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 */
		if ( ! function_exists( 'receptar_footer_top' ) ) {
			function receptar_footer_top() {

				// Output

					echo "\r\n\r\n" . '<footer id="colophon" class="site-footer">' . "\r\n\r\n";

			}
		} // /receptar_footer_top



		/**
		 * Footer bottom
		 *
		 * @since    1.0
		 * @version  1.7.0
		 */
		if ( ! function_exists( 'receptar_footer_bottom' ) ) {
			function receptar_footer_bottom() {

				// Output

					echo "\r\n\r\n" . '</footer>' . "\r\n\r\n";

			}
		} // /receptar_footer_bottom





/**
 * 100) Other functions
 */

	/**
	 * Register predefined widget areas (sidebars)
	 *
	 * @since    1.0
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_register_widget_areas' ) ) {
		function receptar_register_widget_areas() {

			// Processing

				register_sidebar( array(
					'id'            => 'sidebar',
					'name'          => esc_html__( 'Sidebar', 'receptar' ),
					'description'   => esc_html__( 'Displayed in hidden sidebar on left below the primary navigation.', 'receptar' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>'
				) );

				register_sidebar( array(
					'id'            => 'header',
					'name'          => esc_html__( 'Header Widgets', 'receptar' ),
					'description'   => esc_html__( 'Display widgets in the site header.', 'receptar' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>'
				) );

		}
	} // /receptar_register_widget_areas



	/**
	 * Include Visual Editor addons
	 *
	 * @since    1.0
	 * @version  1.7.0
	 */
	if ( ! function_exists( 'receptar_visual_editor' ) ) {
		function receptar_visual_editor() {

			// Processing

				if (
					is_admin()
					|| isset( $_GET['fl_builder'] )
				) {
					require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'lib/visual-editor.php' );
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
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'receptar_entry_featured_image_fallback_url' ) ) {
		function receptar_entry_featured_image_fallback_url() {
			//Helper variables
				$output = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/images/featured.jpg';

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
	 * @version  1.5.0
	 *
	 * @param  mixed $fields
	 */
	if ( ! function_exists( 'receptar_comments_form_placeholders' ) ) {
		function receptar_comments_form_placeholders( $fields ) {

			//Processing

				if ( is_string( $fields ) ) {

					// Comment

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

					// Name

						if ( isset( $fields['author'] ) ) {
							$fields['author'] = str_replace(
								'<input',
								'<input placeholder="' . esc_html_x( 'Name', 'Comment form field placeholder text.', 'receptar' ) . '"',
								$fields['author']
							);
						}

					// Email

						if ( isset( $fields['email'] ) ) {
							$fields['email'] = str_replace(
								'<input',
								'<input placeholder="' . esc_html_x( 'Email', 'Comment form field placeholder text.', 'receptar' ) . '"',
								$fields['email']
							);
						}

					// Website

						if ( isset( $fields['url'] ) ) {
							$fields['url'] = str_replace(
								'<input',
								'<input placeholder="' . esc_html_x( 'Website', 'Comment form field placeholder text.', 'receptar' ) . '"',
								$fields['url']
							);
						}

				}


			// Output

				return $fields;

		}
	} // /receptar_comments_form_placeholders
