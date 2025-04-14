<?php
/**
 * Standard post/page content
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.8.0
 */

$pagination_suffix = receptar_paginated_suffix( 'small', 'post' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( apply_filters( 'wmhook_entry_featured_image_display', true ) ) : ?>
		<div class="entry-media">
			<figure class="post-thumbnail">
				<?php

				$image_size = apply_filters( 'wmhook_entry_featured_image_size', 'thumbnail' );
				$image_link = ( is_singular() ) ? ( wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) ) : ( array( esc_url( get_permalink() ) ) );
				$image_link = array_filter( (array) apply_filters( 'wmhook_entry_image_link', $image_link ) );

				if ( ! empty( $image_link ) ) {
					echo '<a href="' . esc_url( $image_link[0] ) . '" title="' . the_title_attribute( 'echo=0' ) . '">';
				}

				if (
					has_post_thumbnail()
					&& $image = get_the_post_thumbnail( get_the_ID(), $image_size )
				) {
					echo $image; // WPCS: XSS OK.
				} else {
					echo '<img src="' . apply_filters( 'wmhook_entry_featured_image_fallback_url', '' ) . '" alt="' . the_title_attribute( 'echo=0' ) . '" title="' . the_title_attribute( 'echo=0' ) . '" />';
				}

				if ( ! empty( $image_link ) ) {
					echo '</a>';
				}

				?>
			</figure>
		</div>
	<?php endif; ?>

	<div class="entry-inner">
		<?php wmhook_entry_top(); ?>
		<div class="entry-content">
			<?php

			if (
				! is_singular()
				|| ( is_single() && has_excerpt() && ! $pagination_suffix )
			) {
				the_excerpt();
			}

			if ( is_singular() ) {
				the_content();
			}

			?>
		</div>
		<?php wmhook_entry_bottom(); ?>
	</div>

</article>
