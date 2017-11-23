<?php
/**
 * Website header template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.4.0
 */





/**
 * HTML
 */

	wmhook_html_before();

?>

<html <?php language_attributes(); ?> class="no-js">

<head>

<?php

/**
 * HTML head
 */

	wmhook_head_top();

	wmhook_head_bottom();

	wp_head();

?>

</head>


<body <?php body_class(); ?>>

<?php

/**
 * Body
 */

	wmhook_body_top();



/**
 * Header
 */

	if ( ! apply_filters( 'wmhook_receptar_disable_header', false ) ) {

		wmhook_header_before();

		wmhook_header_top();

		wmhook_header();

		wmhook_header_bottom();

		wmhook_header_after();

	}



/**
 * Content
 */

	wmhook_content_before();

	wmhook_content_top();
