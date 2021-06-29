<div class="rules-field rules-field-button" id="<?php echo esc_attr( $data['name'] ); ?>">
	<input type="button" name="<?php echo esc_attr( $data['name'] ); ?>" value="<?php echo esc_attr( $data['value'] ); ?>" <?php echo wp_kses_data( $data['attributes_html'] ?? '' ); ?> >
</div>
