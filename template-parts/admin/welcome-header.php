<?php
/**
 * Admin "Welcome" page content component.
 *
 * Header.
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

<div class="welcome__section welcome__header">

	<h1>
		<?php echo wp_get_theme( 'receptar' )->display( 'Name' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
		<small><?php echo RECEPTAR_THEME_VERSION; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></small>
	</h1>

	<p class="welcome__intro">
		<?php

		printf(
			/* translators: 1: theme name, 2: theme developer link. */
			esc_html__( 'Congratulations and thank you for choosing %1$s theme by %2$s!', 'receptar' ),
			'<strong>' . wp_get_theme( 'receptar' )->display( 'Name' ) . '</strong>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'<a href="' . esc_url( wp_get_theme( 'receptar' )->get( 'AuthorURI' ) ) . '"><strong>WebMan Design</strong></a>'
		);

		?>
		<?php esc_html_e( 'Information on this page introduces the theme and provides useful tips.', 'receptar' ); ?>
	</p>

	<nav class="welcome__nav">
		<ul>
			<li><a href="#welcome-guide"><?php esc_html_e( 'Quickstart', 'receptar' ); ?></a></li>
			<li><a href="#welcome-demo"><?php esc_html_e( 'Demo content', 'receptar' ); ?></a></li>
			<li><a href="#welcome-promo"><?php esc_html_e( 'Upgrade', 'receptar' ); ?></a></li>
		</ul>
	</nav>

	<p>
		<a href="https://webmandesign.github.io/docs/receptar/" class="button button-hero button-primary"><?php esc_html_e( 'Documentation &rarr;', 'receptar' ); ?></a>
		<a href="https://support.webmandesign.eu/forums/forum/receptar/" class="button button-hero button-primary"><?php esc_html_e( 'Support Forum &rarr;', 'receptar' ); ?></a>
	</p>

	<p class="welcome__alert welcome__alert--tip">
		<strong class="welcome__badge"><?php echo esc_html_x( 'Tip:', 'Notice, hint.', 'receptar' ); ?></strong>
		<?php echo Receptar_Welcome::get_info_like(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
	</p>

</div>

<div class="welcome-content">
