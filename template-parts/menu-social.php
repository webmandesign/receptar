<?php
/**
 * Social links menu template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.6.1
 */



if ( has_nav_menu( 'social' ) ) {
	wp_nav_menu( receptar_social_menu_args() );
}
