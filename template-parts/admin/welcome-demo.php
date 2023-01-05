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

<div class="welcome__section welcome__section--demo" id="welcome-demo">

	<h2>
		<span class="welcome__icon dashicons dashicons-database-add"></span>
		<?php esc_html_e( 'Theme Demo Content', 'receptar' ); ?>
	</h2>

	<div class="welcome__section--child">
		<h3><?php esc_html_e( 'Full theme demo content', 'receptar' ); ?></h3>

		<p>
			<?php esc_html_e( 'You can install a full theme demo content to match the theme demo website.', 'receptar' ); ?>
			<a href="https://themedemos.webmandesign.eu/receptar/"><?php esc_html_e( '(Preview the demo &rarr;)', 'receptar' ); ?></a>
			<?php esc_html_e( 'This provides a comprehensive start for building your own website.', 'receptar' ); ?>
		</p>

		<p>
			<?php esc_html_e( 'Please check out these information:', 'receptar' ); ?>
			<br><a href="https://webmandesign.github.io/docs/receptar/#demo-content"><?php esc_html_e( 'Information about theme demo content &rarr;', 'receptar' ); ?></a>
			<br><a href="https://github.com/webmandesign/demo-content/tree/master/receptar/"><?php esc_html_e( 'Specific instructions on how to install theme demo content &rarr;', 'receptar' ); ?></a>
		</p>
	</div>

</div>
