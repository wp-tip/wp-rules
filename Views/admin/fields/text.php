<div class="rules-field rules-field-text" id="<?php echo esc_attr( $data['name'] ); ?>">
	<label>
		<?php echo esc_html( $data['label'] ); ?>
		<input type="text" name="<?php echo esc_attr( $data['name'] ); ?>" value="<?php echo esc_attr( $data['value'] ); ?>" <?php echo esc_html( $data['attributes_html'] ?? '' ); ?> >
	</label>
</div>
