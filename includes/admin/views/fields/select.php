<div class="rules-field-container rules-field-select-container">
	<label class="rules-field-label rules-field-select-label">
		<?php echo $label; ?>
	</label>
	<select name="<?php echo $name; ?>" <?php echo $attributes; ?> >
		<?php
		foreach ($options as $option_key => $option_value){
			?>
			<option value="<?php echo $option_key; ?>" <?php if( $option_key == $value ){ ?>selected<?php } ?> >
				<?php echo $option_value; ?>
			</option>
			<?php
		}
		?>
	</select>
</div>
