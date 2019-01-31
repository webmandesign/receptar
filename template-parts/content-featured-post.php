<?php
/**
 * Featured post content
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.7.0
 */

?>

<article data-id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="site-banner-media">
		<figure class="site-banner-thumbnail" title="<?php the_title(); ?>">
			<?php

			if ( has_post_thumbnail() ) {
				// Post featured image
				the_post_thumbnail( 'receptar-banner' );
			} else {
				// Fallback to Custom Header image
				$image_url = ( get_header_image() ) ? ( get_header_image() ) : ( get_theme_file_uri( 'assets/images/header.jpg' ) );
				echo '<img src="' . esc_url( $image_url ) . '" width="' . esc_attr( get_custom_header()->width ) . '" height="' . esc_attr( get_custom_header()->height ) . '" alt="' . the_title_attribute( 'echo=0' ) . '" />';
			}

			?>
		</figure>
	</div>

	<div class="site-banner-header">
		<h1 class="entry-title">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="highlight" rel="bookmark"><?php

			if ( $custom_title = trim( get_post_meta( get_the_ID(), 'banner_text', true ) ) ) {
				// Display 'banner_text' custom field if set
				echo esc_html( $custom_title );
			} else {
				// If no 'banner_text' custom field set, fall back to post title
				the_title();
			}

			?></a>
		</h1>
	</div>

</article>
