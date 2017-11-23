<?php
/**
 * Website footer template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.4.0
 */





/**
 * Content
 */

	wmhook_content_bottom();

	wmhook_content_after();



/**
 * Footer
 */

	if ( ! apply_filters( 'wmhook_receptar_disable_footer', false ) ) {

		wmhook_footer_before();

		wmhook_footer_top();

		wmhook_footer();

		wmhook_footer_bottom();

		wmhook_footer_after();

	}



/**
 * Body and WordPress footer
 */

	wmhook_body_bottom();

	wp_footer();

?>

</body>

</html>
