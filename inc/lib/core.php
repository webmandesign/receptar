<?php
/**
 * A set of core functions.
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.3.5
 *
 * CONTENT:
 * -   1) Required files
 * -  10) Actions and filters
 * -  20) Branding
 * -  30) SEO
 * -  40) Post/page
 * - 100) Other functions
 */





/**
 * 1) Required files
 */

	//Main theme action hooks
		locate_template( WM_INC_DIR . 'lib/hooks.php', true );

	//Admin required files
		if ( is_admin() ) {

			//Plugins suggestions
				if ( apply_filters( 'wmhook_enable_plugins_integration', true ) ) {
					locate_template( WM_INC_DIR . 'tgmpa/class-tgm-plugin-activation.php', true );
					locate_template( WM_INC_DIR . 'tgmpa/plugins.php',                     true );
				}

		}





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Theme upgrade action
			add_action( 'init', 'receptar_theme_upgrade' );
		//Remove recent comments <style> from HTML head
			add_action( 'widgets_init', 'receptar_remove_recent_comments_style' );
		//Flushing transients
			add_action( 'switch_theme',  'receptar_image_ids_transient_flusher'      );
			add_action( 'edit_category', 'receptar_all_categories_transient_flusher' );
			add_action( 'save_post',     'receptar_all_categories_transient_flusher' );




	/**
	 * Filters
	 */

		//Escape inline CSS
			add_filter( 'wmhook_esc_css', 'receptar_esc_css' );
		//Widgets improvements
			add_filter( 'widget_title', 'receptar_html_widget_title' );
			add_filter( 'widget_text',  'do_shortcode'         );
		//Table of contents
			add_filter( 'the_content', 'receptar_nextpage_table_of_contents', 10 );

		//Remove filters
			remove_filter( 'widget_title', 'esc_html' );





/**
 * 20) Branding
 */

	/**
	 * Logo
	 *
	 * Supports Jetpack Site Logo module.
	 *
	 * @since    1.0
	 * @version  1.3
	 */
	if ( ! function_exists( 'receptar_logo' ) ) {
		function receptar_logo() {
			//Helper variables
				$output = '';

				$blog_info = apply_filters( 'wmhook_receptar_logo_blog_info', array(
						'name'        => trim( get_bloginfo( 'name' ) ),
						'description' => trim( get_bloginfo( 'description' ) ),
					) );

				$args = apply_filters( 'wmhook_receptar_logo_args', array(
						'title_att'  => ( $blog_info['description'] ) ? ( $blog_info['name'] . ' | ' . $blog_info['description'] ) : ( $blog_info['name'] ),
						'logo_image' => ( function_exists( 'jetpack_get_site_logo' ) ) ? ( absint( jetpack_get_site_logo( 'id' ) ) ) : ( false ),
						'logo_type'  => 'text',
						'url'        => home_url( '/' ),
					) );

			//Preparing output
				//Logo image
					if ( ! empty( $args['logo_image'] ) ) {

						$img_id = ( is_numeric( $args['logo_image'] ) ) ? ( absint( $args['logo_image'] ) ) : ( receptar_get_image_id_from_url( $args['logo_image'] ) );

						if ( $img_id ) {
							$logo_url = wp_get_attachment_image_src( $img_id, 'full' );

							$atts = (array) apply_filters( 'wmhook_receptar_logo_image_atts', array(
									'alt'   => esc_attr( sprintf( esc_html_x( '%s logo', 'Site logo image "alt" HTML attribute text.', 'receptar' ), $blog_info['name'] ) ),
									'title' => esc_attr( $args['title_att'] ),
									'class' => '',
								) );

							$args['logo_image'] = wp_get_attachment_image( $img_id, 'full', false, $atts );
						}

						$args['logo_type'] = 'img';

					}

					$args['logo_image'] = apply_filters( 'wmhook_receptar_logo_logo_image', $args['logo_image'] );

				//Logo HTML
					$output .= '<div class="site-branding">';
						$output .= '<h1 class="' . apply_filters( 'wmhook_receptar_logo_class', 'site-title logo type-' . $args['logo_type'], $args ) . '">';
						$output .= '<a href="' . esc_url( $args['url'] ) . '" title="' . esc_attr( $args['title_att'] ) . '">';

							if ( 'text' === $args['logo_type'] ) {
								$output .= '<span class="text-logo">' . $blog_info['name'] . '</span>';
							} else {
								$output .= $args['logo_image'];
							}

						$output .= '</a></h1>';

							if ( $blog_info['description'] ) {
								$output .= '<h2 class="site-description">' . $blog_info['description'] . '</h2>';
							}

					$output .= '</div>';

			//Output
				echo apply_filters( 'wmhook_receptar_logo_output', $output );
		}
	} // /receptar_logo





