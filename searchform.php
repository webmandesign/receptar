<?php
/**
 * Search form template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */

?>

<form method="get" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="search-field" class="screen-reader-text"><?php _ex( 'Search', 'Search field label.', 'receptar' ); ?></label>
	<input type="search" value="" placeholder="<?php _e( 'Type and press enter', 'receptar' ); ?>" name="s" class="search-field" data-id="search-field" />
</form>