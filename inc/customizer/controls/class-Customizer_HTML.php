<?php
/**
 * Customizer custom controls
 *
 * Customizer custom HTML (set as label).
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.7.0
 */
class Receptar_Customizer_HTML extends WP_Customize_Control {

	public function render_content() {
		echo wp_kses_post( $this->label );
	}

} // /Receptar_Customizer_HTML