/**
 * 30) SEO
 */

	/**
	 * SEO website meta title
	 *
	 * Not needed since WordPress 4.1.
	 *
	 * @todo Remove this when WordPress 4.3 is released.
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( '_wp_render_title_tag' ) ) {

		/**
		 * SEO website meta title
		 *
		 * @param  string $title
		 * @param  string $sep
		 */
		if ( ! function_exists( 'receptar_title' ) ) {
			function receptar_title( $title, $sep ) {
				//Requirements check
					if ( is_feed() ) {
						return $title;
					}

				//Helper variables
					$sep = ' ' . trim( $sep ) . ' ';

				//Preparing output
					$title .= get_bloginfo( 'name', 'display' );

					//Site description
						if (
								( $site_description = get_bloginfo( 'description', 'display' ) )
								&& ( is_home() || is_front_page() )
							) {
							$title .= $sep . $site_description;
						}

					//Pagination / parts
						if ( receptar_paginated_suffix() && ! is_404() ) {
							$title .= $sep . receptar_paginated_suffix();
						}

				//Output
					return esc_attr( $title );
			}

			add_filter( 'wp_title', 'receptar_title', 10, 2 );
		} // /receptar_title



		/**
		 * Title shim
		 *
		 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
		 */
		function _wp_render_title_tag() {
			?>
			<title><?php wp_title( '|', true, 'right' ); ?></title>
			<?php
		}

		add_action( 'wp_head', '_wp_render_title_tag', -99 );

	} // /receptar_title




	/**
	 * Schema.org markup on HTML tags
	 *
	 * @uses    schema.org
	 * @link    http://schema.org/docs/gs.html
	 * @link    http://leaves-and-love.net/how-to-improve-wordpress-seo-with-schema-org/
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param   string  $element
	 * @param   boolean $output_meta_tag  Wraps output in a <meta> tag.
	 *
	 * @return  string Schema.org HTML attributes
	 */
	if ( ! function_exists( 'receptar_schema_org' ) ) {
		function receptar_schema_org( $element = '', $output_meta_tag = false ) {
			//Requirements check
				if ( function_exists( 'wma_schema_org' ) ) {
					return wma_schema_org( $element, $output_meta_tag );
				}
				if ( ! $element || ! apply_filters( 'wmhook_receptar_schema_org_enable', true ) ) {
					return;
				}

			//Helper variables
				$output = apply_filters( 'wmhook_schema_org_output_pre', '', $element, $output_meta_tag );

				if ( $output ) {
					return apply_filters( 'wmhook_receptar_schema_org_output', ' ' . $output, $element, $output_meta_tag );
				}

				$base    = apply_filters( 'wmhook_receptar_schema_org_base', 'http://schema.org/', $element, $output_meta_tag );
				$post_id = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
				$type    = get_post_meta( $post_id, 'schemaorg_type', true );

				//Add custom post types that describe a single item to this array
					$itempage_array = (array) apply_filters( 'wmhook_schema_org_itempage_array', array( 'jetpack-portfolio' ), $element, $output_meta_tag );

			//Generate output
				switch ( $element ) {
					case 'author':
							$output = 'itemprop="author"';
						break;

					case 'datePublished':
							$output = 'itemprop="datePublished"';
						break;

					case 'entry':
							$output = 'itemscope ';

							if ( is_page() ) {
								$output .= 'itemtype="' . $base . 'WebPage"';

							} elseif ( is_singular( 'jetpack-portfolio' ) ) {
								$output .= 'itemprop="workExample" itemtype="' . $base . 'CreativeWork"';

							} elseif ( 'audio' === get_post_format() ) {
								$output .= 'itemtype="' . $base . 'AudioObject"';

							} elseif ( 'gallery' === get_post_format() ) {
								$output .= 'itemprop="ImageGallery" itemtype="' . $base . 'ImageGallery"';

							} elseif ( 'video' === get_post_format() ) {
								$output .= 'itemprop="video" itemtype="' . $base . 'VideoObject"';

							} else {
								$output .= 'itemprop="blogPost" itemtype="' . $base . 'BlogPosting"';

							}
						break;

					case 'entry_body':
							if ( ! is_single() ) {
								$output = 'itemprop="description"';

							} elseif ( is_page() ) {
								$output = 'itemprop="mainContentOfPage"';

							} else {
								$output = 'itemprop="articleBody"';

							}
						break;

					case 'image':
							$output = 'itemprop="image"';
						break;

					case 'ItemList':
							$output = 'itemscope itemtype="' . $base . 'ItemList"';
						break;

					case 'keywords':
							$output = 'itemprop="keywords"';
						break;

					case 'name':
							$output = 'itemprop="name"';
						break;

					case 'Person':
							$output = 'itemscope itemtype="' . $base . 'Person"';
						break;

					case 'SiteNavigationElement':
							$output = 'itemscope itemtype="' . $base . 'SiteNavigationElement"';
						break;

					case 'url':
							$output = 'itemprop="url"';
						break;

					case 'WPFooter':
							$output = 'itemscope itemtype="' . $base . 'WPFooter"';
						break;

					case 'WPSideBar':
							$output = 'itemscope itemtype="' . $base . 'WPSideBar"';
						break;

					case 'WPHeader':
							$output = 'itemscope itemtype="' . $base . 'WPHeader"';
						break;

					default:
							$output = $element;
						break;
				}

				$output = ' ' . $output;

				//Output in <meta> tag
					if ( $output_meta_tag ) {
						if ( false === strpos( $output, 'content=' ) ) {
							$output .= ' content="true"';
						}
						$output = '<meta ' . trim( $output ) . ' />';
					}

			//Output
				return apply_filters( 'wmhook_receptar_schema_org_output', $output, $element, $output_meta_tag );
		}
	} // /receptar_schema_org





