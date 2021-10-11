<div class="rules-field rules-field-text" id="<?php echo esc_attr( $data['name'] ); ?>">
	<label for="<?php echo esc_attr( $data['attributes']['id'] ); ?>">
		<?php echo esc_html( $data['label'] ); ?>
	</label>
	<input type="text" name="<?php echo esc_attr( $data['name'] ); ?>" value="<?php echo esc_attr( $data['value'] ); ?>" <?php echo esc_html( $data['attributes_html'] ?? '' ); ?> >
</div>
