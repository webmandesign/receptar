<?php
/**
 * Default WordPress posts loop
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.3
 */



if ( have_posts() ) {

	wmhook_postslist_before();

	echo '<div id="posts" class="posts posts-list clearfix"' . receptar_schema_org( 'ItemList' ) . '>';

		wmhook_postslist_top();

		while ( have_posts() ) :

			the_post();

			get_template_part( 'template-parts/content', apply_filters( 'wmhook_loop_content_type', get_post_format() ) );

		endwhile;

		wmhook_postslist_bottom();

	echo '</div>';

	wmhook_postslist_after();

} else {

	get_template_part( 'template-parts/content', 'none' );

}

wp_reset_query();