/**
 * 40) Post/page
 */

	/**
	 * Table of contents from <!--nextpage--> tag
	 *
	 * Will create a table of content in multipage post from
	 * the first H2 heading in each post part.
	 * Appends the output at the top and bottom of post content.
	 *
	 * @since    1.0
	 * @version  1.3
	 *
	 * @param  string $content
	 */
	if ( ! function_exists( 'receptar_nextpage_table_of_contents' ) ) {
		function receptar_nextpage_table_of_contents( $content ) {
			//Helper variables
				global $page, $numpages, $multipage, $post;

				//translators: %s will be replaced with parted post title. Copy it, do not translate.
				$title_text = apply_filters( 'wmhook_receptar_nextpage_table_of_contents_title_text', sprintf( esc_html_x( '"%s" table of contents', 'Parted/paginated post table of content title.', 'receptar' ), get_the_title() ) );
				$title      = apply_filters( 'wmhook_receptar_nextpage_table_of_contents_title', '<h2 class="screen-reader-text">' . $title_text . '</h2>' );

				//Requirements check
					if (
							! $multipage
							|| ! is_single()
						) {
						return $content;
					}

				$args = apply_filters( 'wmhook_receptar_nextpage_table_of_contents_atts', array(
						//If set to TRUE, the first post part will have a title of the post (the part title will not be parsed)
						'disable_first' => true,
						//The output HTML
						'links'         => array(),
						//Get the whole post content
						'post_content'  => ( isset( $post->post_content ) ) ? ( $post->post_content ) : ( '' ),
						//Which HTML heading tag to parse as a post part title
						'tag'           => 'h2',
					) );

				//Post part counter
					$i = 0;

			//Prepare output
				$args['post_content'] = explode( '<!--nextpage-->', $args['post_content'] );

				//Get post parts titles
					foreach ( $args['post_content'] as $part ) {

						//Current post part number
							$i++;

						//Get title for post part
							if ( $args['disable_first'] && 1 === $i ) {

								$part_title = the_title_attribute( 'echo=0' );

							} else {

								preg_match( '/<' . $args['tag'] . '(.*?)>(.*?)<\/' . $args['tag'] . '>/', $part, $matches );

								if ( ! isset( $matches[2] ) || ! $matches[2] ) {
									$part_title = sprintf( esc_html__( 'Page %s', 'receptar' ), $i );
								} else {
									$part_title = $matches[2];
								}

							}

						//Set post part class
							if ( $page === $i ) {
								$class = ' class="current"';
							} elseif ( $page > $i ) {
								$class = ' class="passed"';
							} else {
								$class = '';
							}

						//Post part item output
							$args['links'][$i] = apply_filters( 'wmhook_receptar_nextpage_table_of_contents_part', '<li' . $class . '>' . _wp_link_page( $i ) . $part_title . '</a></li>', $i, $part_title, $class, $args );

					}

				//Add table of contents into the post/page content
					$args['links'] = implode( '', $args['links'] );

					$links = apply_filters( 'wmhook_receptar_nextpage_table_of_contents_links', array(
							//Display table of contents before the post content only in first post part
								'before' => ( 1 === $page ) ? ( '<div class="post-table-of-contents top" title="' . esc_attr( strip_tags( $title_text ) ) . '">' . $title . '<ol>' . $args['links'] . '</ol></div>' ) : ( '' ),
							//Display table of cotnnets after the post cotnent on each post part
								'after'  => '<div class="post-table-of-contents bottom" title="' . esc_attr( strip_tags( $title_text ) ) . '">' . $title . '<ol>' . $args['links'] . '</ol></div>',
						), $args );

					$content = $links['before'] . $content . $links['after'];

			//Output
				return apply_filters( 'wmhook_receptar_nextpage_table_of_contents_output', $content, $args );
		}
	} // /receptar_nextpage_table_of_contents



	/**
	 * Post/page parts pagination
	 *
	 * @since    1.0
	 * @version  1.3
	 *
	 * @param  boolean $echo
	 */
	if ( ! function_exists( 'receptar_post_parts' ) ) {
		function receptar_post_parts( $echo = true ) {
			wp_link_pages( array(
				'before'         => '<p class="pagination post-parts">',
				'after'          => '</p>',
				'next_or_number' => 'number',
				'pagelink'       => '<span class="page-numbers">' . esc_html__( 'Part %', 'receptar' ) . '</span>',
				'echo'           => $echo,
			) );
		}
	} // /receptar_post_parts



	/**
	 * Post meta info
	 *
	 * hAtom microformats compatible. @link http://goo.gl/LHi4Dy
	 * Supports ZillaLikes plugin. @link http://www.themezilla.com/plugins/zillalikes/
	 * Supports Post Views Count plugin. @link https://wordpress.org/plugins/baw-post-views-count/
	 *
	 * @since    1.0
	 * @version  1.3
	 *
	 * @param  array $args
	 */
	if ( ! function_exists( 'receptar_post_meta' ) ) {
		function receptar_post_meta( $args = array() ) {
			//Helper variables
				$output = '';

				$args = wp_parse_args( $args, apply_filters( 'wmhook_receptar_post_meta_defaults', array(
						'class'       => 'entry-meta clearfix',
						'date_format' => null,
						'html'        => '<span class="{class}"{attributes}>{content}</span> ',
						'html_custom' => array(
								'date' => '<time datetime="{datetime}" class="{class}"{attributes}>{content}</time> ',
							),
						'meta'        => array(), //For example: array( 'date', 'author', 'category', 'comments', 'permalink' )
						'post_id'     => null,
						'post'        => null,
					) ) );
				$args = apply_filters( 'wmhook_receptar_post_meta_args', $args );

				$args['meta'] = array_filter( (array) $args['meta'] );

				if ( $args['post_id'] ) {
					$args['post_id'] = absint( $args['post_id'] );
					$args['post']    = get_post( $args['post_id'] );
				}

			//Requirements check
				if ( empty( $args['meta'] ) ) {
					return;
				}

			//Preparing output
				foreach ( $args['meta'] as $meta ) {

					//Allow custom metas
						$helper = '';

						$replacements  = (array) apply_filters( 'wmhook_receptar_post_meta_replacements', array(), $meta, $args );
						$single_output = apply_filters( 'wmhook_receptar_post_meta', '', $meta, $args );
						$output       .= $single_output;

					//Predefined metas
						switch ( $meta ) {
							case 'author':

								if ( apply_filters( 'wmhook_receptar_post_meta_enable_' . $meta, true, $args ) ) {
									$replacements = array(
											'{attributes}' => receptar_schema_org( 'Person' ),
											'{class}'      => 'author vcard entry-meta-element',
											'{content}'    => '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" class="url fn n" rel="author"' . receptar_schema_org( 'author' ) .'>' . get_the_author() . '</a>',
										);
								}

							break;
							case 'category':

								if (
										apply_filters( 'wmhook_receptar_post_meta_enable_' . $meta, true, $args )
										&& receptar_is_categorized_blog()
										&& ( $helper = get_the_category_list( ', ', '', $args['post_id'] ) )
									) {
									$replacements = array(
											'{attributes}' => '',
											'{class}'      => 'cat-links entry-meta-element',
											'{content}'    => $helper,
										);
								}

							break;
							case 'comments':

								if (
										apply_filters( 'wmhook_receptar_post_meta_enable_' . $meta, true, $args )
										&& ! post_password_required()
										&& (
											comments_open( $args['post_id'] )
											|| get_comments_number( $args['post_id'] )
										)
									) {
									$helper = get_comments_number( $args['post_id'] ); //Don't know why this can not be in IF condition, but otherwise it won't work...
									$element_id   = ( $helper ) ? ( '#comments' ) : ( '#respond' );
									$replacements = array(
											'{attributes}' => '',
											'{class}'      => 'comments-link entry-meta-element',
											'{content}'    => '<a href="' . esc_url( get_permalink( $args['post_id'] ) ) . $element_id . '" title="' . esc_attr( sprintf( esc_html_x( 'Comments: %d', '%d: number of comments.', 'receptar' ), $helper ) ) . '"><span class="comments-title">' . esc_html_x( 'Comments:', 'Title for number of comments in post meta.', 'receptar' ) . ' </span><span class="comments-count">' . $helper . '</span></a>',
										);
								}

							break;
							case 'date':

								if ( apply_filters( 'wmhook_receptar_post_meta_enable_' . $meta, true, $args ) ) {
									$replacements = array(
											'{attributes}' => ' title="' . esc_attr( get_the_date() ) . ' | ' . esc_attr( get_the_time( '', $args['post'] ) ) . '"' . receptar_schema_org( 'datePublished' ),
											'{class}'      => 'entry-date entry-meta-element published',
											'{content}'    => esc_html( get_the_date( $args['date_format'] ) ),
											'{datetime}'   => esc_attr( get_the_date( 'c' ) ),
										);
								}

							break;
							case 'edit':

								if (
										apply_filters( 'wmhook_receptar_post_meta_enable_' . $meta, true, $args )
										&& ( $helper = get_edit_post_link( $args['post_id'] ) )
									) {
									$the_title_attribute_args = array( 'echo' => false );
									if ( $args['post_id'] ) {
										$the_title_attribute_args['post'] = $args['post'];
									}

									$replacements = array(
											'{attributes}' => '',
											'{class}'      => 'entry-edit entry-meta-element',
											'{content}'    => '<a href="' . esc_url( $helper ) . '" title="' . esc_attr( sprintf( esc_html__( 'Edit the "%s"', 'receptar' ), the_title_attribute( $the_title_attribute_args ) ) ) . '"><span>' . esc_html_x( 'Edit', 'Edit post link.', 'receptar' ) . '</span></a>',
										);
								}

							break;
							case 'likes':

								if (
										apply_filters( 'wmhook_receptar_post_meta_enable_' . $meta, true, $args )
										&& function_exists( 'zilla_likes' )
									) {
									global $zilla_likes;
									$helper = $zilla_likes->do_likes();

									$replacements = array(
											'{attributes}' => '',
											'{class}'      => 'entry-likes entry-meta-element',
											'{content}'    => $helper,
										);
								}

							break;
							case 'permalink':

								if ( apply_filters( 'wmhook_receptar_post_meta_enable_' . $meta, true, $args ) ) {
									$the_title_attribute_args = array( 'echo' => false );
									if ( $args['post_id'] ) {
										$the_title_attribute_args['post'] = $args['post'];
									}

									$replacements = array(
											'{attributes}' => receptar_schema_org( 'url' ),
											'{class}'      => 'entry-permalink entry-meta-element',
											'{content}'    => '<a href="' . esc_url( get_permalink( $args['post_id'] ) ) . '" title="' . esc_attr( sprintf( esc_html__( 'Permalink to "%s"', 'receptar' ), the_title_attribute( $the_title_attribute_args ) ) ) . '" rel="bookmark"><span>' . get_the_title( $args['post_id'] ) . '</span></a>',
										);
								}

							break;
							case 'tags':

								if (
										apply_filters( 'wmhook_receptar_post_meta_enable_' . $meta, true, $args )
										&& ( $helper = get_the_tag_list( '', ' ', '', $args['post_id'] ) )
									) {
									$replacements = array(
											'{attributes}' => receptar_schema_org( 'keywords' ),
											'{class}'      => 'tags-links entry-meta-element',
											'{content}'    => $helper,
										);
								}

							break;
							case 'views':

								if (
										apply_filters( 'wmhook_receptar_post_meta_enable_' . $meta, true, $args )
										&& function_exists( 'bawpvc_views_sc' )
										&& ( $helper = bawpvc_views_sc( array() ) )
									) {
									$replacements = array(
											'{attributes}' => ' title="' . esc_html__( 'Views count', 'receptar' ) . '"',
											'{class}'      => 'entry-views entry-meta-element',
											'{content}'    => $helper,
										);
								}

							break;

							default:
							break;
						} // /switch

						//Single meta output
							$replacements = (array) apply_filters( 'wmhook_receptar_post_meta_replacements_' . $meta, $replacements, $args );
							if (
									empty( $single_output )
									&& ! empty( $replacements )
								) {
								if ( isset( $args['html_custom'][ $meta ] ) ) {
									$output .= strtr( $args['html_custom'][ $meta ], (array) $replacements );
								} else {
									$output .= strtr( $args['html'], (array) $replacements );
								}
							}

				} // /foreach

				if ( $output ) {
					$output = '<div class="' . esc_attr( $args['class'] ) . '">' . $output . '</div>';
				}

			//Output
				return apply_filters( 'wmhook_receptar_post_meta_output', $output, $args );
		}
	} // /receptar_post_meta



	/**
	 * Paginated heading suffix
	 *
	 * @since    1.0
	 * @version  1.3
	 *
	 * @param  string $tag           Wrapper tag
	 * @param  string $singular_only Display only on singular posts of specific type
	 */
	if ( ! function_exists( 'receptar_paginated_suffix' ) ) {
		function receptar_paginated_suffix( $tag = '', $singular_only = false ) {
			//Requirements check
				if ( $singular_only && ! is_singular( $singular_only ) ) {
					return;
				}

			//Helper variables
				global $page, $paged;

				$output = '';

				if ( ! isset( $paged ) ) {
					$paged = 0;
				}
				if ( ! isset( $page ) ) {
					$page = 0;
				}

				$paged = max( $page, $paged );

				$tag = trim( $tag );
				if ( $tag ) {
					$tag = array( '<' . $tag . '>', '</' . $tag . '>' );
				} else {
					$tag = array( '', '' );
				}

			//Preparing output
				if ( 1 < $paged ) {
					$output = ' ' . $tag[0] . sprintf( esc_html_x( '(page %s)', 'Paginated content title suffix.', 'receptar' ), $paged ) . $tag[1];
				}

			//Output
				return apply_filters( 'wmhook_receptar_paginated_suffix_output', $output );
		}
	} // /receptar_paginated_suffix



	/**
	 * Checks for <!--more--> tag in post content
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  obj/absint $post
	 */
	if ( ! function_exists( 'receptar_has_more_tag' ) ) {
		function receptar_has_more_tag( $post = null ) {
			//Helper variables
				if ( empty( $post ) ) {
					global $post;
				} elseif ( is_numeric( $post ) ) {
					$post = get_post( absint( $post ) );
				}

			//Requirements check
				if (
						! is_object( $post )
						|| ! isset( $post->post_content )
					) {
					return;
				}

			//Output
				return strpos( $post->post_content, '<!--more-->' );
		}
	} // /receptar_has_more_tag





