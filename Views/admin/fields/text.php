<?php
$attributes_html = '';
if ( ! empty( $data['attributes'] ) ) {
	foreach ( $data['attributes'] as $attribute_key => $attribute_value ) {
		$attributes_html .= " {$attribute_key}='{$attribute_value}' ";
	}
}
?>
<div class="rules-field rules-field-text" id="<?php esc_attr_e( $data['name'] ); ?>">
	<label>
		<?php echo $data['label']; ?>
		<input type="text" name="<?php esc_attr_e( $data['name'] ); ?>" value="<?php esc_attr_e( $data['value'] ); ?>" <?php esc_attr_e( $attributes_html ); ?> >
	</label>
</div>
