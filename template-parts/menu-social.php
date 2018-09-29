<?php
/**
 * Social links menu template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.6.0
 */



if ( has_nav_menu( 'social' ) ) {

	wp_nav_menu(
		array(
			'theme_location'  => 'social',
			'container'       => 'div',
			'container_id'    => '',
			'container_class' => 'social-links',
			'menu_class'      => 'social-links-items',
			'depth'           => 1,
			'link_before'     => '<span class="screen-reader-text">',
			'link_after'      => '</span>',
			'fallback_cb'     => false,
			'items_wrap'      => '<ul data-id="%1$s" class="%2$s">%3$s</ul>',
		)
	);

}

?>
