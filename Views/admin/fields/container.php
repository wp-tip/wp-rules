<div class="rules-field rules-field-container <?php echo esc_attr( $data['container_class'] ?? '' ); ?>">
	<div <?php echo wp_kses_data( $data['attributes_html'] ?? '' ); ?> >
		<?php echo wp_kses_post( $data['contents'] ?? '' ); ?>
	</div>
</div>
