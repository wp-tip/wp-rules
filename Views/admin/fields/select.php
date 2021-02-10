<?php
$attributes_html = '';
$array_field = false;
if ( ! empty( $data['attributes'] ) ) {
	foreach ( $data['attributes'] as $attribute_key => $attribute_value ) {
		$attributes_html .= " {$attribute_key}='{$attribute_value}' ";
		if ( 'multiple' === $attribute_key ) {
			$array_field = true;
		}
	}
}

?>
<div class="rules-field rules-field-select" id="<?php esc_attr_e( $data['name'] ); ?>_field">
	<label>
		<?php echo $data['label']; ?>
		<select name="<?php esc_attr_e( $data['name'] ); ?><?php if ( $array_field ){ ?>[]<?php }?>" <?php echo $attributes_html; ?> >
			<?php
			if ( ! empty( $data['options'] ) ) {
				foreach ( $data['options'] as $option_key => $option_value ) {
					$selected = ( ! $array_field && $option_key == $data['value'] ) || ( $array_field && in_array( (string) $option_key, $data['value'], true ) );
					?>
					<option value="<?php esc_attr_e( $option_key ); ?>" <?php if ( $selected ) { ?>selected="selected"<?php } ?> >
						<?php esc_attr_e( $option_value ); ?>
					</option>
					<?php
				}
			}
			?>
		</select>
	</label>
</div>
