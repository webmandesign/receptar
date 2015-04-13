<?php
/**
 * Page template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */



get_header();

	wmhook_entry_before();

	if ( have_posts() ) {

		the_post();

		get_template_part( 'content', 'page' );

		wp_reset_query();

	}

	wmhook_entry_after();

get_footer();

?>