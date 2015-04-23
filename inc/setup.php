<?php
/**
 * Theme setup
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.1
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
			add_action( 'init',               'wm_register_assets',           10 );
			add_action( 'wp_enqueue_scripts', 'wm_enqueue_assets',           100 );
			add_action( 'wp_enqueue_scripts', 'wm_singular_featured_image',  110 );
			add_action( 'wp_footer',          'wm_footer_custom_scripts',   9998 );
		//Customizer assets
			add_action( 'customize_controls_enqueue_scripts', 'wm_customizer_enqueue_assets'             );
			add_action( 'customize_preview_init',             'wm_customizer_preview_enqueue_assets', 10 );
		//Theme setup
			add_action( 'after_setup_theme', 'wm_setup', 10 );
		//Register widget areas
			add_action( 'widgets_init', 'wm_register_widget_areas', 1 );
		//Sticky posts
			add_action( 'pre_get_posts', 'wm_posts_query_ignore_sticky_posts' );
		//Pagination fallback
			add_action( 'wmhook_postslist_after', 'wm_pagination', 10 );
		//Visual Editor addons
			add_action( 'init',                                      'wm_visual_editor',                  999 );
			add_filter( 'wmhook_wm_custom_mce_format_style_formats', 'wm_visual_editor_custom_mce_format'     );
		//Display Settings > Media recommended images sizes notice
			add_action( 'admin_init', 'wm_image_size_notice' );
		//Website sections
			//DOCTYPE
				add_action( 'wmhook_html_before',               'wm_doctype',          10 );
			//HEAD
				add_action( 'wp_head',                          'wm_head',              1 );
			//Body
				add_action( 'wmhook_body_top',                  'wm_site_top',         10 );
				add_action( 'wmhook_body_bottom',               'wm_site_bottom',     100 );
			//Header
				add_action( 'wmhook_header_top',                'wm_header_top',       10 );
				add_action( 'wmhook_header',                    'wm_logo',             10 );
				add_action( 'wmhook_header',                    'get_sidebar',         20 );
				add_action( 'wmhook_header',                    'wm_header_widgets',   30 );
				add_action( 'wmhook_header_bottom',             'wm_header_bottom',    10 );
				add_action( 'wmhook_secondary_content_top',     'wm_logo',             10 );
				add_action( 'wmhook_secondary_controls_bottom', 'wm_post_nav',         10 );
				add_action( 'wmhook_secondary_controls_bottom', 'wm_menu_social',      20 );
			//Content
				add_action( 'wmhook_content_top',               'wm_content_top',      10 );
				add_action( 'wmhook_entry_top',                 'wm_entry_top',        10 );
				add_action( 'wmhook_entry_top',                 'wm_post_title',       20 );
				add_action( 'wmhook_entry_top',                 'wm_breadcrumbs',      30 );
				add_action( 'wmhook_entry_bottom',              'wm_entry_bottom',     10 );
				add_action( 'wmhook_comments_before',           'wm_comments_before',  10 );
				add_action( 'wmhook_comments_after',            'wm_comments_after',   10 );
				add_action( 'wmhook_content_bottom',            'wm_content_bottom',  100 );
				add_action( 'wmhook_postslist_before',          'wm_breadcrumbs',      10 );
				add_action( 'wmhook_postslist_before',          'wm_breadcrumbs_off',  20 );
			//Footer
				add_action( 'wmhook_footer_top',                'wm_footer_top',      100 );
				add_action( 'wmhook_footer',                    'wm_footer',          100 );
				add_action( 'wmhook_footer_bottom',             'wm_footer_bottom',   100 );



	/**
	 * Filters
	 */

		//Disable TGMPA - not needed
			add_filter( 'wmhook_enable_plugins_integration', '__return_false' );
		//Set up image sizes
			add_filter( 'wmhook_wm_setup_image_sizes', 'wm_image_sizes' );
		//Set required Google Fonts
			add_filter( 'wmhook_wm_google_fonts_url_fonts_setup', 'wm_google_fonts' );
		//BODY classes
			add_filter( 'body_class', 'wm_body_classes', 98 );
		//Post classes
			add_filter( 'post_class', 'wm_post_classes', 98 );
		//Navigation improvements
			add_filter( 'walker_nav_menu_start_el', 'wm_nav_item_process', 10, 4 );
		//Excerpt modifications
			add_filter( 'the_excerpt',                        'wm_remove_shortcodes',        10 );
			add_filter( 'the_excerpt',                        'wm_excerpt',                  20 );
			add_filter( 'excerpt_length',                     'wm_excerpt_length',           10 );
			add_filter( 'excerpt_more',                       'wm_excerpt_more',             10 );
			add_filter( 'wmhook_wm_excerpt_continue_reading', 'wm_excerpt_continue_reading', 10 );
		//Entry HTML attributes
			add_filter( 'wmhook_entry_container_atts', 'wm_entry_container_atts', 10 );
		//Post thumbnail
			add_filter( 'wmhook_entry_featured_image_size',         'wm_post_thumbnail_size'               );
			add_filter( 'wmhook_wm-thumb_size',                     'wm_post_thumbnail_size'               );
			add_filter( 'wmhook_entry_featured_image_fallback_url', 'wm_entry_featured_image_fallback_url' );
		//Comments form
			add_filter( 'comment_form_default_fields', 'wm_comments_form_placeholders' );
			add_filter( 'comment_form_field_comment',  'wm_comments_form_placeholders' );





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
	 * @version  1.1
	 */
	if ( ! function_exists( 'wm_setup' ) ) {
		function wm_setup() {

			//Helper variables
				$image_sizes = array_filter( apply_filters( 'wmhook_wm_setup_image_sizes', array() ) );

				//WordPress visual editor CSS stylesheets
					$visual_editor_css = array_filter( (array) apply_filters( 'wmhook_wm_setup_visual_editor_css', array(
							str_replace( ',', '%2C', wm_google_fonts_url() ),
							esc_url( add_query_arg( array( 'ver' => WM_THEME_VERSION ), wm_get_stylesheet_directory_uri( 'genericons/genericons.css' ) ) ),
							esc_url( add_query_arg( array( 'ver' => WM_THEME_VERSION ), wm_get_stylesheet_directory_uri( 'css/editor-style.css' ) ) ),
						) ) );

			/**
			 * Localization
			 *
			 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
			 */

				//wp-content/languages/theme-name/it_IT.mo
					load_theme_textdomain( 'wm_domain', trailingslashit( WP_LANG_DIR ) . 'themes/' . WM_THEME_SHORTNAME );

				//wp-content/themes/child-theme-name/languages/it_IT.mo
					load_theme_textdomain( 'wm_domain', get_stylesheet_directory() . '/languages' );

				//wp-content/themes/theme-name/languages/it_IT.mo
					load_theme_textdomain( 'wm_domain', get_template_directory() . '/languages' );

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
				add_theme_support( 'menus' );
				register_nav_menus( apply_filters( 'wmhook_wm_setup_menus', array(
						'primary' => __( 'Primary Menu', 'wm_domain' ),
						'social'  => __( 'Social Links Menu', 'wm_domain' ),
					) ) );

			//Custom header
				add_theme_support( 'custom-header', apply_filters( 'wmhook_wm_setup_custom_background_args', array(
						'default-image' => wm_get_stylesheet_directory_uri( 'images/header.jpg' ),
						'header-text'   => false,
						'width'         => 1920,
						'height'        => 640, //Approx. 62% of desktop viewport height (16:9)
						'flex-height'   => false,
						'flex-width'    => true,
					) ) );

			//Custom background
				add_theme_support( 'custom-background', apply_filters( 'wmhook_wm_setup_custom_background_args', array(
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
									&& ! get_option( 'wm-' . WM_THEME_SHORTNAME . '-image-size-' . $size )
								) {

								/**
								 * Force the default image sizes on theme installation only.
								 * This allows users to set their own sizes later, but a notification is displayed.
								 */

								if ( $image_sizes[ $size ][0] != get_option( $size . '_size_w' ) ) {
									update_option( $size . '_size_w', $image_sizes[ $size ][0] );
								}
								if ( $image_sizes[ $size ][1] != get_option( $size . '_size_h' ) ) {
									update_option( $size . '_size_h', $image_sizes[ $size ][1] );
								}
								if ( $image_sizes[ $size ][2] != get_option( $size . '_crop' ) ) {
									update_option( $size . '_crop', $image_sizes[ $size ][2] );
								}

								update_option( 'wm-' . WM_THEME_SHORTNAME . '-image-size-' . $size, true );

							} else {

								add_image_size( $size, $image_sizes[ $size ][0], $image_sizes[ $size ][1], $image_sizes[ $size ][2] );

							}

						} // /foreach

					}

		}
	} // /wm_setup



	/**
	 * Set images: default image sizes
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $image_sizes
	 */
	if ( ! function_exists( 'wm_image_sizes' ) ) {
		function wm_image_sizes( $image_sizes ) {
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
								__( 'In posts list.', 'wm_domain' )
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
								__( 'In single post page.', 'wm_domain' )
							),
						'banner' => array(
								1920,
								640, //Approx. 62% of desktop viewport height (16:9)
								true,
								__( 'In front (and blog) page banner.', 'wm_domain' )
							),
						'featured' => array(
								absint( $content_width ),
								absint( $content_width / 3 * 2 ),
								true,
								__( 'In single post page on mobile devices only.', 'wm_domain' )
							),
					);

			//Output
				return $image_sizes;
		}
	} // /wm_image_sizes



		/**
		 * Set images: register recommended image sizes notice
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_image_size_notice' ) ) {
			function wm_image_size_notice() {
				add_settings_field(
						//$id
						'recommended-image-sizes',
						//$title
						'',
						//$callback
						'wm_image_size_notice_html',
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
		} // /wm_image_size_notice



		/**
		 * Set images: display recommended image sizes notice
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_image_size_notice_html' ) ) {
			function wm_image_size_notice_html() {
				//Helper variables
					$default_image_size_names = array(
							'thumbnail' => _x( 'Thumbnail size', 'WordPress predefined image size name.', 'wm_domain' ),
							'medium'    => _x( 'Medium size', 'WordPress predefined image size name.', 'wm_domain' ),
							'large'     => _x( 'Large size', 'WordPress predefined image size name.', 'wm_domain' ),
						);

					$image_sizes = array_filter( apply_filters( 'wmhook_wm_setup_image_sizes', array() ) );

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

						do_action( 'wmhook_wm_image_size_notice_html_top' );

						echo '<h3>' . __( 'Recommended image sizes', 'wm_domain' ) . '</h3>'
							. '<p>' . __( 'For the theme to work correctly, please, set these recommended image sizes:', 'wm_domain' ) . '</p>';

						echo '<table>';

							echo '<thead>'
								. '<tr>'
								. '<th>' . __( 'Size name', 'wm_domain' ) . '</th>'
								. '<th>' . __( 'Size parameters', 'wm_domain' ) . '</th>'
								. '<th>' . __( 'Theme usage', 'wm_domain' ) . '</th>'
								. '</tr>'
								. '</thead>';

							echo '<tbody>';

								foreach ( $image_sizes as $size => $setup ) {

									if ( isset( $default_image_size_names[ $size ] ) ) {

										$crop = ( $setup[2] ) ? ( __( 'cropped', 'wm_domain' ) ) : ( __( 'scaled', 'wm_domain' ) );

										echo '<tr>'
											. '<th>' . $default_image_size_names[ $size ] . ':</th>'
											. '<td>' . sprintf(
													_x( '%1$s &times; %2$s, %3$s', '1: image width, 2: image height, 3: cropped or scaled?', 'wm_domain' ),
													$setup[0],
													$setup[1],
													$crop
												) . '</td>'
											. '<td class="small">' . ( ( isset( $setup[3] ) ) ? ( $setup[3] ) : ( '&mdash;' ) ) . '</td>'
											. '</tr>';

									} else {

										$crop = ( $setup[2] ) ? ( __( 'cropped', 'wm_domain' ) ) : ( __( 'scaled', 'wm_domain' ) );

										echo '<tr title="' . __( 'Additional image size added by the theme. Can not be changed on this page.', 'wm_domain' ) . '">'
											. '<th>' . '<code>' . $size . '</code>:</th>'
											. '<td>' . sprintf(
													_x( '%1$s &times; %2$s, %3$s', '1: image width, 2: image height, 3: cropped or scaled?', 'wm_domain' ),
													$setup[0],
													$setup[1],
													$crop
												) . '</td>'
											. '<td class="small">' . ( ( isset( $setup[3] ) ) ? ( $setup[3] ) : ( '&mdash;' ) ) . '</td>'
											. '</tr>';

									}

								} // /foreach

							echo '</tbody>';

						echo '</table>';

						do_action( 'wmhook_wm_image_size_notice_html_bottom' );

					echo '</div>';
			}
		} // /wm_image_size_notice_html



	/**
	 * Set typography: Google Fonts
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $fonts_setup
	 */
	if ( ! function_exists( 'wm_google_fonts' ) ) {
		function wm_google_fonts( $fonts_setup ) {
			return array( 'Roboto', 'Roboto Condensed:400,300', 'Alegreya:400,700' );
		}
	} // /wm_google_fonts





