<?php
/**
 * Admin "Welcome" page content component
 *
 * Demo content installation.
 *
 * @package    Receptar
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  2.0.0
 */

if ( ! class_exists( 'Receptar_Welcome' ) ) {
	return;
}

?>

<div class="welcome__section welcome__section--promo" id="welcome-promo">

	<h2>
		<span class="welcome__icon dashicons dashicons-superhero-alt"></span>
		<?php esc_html_e( 'Like the theme?', 'receptar' ); ?>
	</h2>

	<p>
		<?php esc_html_e( 'You are using a fully functional 100% free WordPress theme without any paid upgrade.', 'receptar' ); ?>
		<?php esc_html_e( 'If you find it helpful, please support its updates and technical support service with a donation or by purchasing one of paid products at WebManDesign.eu.', 'receptar' ); ?>
		<?php esc_html_e( 'Thank you!', 'receptar' ); ?>
	</p>

	<p><a href="https://www.webmandesign.eu/contact/#donation"><strong><?php esc_html_e( 'Visit WebMan Design website now &rarr;', 'receptar' ); ?></strong></a></p>

</div>
