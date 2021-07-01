<div class="rules-field rules-field-table">
	<table <?php echo wp_kses_data( $data['attributes_html'] ?? '' ); ?> >
		<?php
		foreach ( $data['rows'] as $wpbr_row ) {
			?>
				<tr>
					<?php foreach ( $wpbr_row as $wpbr_column ) { ?>
					<td><?php echo esc_html( $wpbr_column ); ?></td>
					<?php } ?>
				</tr>
			<?php
		}
		?>
	</table>
</div>
