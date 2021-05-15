<?php
$attributes_html = '';
if ( ! empty( $data['attributes'] ) ) {
	foreach ( $data['attributes'] as $attribute_key => $attribute_value ) {
		$attributes_html .= " {$attribute_key}='{$attribute_value}' ";
	}
}
?>
<div class="rules-field rules-field-tablekeyvalue">
	<table <?php echo $attributes_html; ?> >
		<?php foreach ( $data['items'] as $row_key => $row_value ) {
			?>
				<tr>
					<th><?php echo $row_key; ?></th>
					<td><?php echo $row_value; ?></td>
				</tr>
			<?php
		}?>
	</table>
</div>
