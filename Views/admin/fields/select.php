<div class="rules-field rules-field-select" id="<?php echo esc_attr( $data['name'] ); ?>_field">
	<label>
		<?php echo esc_html( $data['label'] ); ?>
		<select name="<?php echo esc_attr( $data['name'] ); ?>" <?php echo wp_kses_data( $data['attributes_html'] ?? '' ); ?> >
			<?php
			if ( ! empty( $data['options'] ) ) {
				foreach ( $data['options'] as $wpbr_option_key => $wpbr_option_value ) {
					$wpbr_selected = ( empty( $data['multiple'] ) && $wpbr_option_key === $data['value'] ) || ( ! empty( $data['multiple'] ) && in_array( (string) $wpbr_option_key, $data['value'], true ) );
					?>
					<option value="<?php echo esc_attr( $wpbr_option_key ); ?>"
											<?php
											if ( $wpbr_selected ) {
												?>
						selected="selected"<?php } ?> >
						<?php echo wp_kses_data( $wpbr_option_value ); ?>
					</option>
					<?php
				}
			}
			?>
		</select>
	</label>
</div>
