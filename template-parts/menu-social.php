<?php
/**
 * Social links menu template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.8.4
 */

if ( has_nav_menu( 'social' ) ) {
	$args = receptar_social_menu_args();
	wp_nav_menu( $args );
}
