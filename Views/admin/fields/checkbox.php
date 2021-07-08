<div class="rules-field rules-field-checkbox <?php echo esc_attr( $data['field_class'] ); ?>" id="<?php echo esc_attr( $data['name'] ); ?>">
	<label>
		<input type="checkbox" name="<?php echo esc_attr( $data['name'] ); ?>" 
												<?php
												if ( ! is_null( $data['value'] ) ) {
													?>
			checked<?php } ?> value="1" <?php echo esc_html( $data['attributes_html'] ?? '' ); ?> >
		<?php echo esc_html( $data['label'] ); ?>
	</label>
</div>
