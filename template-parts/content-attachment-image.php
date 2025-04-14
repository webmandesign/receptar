<?php
/**
 * Attachment:image post content
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.7.0
 */

$image_size = apply_filters( 'wmhook_entry_featured_image_size', 'thumbnail' );
$image_link = array_filter( (array) apply_filters( 'wmhook_entry_image_link', wp_get_attachment_image_src( get_the_ID(), 'full' ) ) );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-media">
		<figure class="post-thumbnail">
			<?php

			if ( ! empty( $image_link ) ) {
				echo '<a href="' . esc_url( $image_link[0] ) . '" title="' . the_title_attribute( 'echo=0' ) . '">';
			}

			echo wp_get_attachment_image( get_the_ID(), $image_size );

			if ( ! empty( $image_link ) ) {
				echo '</a>';
			}

			?>
		</figure>
	</div>

	<div class="entry-inner">
		<?php wmhook_entry_top(); ?>
		<div class="entry-content">
			<table>
				<tbody>
					<tr class="date">
						<th><?php echo esc_html_x( 'Image published on:', 'Attachment page publish time.', 'receptar' ); ?></th>
						<td><?php the_time( get_option( 'date_format' ) ); ?></td>
					</tr>
					<tr class="size">
						<th><?php esc_html_e( 'Image size:', 'receptar' ); ?></th>
						<td><?php echo absint( $image_link[1] ) . ' &times; ' . absint( $image_link[2] ) . ' px'; ?></td>
					</tr>
					<tr class="filename">
						<th><?php esc_html_e( 'Image file name:', 'receptar' ); ?></th>
						<td><code><?php echo basename( get_attached_file( get_the_ID() ) ); ?></code></td>
					</tr>
				</tbody>
			</table>

			<?php the_excerpt(); ?>
		</div>
		<?php wmhook_entry_bottom(); ?>
	</div>

</article>
