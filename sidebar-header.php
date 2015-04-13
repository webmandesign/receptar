<?php
/**
 * Header widget area template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */

?>

<div id="site-header-widgets" class="widget-area site-header-widgets">

	<?php

	if ( is_active_sidebar( 'header' ) ) {

		dynamic_sidebar( 'header' );

	} else {

		get_search_form();

	}

	?>

</div>