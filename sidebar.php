<?php
/**
 * Sidebar template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.3
 */

?>

<section id="secondary" class="secondary">

	<div class="secondary-content">

		<div class="secondary-content-container">

			<?php

			do_action( 'wmhook_secondary_content_top' );

			/**
			 * Site navigation
			 */

			?>

			<nav id="site-navigation" class="main-navigation" role="navigation"<?php echo receptar_schema_org( 'SiteNavigationElement' ); ?>>

				<span class="screen-reader-text"><?php printf( esc_html__( '%s site navigation', 'receptar' ), get_bloginfo( 'name' ) ); ?></span>

				<?php

				echo receptar_accessibility_skip_link( 'to_content' );

				wp_nav_menu( apply_filters( 'wmhook_navigation_args', array(
						'theme_location'  => 'primary',
						'container'       => 'div',
						'container_class' => 'menu',
						'menu_class'      => 'menu', //fallback for pagelist
						'items_wrap'      => '<ul>%3$s</ul>',
					) ) );

				?>

			</nav>



			<?php

			/**
			 * Sidebar
			 */

				if ( is_active_sidebar( 'sidebar' ) ) {

					wmhook_sidebars_before();

					?>

					<div class="widget-area sidebar" role="complementary"<?php echo receptar_schema_org( 'WPSideBar' ); ?>>

						<?php

						wmhook_sidebar_top();

						dynamic_sidebar( 'sidebar' );

						wmhook_sidebar_bottom();

						?>

					</div>

					<?php

					wmhook_sidebars_after();

				}

			do_action( 'wmhook_secondary_content_bottom' );

			?>

		</div>

	</div>

	<div class="secondary-controls">

		<?php

		do_action( 'wmhook_secondary_controls_top' );

		?>

		<button id="menu-toggle" class="menu-toggle" aria-controls="secondary" aria-expanded="false">

			<span class="hamburger-item"></span>
			<span class="hamburger-item"></span>
			<span class="hamburger-item"></span>

			<span class="screen-reader-text"><?php echo esc_html_x( 'Menu', 'Mobile navigation toggle button title.', 'receptar' ); ?></span>

		</button>

		<?php

		do_action( 'wmhook_secondary_controls_bottom' );

		?>

	</div>

</section>