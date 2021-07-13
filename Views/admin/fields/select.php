<div class="rules-field rules-field-select" id="<?php echo esc_attr( $data['name'] ); ?>_field">
	<label>
		<?php echo esc_html( $data['label'] ); ?>
		<select name="<?php echo esc_attr( $data['name'] ); ?>" <?php echo wp_kses_data( $data['attributes_html'] ?? '' ); ?> >
			<?php
			if ( ! empty( $data['nogroups_html'] ) ) {
				echo wp_kses_post( $data['nogroups_html'] );
			}
			if ( ! empty( $data['groups'] ) ) {
				foreach ( $data['groups'] as $wpbr_group => $wpbr_group_options ) {
					?>
					<optgroup label="<?php echo esc_attr( $wpbr_group ); ?>">
					<?php echo wp_kses_post( $wpbr_group_options ); ?>
					</optgroup>
					<?php
				}
			}else {
				echo wp_kses_post( $data['options_html'] );
			}
			?>
		</select>
	</label>
</div>
