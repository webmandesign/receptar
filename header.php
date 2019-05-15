<?php
/**
 * Website header template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.8.2
 */





wmhook_html_before();

?>

<html <?php language_attributes(); ?> class="no-js">

<head>

<?php

wmhook_head_top();
wmhook_head_bottom();

wp_head();

?>

</head>


<body <?php body_class(); ?>>

<?php

if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} else {
	do_action( 'wp_body_open' );
}

wmhook_body_top();

if ( ! apply_filters( 'wmhook_receptar_disable_header', false ) ) {
	wmhook_header_before();
	wmhook_header_top();
	wmhook_header();
	wmhook_header_bottom();
	wmhook_header_after();
}

wmhook_content_before();
wmhook_content_top();