/**
 * 100) Other functions
 */

	/**
	 * Do action on theme version change
	 *
	 * @since    1.0
	 * @version  1.2.1
	 */
	if ( ! function_exists( 'receptar_theme_upgrade' ) ) {
		function receptar_theme_upgrade() {
			//Helper variables
				$current_theme_version = get_transient( WM_THEME_SHORTNAME . '-version' );

			//Processing
				if (
						empty( $current_theme_version )
						|| wp_get_theme()->get( 'Version' ) != $current_theme_version
					) {
					do_action( 'wmhook_theme_upgrade' );
					set_transient( WM_THEME_SHORTNAME . '-version', wp_get_theme()->get( 'Version' ) );
				}
		}
	} // /receptar_theme_upgrade



	/**
	 * CSS escaping
	 *
	 * Use this for custom CSS output only!
	 * Uses `esc_attr()` while keeping quote marks.
	 *
	 * @uses  esc_attr()
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $css Code to escape
	 */
	if ( ! function_exists( 'receptar_esc_css' ) ) {
		function receptar_esc_css( $css ) {
			return str_replace( array( '&gt;', '&quot;', '&#039;' ), array( '>', '"', '\'' ), esc_attr( (string) $css ) );
		}
	} // /receptar_esc_css



	/**
	 * Outputs URL to a specific file
	 *
	 * This function looks for the file in the child theme first.
	 * If the file is not located in child theme, output the URL from parent theme.
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param   string $file_relative_path File to look for (insert the relative path within the theme folder)
	 *
	 * @return  string Actual URL to the file
	 */
	if ( ! function_exists( 'receptar_get_stylesheet_directory_uri' ) ) {
		function receptar_get_stylesheet_directory_uri( $file_relative_path ) {
			//Helper variables
				$output = '';

				$file_relative_path = trim( $file_relative_path );

			//Requirements chek
				if ( ! $file_relative_path ) {
					return apply_filters( 'wmhook_receptar_get_stylesheet_directory_uri_output', esc_url( $output ), $file_relative_path );
				}

			//Praparing output
				if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $file_relative_path ) ) {
					$output = trailingslashit( get_stylesheet_directory_uri() ) . $file_relative_path;
				} else {
					$output = trailingslashit( get_template_directory_uri() ) . $file_relative_path;
				}

			//Output
				return apply_filters( 'wmhook_receptar_get_stylesheet_directory_uri_output', esc_url( $output ), $file_relative_path );
		}
	} // /receptar_get_stylesheet_directory_uri



	/**
	 * Remove shortcodes from string
	 *
	 * This function keeps the text between shortcodes,
	 * unlike WordPress native strip_shortcodes() function.
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $content
	 */
	if ( ! function_exists( 'receptar_remove_shortcodes' ) ) {
		function receptar_remove_shortcodes( $content ) {
			return apply_filters( 'wmhook_receptar_remove_shortcodes_output', preg_replace( '|\[(.+?)\]|s', '', $content ) );
		}
	} // /receptar_remove_shortcodes



	/**
	 * HTML in widget titles
	 *
	 * Just replace the "<" and ">" in HTML tag with "[" and "]".
	 * Examples:
	 * "[em][/em]" will output "<em></em>"
	 * "[br /]" will output "<br />"
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $title
	 */
	if ( ! function_exists( 'receptar_html_widget_title' ) ) {
		function receptar_html_widget_title( $title ) {
			//Helper variables
				$replacements = array(
					'[' => '<',
					']' => '>',
				);

			//Preparing output
				$title = strtr( $title, $replacements );

			//Output
				return apply_filters( 'wmhook_receptar_html_widget_title_output', $title );
		}
	} // /receptar_html_widget_title



	/**
	 * Remove "recent comments" <style> from HTML head
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  integer $page_id
	 */
	if ( ! function_exists( 'receptar_remove_recent_comments_style' ) ) {
		function receptar_remove_recent_comments_style( $page_id = null ) {
			global $wp_widget_factory;

			remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
		}
	} // /receptar_remove_recent_comments_style



	/**
	 * Accessibility skip links
	 *
	 * @since    1.0
	 * @version  1.3
	 *
	 * @param  string $type
	 */
	if ( ! function_exists( 'receptar_accessibility_skip_link' ) ) {
		function receptar_accessibility_skip_link( $type ) {
			//Helper variables
				$links = apply_filters( 'wmhook_receptar_accessibility_skip_links', array(
					'to_content'    => '<a class="skip-link screen-reader-text" href="#content">' . esc_html__( 'Skip to content', 'receptar' ) . '</a>',
					'to_navigation' => '<a class="skip-link screen-reader-text" href="#site-navigation">' . esc_html__( 'Skip to navigation', 'receptar' ) . '</a>',
				) );

			//Output
				if ( ! isset( $links[ $type ] ) ) {
					return;
				}
				return apply_filters( 'wmhook_receptar_accessibility_skip_link_output', $links[ $type ] );
		}
	} // /receptar_accessibility_skip_link



	/**
	 * Get Google Fonts link
	 *
	 * Returns a string such as:
	 * //fonts.googleapis.com/css?family=Alegreya+Sans:300,400|Exo+2:400,700|Allan&subset=latin,latin-ext
	 *
	 * @since    1.0
	 * @version  1.3.5
	 *
	 * @param  array $fonts Fallback fonts.
	 */
	if ( ! function_exists( 'receptar_google_fonts_url' ) ) {
		function receptar_google_fonts_url( $fonts = array() ) {
			//Helper variables
				$output = '';
				$family = array();
				$subset = get_theme_mod( 'font-subset' );

				$fonts_setup = array_unique( array_filter( (array) apply_filters( 'wmhook_receptar_google_fonts_url_fonts_setup', array() ) ) );

				if ( empty( $fonts_setup ) && ! empty( $fonts ) ) {
					$fonts_setup = (array) $fonts;
				}

			//Requirements check
				if ( empty( $fonts_setup ) ) {
					return apply_filters( 'wmhook_receptar_google_fonts_url_output', $output );
				}

			//Preparing output
				foreach ( $fonts_setup as $section ) {
					$font = trim( $section );
					if ( $font ) {
						$family[] = str_replace( ' ', '+', $font );
					}
				}

				if ( ! empty( $family ) ) {
					$output = esc_url_raw( add_query_arg( array(
							'family' => implode( '|', (array) array_unique( $family ) ),
							'subset' => implode( ',', (array) $subset ), //Subset can be array if multiselect Customizer input field used
						), '//fonts.googleapis.com/css' ) );
				}

			//Output
				return apply_filters( 'wmhook_receptar_google_fonts_url_output', $output );
		}
	} // /receptar_google_fonts_url



	/**
	 * Get image ID from its URL
	 *
	 * @link   http://pippinsplugins.com/retrieve-attachment-id-from-image-url/
	 * @link   http://make.wordpress.org/core/2012/12/12/php-warning-missing-argument-2-for-wpdb-prepare/
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $url
	 */
	if ( ! function_exists( 'receptar_get_image_id_from_url' ) ) {
		function receptar_get_image_id_from_url( $url ) {
			//Helper variables
				global $wpdb;

				$output = null;

				$cache = array_filter( (array) get_transient( 'receptar-image-ids' ) );

			//Returne cached result if found and relevant
				if (
						! empty( $cache )
						&& isset( $cache[ $url ] )
						&& wp_get_attachment_url( absint( $cache[ $url ] ) )
						&& $url == wp_get_attachment_url( absint( $cache[ $url ] ) )
					) {
					return absint( apply_filters( 'wmhook_receptar_get_image_id_from_url_output', $cache[ $url ] ) );
				}

			//Preparing output
				if (
						is_object( $wpdb )
						&& isset( $wpdb->prefix )
					) {
					$prefix     = $wpdb->prefix;
					$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM " . $prefix . "posts" . " WHERE guid = %s", esc_url( $url ) ) );
					$output     = ( isset( $attachment[0] ) ) ? ( $attachment[0] ) : ( null );
				}

				//Cache the new record
					$cache[ $url ] = $output;
					set_transient( 'receptar-image-ids', array_filter( (array) $cache ) );

			//Output
				return absint( apply_filters( 'wmhook_receptar_get_image_id_from_url_output', $output ) );
		}
	} // /receptar_get_image_id_from_url



		/**
		 * Flush out the transients used in receptar_get_image_id_from_url
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_image_ids_transient_flusher' ) ) {
			function receptar_image_ids_transient_flusher() {
				delete_transient( 'receptar-image-ids' );
			}
		} // /receptar_image_ids_transient_flusher



	/**
	 * Returns true if a blog has more than 1 category
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	if ( ! function_exists( 'receptar_is_categorized_blog' ) ) {
		function receptar_is_categorized_blog() {
			//Preparing output
				if ( false === ( $all_the_cool_cats = get_transient( 'receptar-all-categories' ) ) ) {

					//Create an array of all the categories that are attached to posts
						$all_the_cool_cats = get_categories( array(
								'fields'     => 'ids',
								'hide_empty' => 1,
								'number'     => 2, //we only need to know if there is more than one category
							) );

					//Count the number of categories that are attached to the posts
						$all_the_cool_cats = count( $all_the_cool_cats );

					set_transient( 'receptar-all-categories', $all_the_cool_cats );

				}

			//Output
				if ( $all_the_cool_cats > 1 ) {
					//This blog has more than 1 category
						return true;
				} else {
					//This blog has only 1 category
						return false;
				}
		}
	} // /receptar_is_categorized_blog



		/**
		 * Flush out the transients used in receptar_is_categorized_blog
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		if ( ! function_exists( 'receptar_all_categories_transient_flusher' ) ) {
			function receptar_all_categories_transient_flusher() {
				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
					return;
				}
				//Like, beat it. Dig?
				delete_transient( 'receptar-all-categories' );
			}
		} // /receptar_all_categories_transient_flusher
