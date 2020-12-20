<?php
$attributes_html = '';
if ( ! empty( $data['attributes'] ) ) {
	foreach ( $data['attributes'] as $attribute_key => $attribute_value ) {
		$attributes_html .= " {$attribute_key}='{$attribute_value}' ";
	}
}
?>
<input type="hidden" name="<?php echo esc_attr( $data['name'] ); ?>" value="<?php echo esc_attr( $data['value'] ); ?>" <?php echo $attributes_html; ?> >
