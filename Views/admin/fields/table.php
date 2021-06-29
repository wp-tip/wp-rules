<div class="rules-field rules-field-table">
	<table <?php echo $data['attributes_html'] ?? ''; ?> >
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
