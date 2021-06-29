<div class="rules-field rules-field-select" id="<?php esc_attr_e( $data['name'] ); ?>_field">
	<label>
		<?php echo $data['label']; ?>
		<select name="<?php esc_attr_e( $data['name'] ); ?><?php if ( $data['multiple'] ){ ?>[]<?php }?>" <?php echo $data['attributes_html']; ?> >
			<?php
			if ( ! empty( $data['options'] ) ) {
				foreach ( $data['options'] as $option_key => $option_value ) {
					$selected = ( ! $data['multiple'] && $option_key == $data['value'] ) || ( $data['multiple'] && in_array( (string) $option_key, $data['value'], true ) );
					?>
					<option value="<?php esc_attr_e( $option_key ); ?>" <?php if ( $selected ) { ?>selected="selected"<?php } ?> >
						<?php esc_attr_e( $option_value ); ?>
					</option>
					<?php
				}
			}
			?>
		</select>
	</label>
</div>
