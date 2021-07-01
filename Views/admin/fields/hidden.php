<input type="hidden" name="<?php echo esc_attr( $data['name'] ); ?>" value="<?php echo esc_attr( $data['value'] ); ?>" <?php echo wp_kses_data( $data['attributes_html'] ?? '' ); ?> >