/**
 * 40) Assets and design
 */

	/**
	 * Registering theme styles and scripts
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_register_assets' ) ) {
		function wm_register_assets() {

			/**
			 * Styles
			 */

				$register_styles = apply_filters( 'wmhook_wm_register_assets_register_styles', array(
						'wm-genericons'   => array( wm_get_stylesheet_directory_uri( 'genericons/genericons.css' )                          ),
						'wm-google-fonts' => array( wm_google_fonts_url()                                                                   ),
						'wm-starter'      => array( wm_get_stylesheet_directory_uri( 'css/starter.css' )                                    ),
						'wm-stylesheet'   => array( 'src' => get_stylesheet_uri(), 'deps' => array( 'wm-genericons', 'wm-starter' )         ),
						'wm-colors'       => array( wm_get_stylesheet_directory_uri( 'css/colors.css' ), 'deps' => array( 'wm-stylesheet' ) ),
						'wm-slick'        => array( wm_get_stylesheet_directory_uri( 'css/slick.css' )                                      ),
					) );

				foreach ( $register_styles as $handle => $atts ) {
					$src   = ( isset( $atts['src'] )   ) ? ( $atts['src']   ) : ( $atts[0]           );
					$deps  = ( isset( $atts['deps'] )  ) ? ( $atts['deps']  ) : ( false              );
					$ver   = ( isset( $atts['ver'] )   ) ? ( $atts['ver']   ) : ( WM_SCRIPTS_VERSION );
					$media = ( isset( $atts['media'] ) ) ? ( $atts['media'] ) : ( 'all'              );

					wp_register_style( $handle, $src, $deps, $ver, $media );
				}

			/**
			 * Scripts
			 */

				$register_scripts = apply_filters( 'wmhook_wm_register_assets_register_scripts', array(
						'wm-slick'               => array( wm_get_stylesheet_directory_uri( 'js/slick.min.js' ) ),
						'wm-scripts-global'      => array( wm_get_stylesheet_directory_uri( 'js/scripts-global.js' ) ),
						'wm-skip-link-focus-fix' => array( wm_get_stylesheet_directory_uri( 'js/skip-link-focus-fix.js' ) ),
					) );

				foreach ( $register_scripts as $handle => $atts ) {
					$src       = ( isset( $atts['src'] )       ) ? ( $atts['src']       ) : ( $atts[0]           );
					$deps      = ( isset( $atts['deps'] )      ) ? ( $atts['deps']      ) : ( array( 'jquery' )  );
					$ver       = ( isset( $atts['ver'] )       ) ? ( $atts['ver']       ) : ( WM_SCRIPTS_VERSION );
					$in_footer = ( isset( $atts['in_footer'] ) ) ? ( $atts['in_footer'] ) : ( true               );

					wp_register_script( $handle, $src, $deps, $ver, $in_footer );
				}

		}
	} // /wm_register_assets



	/**
	 * Frontend HTML head assets enqueue
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_enqueue_assets' ) ) {
		function wm_enqueue_assets() {

			//Helper variables
				$enqueue_styles = $enqueue_scripts = array();

				$custom_styles = wm_custom_styles();

				$inline_styles_handle = ( wp_style_is( 'wm-colors', 'registered' ) ) ? ( 'wm-colors' ) : ( 'wm-stylesheet' );
				$inline_styles_handle = apply_filters( 'wmhook_wm_enqueue_assets_inline_styles_handle', $inline_styles_handle );

			/**
			 * Styles
			 */

				//Google Fonts
					if ( wm_google_fonts_url() ) {
						$enqueue_styles[] = 'wm-google-fonts';
					}

				//Banner slider
					if (
							( is_front_page() || is_home() )
							&& wm_has_banner_posts( 2 )
						) {
						$enqueue_styles[] = 'wm-slick';
					}

				//Main
					$enqueue_styles[] = 'wm-stylesheet';

				//Colors
					if ( 'wm-colors' === $inline_styles_handle ) {
						$enqueue_styles[] = 'wm-colors';
					}

				$enqueue_styles = apply_filters( 'wmhook_wm_enqueue_assets_enqueue_styles', $enqueue_styles );

				foreach ( $enqueue_styles as $handle ) {
					wp_enqueue_style( $handle );
				}

			/**
			 * Styles - inline
			 */

				//Customizer setup custom styles
					if ( $custom_styles ) {
						wp_add_inline_style( $inline_styles_handle, "\r\n" . apply_filters( 'wmhook_esc_css', $custom_styles ) . "\r\n" );
					}

				//Custom styles set in post/page 'custom-css' custom field
					if (
							is_singular()
							&& $output = get_post_meta( get_the_ID(), 'custom_css', true )
						) {
						$output = apply_filters( 'wmhook_wm_enqueue_assets_styles_inline_singular', "\r\n\r\n/* Custom singular styles */\r\n" . $output . "\r\n" );

						wp_add_inline_style( $inline_styles_handle, apply_filters( 'wmhook_esc_css', $output ) . "\r\n" );
					}

			/**
			 * Scripts
			 */

				//Banner slider
					if (
							( is_front_page() || is_home() )
							&& wm_has_banner_posts( 2 )
						) {
						$enqueue_scripts[] = 'wm-slick';
					}

				//Global theme scripts
					$enqueue_scripts[] = 'wm-scripts-global';

				//Skip link focus fix
					$enqueue_scripts[] = 'wm-skip-link-focus-fix';

				$enqueue_scripts = apply_filters( 'wmhook_wm_enqueue_assets_enqueue_scripts', $enqueue_scripts );

				foreach ( $enqueue_scripts as $handle ) {
					wp_enqueue_script( $handle );
				}

				//Put comments reply scripts into footer
					if (
							is_singular()
							&& comments_open()
							&& get_option( 'thread_comments' )
						) {
						wp_enqueue_script( 'comment-reply', false, false, false, true );
					}

		}
	} // /wm_enqueue_assets



	/**
	 * Customizer controls assets enqueue
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_customizer_enqueue_assets' ) ) {
		function wm_customizer_enqueue_assets() {
			//Styles
				wp_enqueue_style(
						'wm-customizer',
						get_template_directory_uri() . '/css/customizer.css',
						false,
						WM_SCRIPTS_VERSION,
						'all'
					);
		}
	} // /wm_customizer_enqueue_assets



		/**
		 * Customizer preview assets enqueue
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_customizer_preview_enqueue_assets' ) ) {
			function wm_customizer_preview_enqueue_assets() {
				//Scripts
					wp_enqueue_script(
							'wm-customizer-preview',
							wm_get_stylesheet_directory_uri( 'js/customizer-preview.js' ),
							array( 'customize-preview' ),
							WM_SCRIPTS_VERSION,
							true
						);
			}
		} // /wm_customizer_preview_enqueue_assets



	/**
	 * HTML Body classes
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $classes
	 */
	if ( ! function_exists( 'wm_body_classes' ) ) {
		function wm_body_classes( $classes ) {
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
				$body_classes = array_filter( (array) apply_filters( 'wmhook_wm_body_classes_output', $body_classes ) );
				$classes      = array_merge( $classes, array_flip( $body_classes ) );

				asort( $classes );

				return $classes;
		}
	} // /wm_body_classes



	/**
	 * Post classes
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $classes
	 */
	if ( ! function_exists( 'wm_post_classes' ) ) {
		function wm_post_classes( $classes ) {
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
	} // /wm_post_classes



	/**
	 * Singular view featured image
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_singular_featured_image' ) ) {
		function wm_singular_featured_image() {
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
							apply_filters( 'wmhook_wm_enqueue_assets_styles_inline_featured_image_size', 'large' )
						);

				} else if ( is_attachment() ) {

					$output = wp_get_attachment_image_src(
							get_the_ID(),
							apply_filters( 'wmhook_wm_enqueue_assets_styles_inline_featured_image_size', 'large' )
						);

				}

			//Preparing output

				$output = "\r\n\r\n/* Singular featured image styles */\r\n.entry-media { background-image: url('" . $output[0] . "'); }\r\n";

				$output = apply_filters( 'wmhook_wm_singular_featured_image_output', $output );

			//Output
				wp_add_inline_style( 'wm-stylesheet', apply_filters( 'wmhook_esc_css', $output ) . "\r\n" );
		}
	} // /wm_singular_featured_image





