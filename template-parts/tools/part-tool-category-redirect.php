<div class="form-field">
	<label for="<?php echo $args[ 'field' ]; ?>"><?php echo $args[ 'label' ]; ?></label>
	<select name="<?php echo $args[ 'field' ]; ?>">
		<?php foreach ( $args[ 'options' ] as $option ): ?>
			<option value="<?php echo $option[ 'id' ]; ?>"><?php echo $option[ 'title' ]; ?></option>
		<?php endforeach; ?>
	</select>
	<p class="description"><?php echo $args[ 'description' ]; ?></p>
</div>