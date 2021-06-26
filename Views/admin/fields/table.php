<?php
$attributes_html = '';
if ( ! empty( $data['attributes'] ) ) {
	foreach ( $data['attributes'] as $attribute_key => $attribute_value ) {
		$attributes_html .= " {$attribute_key}='{$attribute_value}' ";
	}
}
?>
<div class="rules-field rules-field-table">
	<table <?php echo $attributes_html; ?> >
		<?php foreach ( $data['rows'] as $row ) {
			?>
				<tr>
					<?php foreach ( $row as $column ) { ?>
					<td><?php echo $column; ?></td>
					<?php } ?>
				</tr>
			<?php
		}?>
	</table>
</div>
