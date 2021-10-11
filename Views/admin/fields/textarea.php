<div class="rules-field rules-field-textarea" id="<?php echo esc_attr( $data['name'] ); ?>">
	<label for="<?php echo esc_attr( $data['attributes']['id'] ); ?>">
		<?php echo esc_html( $data['label'] ); ?>
	</label>
	<textarea name="<?php echo esc_attr( $data['name'] ); ?>" <?php echo wp_kses_data( $data['attributes_html'] ?? '' ); ?> ><?php echo wp_kses_data( $data['value'] ); ?></textarea>
</div>
