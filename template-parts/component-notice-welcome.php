<?php
/**
 * Admin notice: Welcome
 *
 * @package    Receptar
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.8.0
 * @version  1.8.0
 */





// Helper variables

	$theme_name = wp_get_theme( 'receptar' )->get( 'Name' );

?>

<div class="updated notice is-dismissible theme-welcome-notice">
	<h2>
		<?php

		printf(
			esc_html_x( 'Thank you for installing %s theme!', '%s: Theme name.', 'receptar' ),
			'<strong>' . $theme_name . '</strong>'
		);

		?>
	</h2>
	<p>
		<?php esc_html_e( 'You can tweak the theme options in customizer.', 'receptar' ); ?>
		<br>
		<?php

		printf(
			esc_html_x( 'If you %1$s like this theme, please rate it %2$s', '%1$s: heart icon, %2$s: star icons', 'receptar' ),
			'<span class="dashicons dashicons-heart" style="color: red; vertical-align: middle;"></span>',
			'<a href="https://wordpress.org/support/theme/receptar/reviews/#new-post" style="display: inline-block; color: goldenrod; text-decoration-style: wavy; vertical-align: middle;"><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span></span></a>'
		);

		echo  '<br>'
		    . '<a href="http://webmandesign.eu/contact/?utm_source=receptar">'
		    . esc_html__( 'And/or please consider a donation, thank you 🙏😊', 'receptar' )
		    . '</a>';

		?>
	</p>
	<p class="call-to-action">
		<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary button-hero">
			<?php esc_html_e( 'Customize theme now &rarr;', 'receptar' ); ?>
		</a>
		&ensp;
		<a href="https://webmandesign.github.io/docs/receptar/" class="button button-hero" target="_blank">
			<?php esc_html_e( 'Theme documentation &rarr;', 'receptar' ); ?>
		</a>
	</p>
	<p class="support">
		<?php

		echo esc_html__( 'Have a suggestion for improvement or something is not working as it should?', 'receptar' )
		   . ' <a href="https://support.webmandesign.eu/">'
		   . esc_html__( 'Contact support center &rarr;', 'receptar' )
		   . '</a>';

		?>
	</p>
</div>

<style type="text/css" media="screen">

	.notice.theme-welcome-notice {
		padding: 1.62em;
		line-height: 1.62;
		font-size: 1.38em;
		text-align: center;
		border: 0;
	}

	.theme-welcome-notice h2 {
		margin: 0 0 .62em;
		line-height: inherit;
		font-size: 1.62em;
		font-weight: 400;
	}

	.theme-welcome-notice p {
		font-size: inherit;
	}

	.theme-welcome-notice a {
		padding-bottom: 0;
	}

	.theme-welcome-notice strong {
		font-weight: bolder;
	}

	.theme-welcome-notice .call-to-action {
		margin-top: 1em;
	}

	.theme-welcome-notice .button.button {
		font-size: 1em;
	}

	.theme-welcome-notice .support {
		margin-top: 2em;
		font-size: .81em;
		font-style: italic;
	}

</style>
