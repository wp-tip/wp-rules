<div class="rules-field rules-field-select" id="<?php echo esc_attr( $data['name'] ); ?>_field">
	<label>
		<?php echo esc_html( $data['label'] ); ?>
		<select name="<?php echo esc_attr( $data['name'] ); ?>" <?php echo wp_kses_data( $data['attributes_html'] ?? '' ); ?> >
			<?php
			if ( ! empty( $data['groups'] ) ) {
				foreach ( $data['groups'] as $group => $group_options ) {
					?>
					<optgroup label="<?php echo esc_attr( $group );?>">
					<?php echo wp_kses_post( $group_options ); ?>
					</optgroup>
				<?php
				}
			}else{
				echo wp_kses_post( $data['options_html'] );
			}
			?>
		</select>
	</label>
</div>
