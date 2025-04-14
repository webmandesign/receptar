<?php
/**
 * Custom Header content
 *
 * Works as fallback when no banner slideshow.
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.7.0
 */

?>

<div class="site-banner-content">

	<div class="site-banner-media">
		<figure class="site-banner-thumbnail">
			<?php

			$image_url = ( get_header_image() ) ? ( get_header_image() ) : ( get_theme_file_uri( 'assets/images/header.jpg' ) );

			echo '<img src="' . esc_url( $image_url ) . '" width="' . esc_attr( get_custom_header()->width ) . '" height="' . esc_attr( get_custom_header()->height ) . '" alt="" />';

			?>
		</figure>
	</div>

	<div class="site-banner-header">
		<h1 class="entry-title"><span class="highlight"><?php

		if (
			is_front_page()
			&& is_page()
			&& $custom_title = trim( get_post_meta( get_the_ID(), 'banner_text', true ) )
		) {

			// If there is a front page, display 'banner_text' custom field if set
			echo wp_kses_post( $custom_title );

		} else {

			// Display site description
			bloginfo( 'description' );

		}

		?></span></h1>
	</div>

</div>
