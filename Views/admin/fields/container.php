<?php
$container_additional_class = $data['attributes']['container_class'] ?? "";
unset( $data['attributes']['container_class'] );
$attributes_html = '';
if ( ! empty( $data['attributes'] ) ) {
	foreach ( $data['attributes'] as $attribute_key => $attribute_value ) {
		$attributes_html .= " {$attribute_key}='{$attribute_value}' ";
	}
}
$container_contents = "";
if ( ! empty( $data['contents'] ) ){
	$container_contents = $data['contents'];
}

?>
<div class="rules-field rules-field-container <?php echo $container_additional_class; ?>">
	<div <?php echo $attributes_html; ?> >
		<?php echo $container_contents; ?>
	</div>
</div>
