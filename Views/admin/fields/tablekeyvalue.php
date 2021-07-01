<div class="rules-field rules-field-tablekeyvalue">
	<table <?php echo esc_html( $data['attributes_html'] ) ?? ''; ?> >
		<?php
		foreach ( $data['items'] as $wpbr_row_key => $wpbr_row_value ) {
			?>
				<tr>
					<th><?php echo esc_html( $wpbr_row_key ); ?></th>
					<td><?php echo esc_html( $wpbr_row_value ); ?></td>
				</tr>
			<?php
		}
		?>
	</table>
</div>
