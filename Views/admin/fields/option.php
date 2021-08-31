<?php
if ( ! empty( $data['options'] ) ) {
	foreach ( $data['options'] as $wpbr_option_key => $wpbr_option_value ) {
		$wpbr_selected = ( empty( $data['multiple'] ) && (string) $wpbr_option_key === $data['value'] ) || ( ! empty( $data['multiple'] ) && in_array( (string) $wpbr_option_key, (array) $data['value'], true ) );
		?>
		<option value="<?php echo esc_attr( $wpbr_option_key ); ?>" <?php selected( $wpbr_selected ); ?> >
			<?php echo wp_kses_data( $wpbr_option_value ); ?>
		</option>
		<?php
	}
}