/**
 * 50) Site global markup
 */

	/**
	 * Website DOCTYPE
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_doctype' ) ) {
		function wm_doctype() {
			echo '<!doctype html>';
		}
	} // /wm_doctype



	/**
	 * Website HEAD
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_head' ) ) {
		function wm_head() {
			//Helper variables
				$output = array();

			//Preparing output
				$output[10] = '<meta charset="' . get_bloginfo( 'charset' ) . '" />';
				$output[20] = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
				$output[30] = '<link rel="profile" href="http://gmpg.org/xfn/11" />';
				$output[40] = '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />';

				//Filter output array
					$output = apply_filters( 'wmhook_wm_head_output_array', $output );

			//Output
				echo apply_filters( 'wmhook_wm_head_output', implode( "\r\n", $output ) . "\r\n" );
		}
	} // /wm_head



	/**
	 * Body top
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_site_top' ) ) {
		function wm_site_top() {
			//Helper variables
				$output  = '<div id="page" class="hfeed site">' . "\r\n";
				$output .= "\t" . '<div class="site-inner">' . "\r\n";

			//Output
				echo $output;
		}
	} // /wm_site_top



		/**
		 * Body bottom
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_site_bottom' ) ) {
			function wm_site_bottom() {
				//Helper variables
					$output  = "\r\n\t" . '</div><!-- /.site-inner -->';
					$output .= "\r\n" . '</div><!-- /#page -->' . "\r\n\r\n";

				//Output
					echo $output;
			}
		} // /wm_site_bottom



	/**
	 * Header top
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_header_top' ) ) {
		function wm_header_top() {
			//Preparing output
				$output = "\r\n\r\n" . '<header id="masthead" class="site-header" role="banner"' . wm_schema_org( 'WPHeader' ) . '>' . "\r\n\r\n";

			//Output
				echo $output;
		}
	} // /wm_header_top



		/**
		 * Header bottom
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_header_bottom' ) ) {
			function wm_header_bottom() {
				//Helper variables
					$output = "\r\n\r\n" . '</header>' . "\r\n\r\n";

				//Output
					echo $output;
			}
		} // /wm_header_bottom



		/**
		 * Display header widgets
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_header_widgets' ) ) {
			function wm_header_widgets() {
				get_sidebar( 'header' );
			}
		} // /wm_header_widgets



		/**
		 * Display social links
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_menu_social' ) ) {
			function wm_menu_social() {
				get_template_part( 'menu', 'social' );
			}
		} // /wm_menu_social



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
	if ( ! function_exists( 'wm_nav_item_process' ) ) {
		function wm_nav_item_process( $item_output, $item, $depth, $args ) {
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
	} // /wm_nav_item_process



	/**
	 * Post/page heading (title)
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $args Heading setup arguments
	 */
	if ( ! function_exists( 'wm_post_title' ) ) {
		function wm_post_title( $args = array() ) {
			//Helper variables
				global $post;

				//Requirements check
					if (
							! ( $title = get_the_title() )
							|| apply_filters( 'wmhook_wm_post_title_disable', false )
						) {
						return;
					}

				$output = $meta = '';

				$args = wp_parse_args( $args, apply_filters( 'wmhook_wm_post_title_defaults', array(
						'class'           => 'entry-title',
						'class_container' => 'entry-header',
						'link'            => esc_url( get_permalink() ),
						'output'          => '<header class="{class_container}"><{tag} class="{class}"' . wm_schema_org( 'name' ) . '>{title}</{tag}>{meta}</header>',
						'tag'             => 'h1',
						'title'           => '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $title . '</a>',
					) ) );

			//Preparing output
				//Singular title (no link applied)
					if (
							is_single()
							|| ( is_page() && 'page' === get_post_type() ) //not to display the below stuff on posts list on static front page
						) {

						if ( $suffix = wm_paginated_suffix( 'small' ) ) {
							$args['title'] .= $suffix;
						} else {
							$args['title'] = $title;
						}

						if ( ( $helper = get_edit_post_link( get_the_ID() ) ) && is_page() ) {
							$args['title'] .= ' <a href="' . esc_url( $helper ) . '" class="entry-edit" title="' . esc_attr( sprintf( __( 'Edit the "%s"', 'wm_domain' ), the_title_attribute( array( 'echo' => false ) ) ) ) . '"><span>' . _x( 'Edit', 'Edit post link.', 'wm_domain' ) . '</span></a>';
						}

					}

				//Post meta
					if ( is_single() ) {

						$meta = wm_post_meta( array(
								'class' => 'entry-category',
								'meta'  => array( 'category' ),
							) );

					}

				//Filter processed $args
					$args = apply_filters( 'wmhook_wm_post_title_args', $args );

				//Generating output HTML
					$replacements = apply_filters( 'wmhook_wm_post_title_replacements', array(
							'{class}'           => esc_attr( $args['class'] ),
							'{class_container}' => esc_attr( $args['class_container'] ),
							'{meta}'            => $meta,
							'{tag}'             => esc_attr( $args['tag'] ),
							'{title}'           => do_shortcode( $args['title'] ),
						), $args );
					$output = strtr( $args['output'], $replacements );

			//Output
				echo apply_filters( 'wmhook_wm_post_title_output', $output, $args );
		}
	} // /wm_post_title



	/**
	 * Content top
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_content_top' ) ) {
		function wm_content_top() {
			//Helper variables
				$output  = "\r\n\r\n" . '<div id="content" class="site-content">';
				$output .= "\r\n\t"   . '<div id="primary" class="content-area">';
				$output .= "\r\n\t\t" . '<main id="main" class="site-main clearfix" role="main">' . "\r\n\r\n";

			//Output
				echo $output;
		}
	} // /wm_content_top



		/**
		 * Content bottom
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_content_bottom' ) ) {
			function wm_content_bottom() {
				//Helper variables
					$output  = "\r\n\r\n\t\t" . '</main><!-- /#main -->';
					$output .= "\r\n\t"       . '</div><!-- /#primary -->';
					$output .= "\r\n"         . '</div><!-- /#content -->' . "\r\n\r\n";

				//Output
					echo $output;
			}
		} // /wm_content_bottom



		/**
		 * Breadcrumbs
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_breadcrumbs' ) ) {
			function wm_breadcrumbs() {
				if (
						function_exists( 'bcn_display' )
						&& ! is_front_page()
						&& ( is_singular() || is_archive() || is_search() )
						&& apply_filters( 'wmhook_wm_breadcrumbs_enabled', true )
					) {
					echo '<div class="breadcrumbs-container"><nav class="breadcrumbs" itemprop="breadcrumbs">' . bcn_display( true ) . '</nav></div>';
				}
			}
		} // /wm_breadcrumbs



			/**
			 * Remove breadcrumbs in posts list items
			 *
			 * @since    1.0
			 * @version  1.0
			 */
			if ( ! function_exists( 'wm_breadcrumbs_off' ) ) {
				function wm_breadcrumbs_off() {
					add_filter( 'wmhook_wm_breadcrumbs_enabled', '__return_false' );
				}
			} // /wm_breadcrumbs_off



		/**
		 * Entry container attributes
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_entry_container_atts' ) ) {
			function wm_entry_container_atts() {
				return wm_schema_org( 'entry' );
			}
		} // /wm_entry_container_atts



		/**
		 * Entry top
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_entry_top' ) ) {
			function wm_entry_top() {
				//Post content inner wrapper
					if (
							! is_single( get_the_ID() )
							&& ! is_page()
						) {
						echo '<div class="entry-inner-content">';
					}
			}
		} // /wm_entry_top



			/**
			 * Entry bottom
			 *
			 * @since    1.0
			 * @version  1.0
			 */
			if ( ! function_exists( 'wm_entry_bottom' ) ) {
				function wm_entry_bottom() {
					//Post meta
						if ( in_array( get_post_type(), apply_filters( 'wmhook_wm_entry_bottom_meta_post_types', array( 'post' ) ) ) ) {
							if ( is_single() ) {

								echo wm_post_meta( apply_filters( 'wmhook_wm_entry_bottom_meta', array(
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
			} // /wm_entry_bottom



		/**
		 * Comments section wrapper
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_comments_before' ) ) {
			function wm_comments_before() {
				echo '<div class="comments-area-wrapper">';
			}
		} // /wm_comments_before



			/**
			 * Comments section wrapper end
			 *
			 * @since    1.0
			 * @version  1.0
			 */
			if ( ! function_exists( 'wm_comments_after' ) ) {
				function wm_comments_after() {
					echo '</div>';
				}
			} // /wm_comments_after



		/**
		 * Post thumbnail (featured image) display size
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $image_size
		 */
		if ( ! function_exists( 'wm_post_thumbnail_size' ) ) {
			function wm_post_thumbnail_size( $image_size ) {
				//Preparing output
					if (
							is_single( get_the_ID() )
							|| is_page()
						) {

						$image_size = 'featured';

					} else {

						$image_size = 'thumbnail';

					}

				//Output
					return $image_size;
			}
		} // /wm_post_thumbnail_size



		/**
		 * Excerpt
		 *
		 * Displays the excerpt properly.
		 * If the post is password protected, display a message.
		 * If the post has more tag, display the content appropriately.
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $excerpt
		 */
		if ( ! function_exists( 'wm_excerpt' ) ) {
			function wm_excerpt( $excerpt ) {
				//Requirements check
					if ( post_password_required() ) {
						if ( ! is_single() ) {
							return sprintf( __( 'This content is password protected. To view it please <a%s>enter the password</a>.', 'wm_domain' ), ' href="' . esc_url( get_permalink() ) . '"' );
						}
						return;
					}

				//Preparing output
					if (
							! is_single()
							&& wm_has_more_tag()
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

							$excerpt = strtr( $excerpt, apply_filters( 'wmhook_wm_excerpt_replacements', array( '<p' => '<p class="post-excerpt"' ) ) );

					}

					//Adding "Continue reading" link
						if (
								! is_single()
								&& in_array( get_post_type(), apply_filters( 'wmhook_wm_excerpt_continue_reading_post_type', array( 'post', 'page' ) ) )
							) {
							$excerpt .= apply_filters( 'wmhook_wm_excerpt_continue_reading', '' );
						}

				//Output
					return $excerpt;
			}
		} // /wm_excerpt



			/**
			 * Excerpt length
			 *
			 * @since    1.0
			 * @version  1.0
			 *
			 * @param  absint $length
			 */
			if ( ! function_exists( 'wm_excerpt_length' ) ) {
				function wm_excerpt_length( $length ) {
					return 12;
				}
			} // /wm_excerpt_length



			/**
			 * Excerpt more
			 *
			 * @since    1.0
			 * @version  1.0
			 *
			 * @param  string $more
			 */
			if ( ! function_exists( 'wm_excerpt_more' ) ) {
				function wm_excerpt_more( $more ) {
					return '&hellip;';
				}
			} // /wm_excerpt_more



			/**
			 * Excerpt "Continue reading" text
			 *
			 * @since    1.0
			 * @version  1.0
			 *
			 * @param  string $continue
			 */
			if ( ! function_exists( 'wm_excerpt_continue_reading' ) ) {
				function wm_excerpt_continue_reading( $continue ) {
					return '<div class="link-more"><a href="' . esc_url( get_permalink() ) . '">' . sprintf( __( 'Continue reading%s&hellip;', 'wm_domain' ), '<span class="screen-reader-text"> "' . get_the_title() . '"</span>' ) . '</a></div>';
				}
			} // /wm_excerpt_continue_reading



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
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_post_nav' ) ) {
			function wm_post_nav() {
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
						$output .= get_previous_post_link( '<div class="nav-previous nav-link' . $prev_class . '">%link</div>', __( '<span class="post-title"><span class="meta-nav">Published In </span>%title</span>', 'wm_domain' ) );
					} else {
						$output .= get_next_post_link( '<div class="nav-next nav-link' . $next_class . '">%link</div>', __( '<span class="post-title"><span class="meta-nav">Next: </span>%title</span>', 'wm_domain' ) );
						$output .= get_previous_post_link( '<div class="nav-previous nav-link' . $prev_class . '">%link</div>', __( '<span class="post-title"><span class="meta-nav">Previous: </span>%title</span>', 'wm_domain' ) );
					}

					if ( $output ) {
						$output = '<nav class="navigation post-navigation links-count-' . $links_count . '" role="navigation"><h1 class="screen-reader-text">' . __( 'Post navigation', 'wm_domain' ) . '</h1><div class="nav-links">' . $output . '</div></nav>';
					}

				//Output
					echo apply_filters( 'wmhook_wm_post_nav_output', $output );
			}
		} // /wm_post_nav



		/**
		 * Pagination
		 *
		 * @since    1.0
		 * @version  1.1
		 */
		if ( ! function_exists( 'wm_pagination' ) ) {
			function wm_pagination() {
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
		} // /wm_pagination



	/**
	 * Footer
	 *
	 * Theme author credits:
	 * =====================
	 * It is completely optional, but if you like this WordPress theme,
	 * I would appreciate it if you keep the credit link in the footer.
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_footer' ) ) {
		function wm_footer() {
			//Credits
				echo '<div class="site-footer-area footer-area-site-info">';
					echo '<div class="site-info-container">';
						echo '<div class="site-info" role="contentinfo">';
							echo apply_filters( 'wmhook_wm_credits_output',
									'&copy; ' . date( 'Y' ) . ' <a href="' . home_url( '/' ) . '" title="' . get_bloginfo( 'name' ) . '">' . get_bloginfo( 'name' ) . '</a>. '
									. sprintf(
											__( 'Powered by %s.', 'wm_domain' ),
											'<a href="https://wordpress.org">WordPress</a>'
										)
									. ' '
									. sprintf(
											__( 'Theme by %s.', 'wm_domain' ),
											'<a href="' . esc_url( WM_THEME_AUTHOR_URI ) . '">WebMan Design</a>'
										)
								);
						echo '</div>';
					echo '</div>';
				echo '</div>';
		}
	} // /wm_footer



		/**
		 * Footer top
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_footer_top' ) ) {
			function wm_footer_top() {
				//Preparing output
					$output = "\r\n\r\n" . '<footer id="colophon" class="site-footer"' . wm_schema_org( 'WPFooter' ) . '>' . "\r\n\r\n";

				//Output
					echo $output;
			}
		} // /wm_footer_top



		/**
		 * Footer bottom
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_footer_bottom' ) ) {
			function wm_footer_bottom() {
				//Preparing output
					$output = "\r\n\r\n" . '</footer>' . "\r\n\r\n";

				//Output
					echo $output;
			}
		} // /wm_footer_bottom



		/**
		 * Website footer custom scripts
		 *
		 * Outputs custom scripts set in post/page 'custom-js' custom field.
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'wm_footer_custom_scripts' ) ) {
			function wm_footer_custom_scripts() {
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
					echo apply_filters( 'wmhook_wm_footer_custom_scripts_output', $output );
			}
		} // /wm_footer_custom_scripts





/**
 * 100) Other functions
 */

	/**
	 * Register predefined widget areas (sidebars)
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_register_widget_areas' ) ) {
		function wm_register_widget_areas() {
			//Secondary
				register_sidebar( array(
						'id'            => 'sidebar',
						'name'          => __( 'Sidebar', 'wm_domain' ),
						'description'   => __( 'Displayed in hidden sidebar on left below the primary navigation.', 'wm_domain' ),
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h2 class="widget-title">',
						'after_title'   => '</h2>'
					) );

			//Header
				register_sidebar( array(
						'id'            => 'header',
						'name'          => __( 'Header Widgets', 'wm_domain' ),
						'description'   => __( 'Display widgets in the site header.', 'wm_domain' ),
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h2 class="widget-title">',
						'after_title'   => '</h2>'
					) );
		}
	} // /wm_register_widget_areas



	/**
	 * Ignore sticky posts in main loop
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  obj $query
	 */
	if ( ! function_exists( 'wm_posts_query_ignore_sticky_posts' ) ) {
		function wm_posts_query_ignore_sticky_posts( $query ) {
			if ( $query->is_main_query() ) {
				$query->set( 'ignore_sticky_posts', 1 );
			}
		}
	} // /wm_posts_query_ignore_sticky_posts



	/**
	 * Include Visual Editor addons
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_visual_editor' ) ) {
		function wm_visual_editor() {
			if ( is_admin() || isset( $_GET['fl_builder'] ) ) {
				locate_template( WM_INC_DIR . 'lib/visual-editor.php', true );
			}
		}
	} // /wm_visual_editor



		/**
		 * Adding additional formats to TinyMCE editor
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array $formats
		 */
		if ( ! function_exists( 'wm_visual_editor_custom_mce_format' ) ) {
			function wm_visual_editor_custom_mce_format( $formats ) {
				//Preparing output
					$formats[] = array(
							'title' => __( 'Dropcaps', 'wm_domain' ),
							'items' => array(

								array(
									'title'    => __( 'Dropcap text', 'wm_domain' ),
									'selector' => 'p',
									'classes'  => 'dropcap-text',
								),

							),
						);

				//Return
					return $formats;
			}
		} // /wm_visual_editor_custom_mce_format



	/**
	 * Default featured image URL
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'wm_entry_featured_image_fallback_url' ) ) {
		function wm_entry_featured_image_fallback_url() {
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
							apply_filters( 'wmhook_wm_enqueue_assets_styles_inline_featured_image_size', $image_size )
						);
					$output = $output[0];

				}

			//Output
				return esc_url( $output );
		}
	} // /wm_entry_featured_image_fallback_url



	/**
	 * Add form field placeholders to comments form
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  mixed $fields
	 */
	if ( ! function_exists( 'wm_comments_form_placeholders' ) ) {
		function wm_comments_form_placeholders( $fields ) {
			//Preparing output
				if ( is_string( $fields ) ) {

					//Comment
						$fields = str_replace(
								'<textarea',
								'<textarea placeholder="' . _x( 'Comment', 'Comment form field placeholder text.', 'wm_domain' ) . '"',
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
									'<input placeholder="' . _x( 'Name', 'Comment form field placeholder text.', 'wm_domain' ) . '"',
									$fields['author']
								);
						}

					//Email
						if ( isset( $fields['author'] ) ) {
							$fields['email'] = str_replace(
									'<input',
									'<input placeholder="' . _x( 'Email', 'Comment form field placeholder text.', 'wm_domain' ) . '"',
									$fields['email']
								);
						}

					//Website
						if ( isset( $fields['author'] ) ) {
							$fields['url'] = str_replace(
									'<input',
									'<input placeholder="' . _x( 'Website', 'Comment form field placeholder text.', 'wm_domain' ) . '"',
									$fields['url']
								);
						}

				}

			//Output
				return $fields;
		}
	} // /wm_comments_form_placeholders

?>