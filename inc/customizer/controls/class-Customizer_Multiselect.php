<?php
/**
 * Customizer custom controls
 *
 * Customizer multi select field.
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.7.0
 */
class Receptar_Customizer_Multiselect extends WP_Customize_Control {

	public function render_content() {
		if ( ! empty( $this->choices ) && is_array( $this->choices ) ) {
			?>

			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if ( $this->description ) : ?><span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span><?php endif; ?>

				<select name="<?php echo esc_attr( $this->id ); ?>" multiple="multiple" <?php $this->link(); ?>>
					<?php

					foreach ( $this->choices as $value => $name ) {
						echo '<option value="' . esc_attr( $value ) . '" ' . selected( $this->value(), $value, false ) . '>' . esc_html( $name ) . '</option>';
					}

					?>
				</select>
				<em><?php esc_html_e( 'Press CTRL key for multiple selection.', 'receptar' ); ?></em>
			</label>

			<?php
		}
	}

} // /Receptar_Customizer_Multiselect
