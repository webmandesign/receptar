<?php
/**
 * Search form template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.3
 */

?>

<form method="get" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="search-field" class="screen-reader-text"><?php echo esc_html_x( 'Search', 'Search field label.', 'receptar' ); ?></label>
	<input type="search" value="" placeholder="<?php esc_attr_e( 'Type and press enter', 'receptar' ); ?>" name="s" class="search-field" data-id="search-field" />
</form>