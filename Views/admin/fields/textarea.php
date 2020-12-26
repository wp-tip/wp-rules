<?php
$attributes_html = '';
if ( ! empty( $data['attributes'] ) ) {
	foreach ( $data['attributes'] as $attribute_key => $attribute_value ) {
		$attributes_html .= " {$attribute_key}='{$attribute_value}' ";
	}
}
?>
<div class="rules-field rules-field-textarea" id="<?php echo $data['name']; ?>">
	<label>
		<?php echo $data['label']; ?>
		<textarea name="<?php echo $data['name']; ?>" <?php echo $attributes_html; ?> ><?php echo $data['value']; ?></textarea>
	</label>
</div>
