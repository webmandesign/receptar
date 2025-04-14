<?php
/**
 * More link HTML
 *
 * @package    Receptar
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.8.0
 * @version  1.8.0
 */





?>

<div class="link-more">
	<a href="<?php the_permalink(); ?>" class="more-link"><?php

	printf(
		esc_html_x( 'Continue reading%s&hellip;', '%s: Name of current post.', 'receptar' ),
		the_title( '<span class="screen-reader-text"> &ldquo;', '&rdquo;</span>', false )
	);

	?></a>
</div>
