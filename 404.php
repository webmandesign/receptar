<?php
/**
 * Error 404 page template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.3
 */



get_header();

	?>

	<section id="error-404" class="error-404">

		<header class="page-header">

			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can not be found.', 'receptar' ); ?></h1>

		</header>

		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'receptar' ); ?></p>

		<?php get_search_form(); ?>

	</section>

	<?php

get_footer();
