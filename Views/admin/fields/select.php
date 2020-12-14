<?php
$attributes_html = '';
if ( ! empty( $data['attributes'] ) ) {
	foreach ( $data['attributes'] as $attribute_key => $attribute_value ) {
		$attributes_html .= " {$attribute_key}='{$attribute_value}' ";
	}
}
?>
<div class="rules-field rules-field-select" id="<?php esc_attr_e( $data['name'] ); ?>">
	<label>
		<?php echo $data['label']; ?>
		<select name="<?php esc_attr_e( $data['name'] ); ?>" <?php esc_attr_e( $attributes_html ); ?> >
			<?php
			if ( ! empty( $data['options'] ) ) {
				foreach ( $data['options'] as $option_key => $option_value ) {
					?>
					<option value="<?php esc_attr_e( $option_key ); ?>" 
													 <?php
														if ( $option_key == $data['selected_key'] ) {
															?>
						selected="selected"<?php } ?> >
						<?php esc_attr_e( $option_value ); ?>
					</option>
					<?php
				}
			}
			?>
		</select>
	</label>
</div>
