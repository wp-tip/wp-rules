<?php
$attributes_html = '';
if ( ! empty( $data['attributes'] ) ) {
	foreach ( $data['attributes'] as $attribute_key => $attribute_value ) {
		$attributes_html .= " {$attribute_key}='{$attribute_value}' ";
	}
}
?>
<div class="rules-field rules-field-button" id="<?php esc_attr_e( $data['name'] ); ?>">
	<input type="button" name="<?php esc_attr_e( $data['name'] ); ?>" value="<?php esc_attr_e( $data['value'] ); ?>" <?php echo $attributes_html; ?> >
</div>
