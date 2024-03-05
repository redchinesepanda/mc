<tr class="form-field">
	<th scope="row">
		<label for="<?php echo $args[ 'field' ]; ?>"><?php echo $args[ 'label' ]; ?></label>
	</th>
	<td>
		<select name="<?php echo $args[ 'field' ]; ?>">
			<?php foreach ( $args[ 'options' ] as $option ): ?>
				<option value="<?php echo $option[ 'id' ]; ?>" <?php echo $option[ 'selected' ]; ?>><?php echo $option[ 'title' ]; ?></option>
			<?php endforeach; ?>
		</select>
		<p class="description"><?php echo $args[ 'description' ]; ?></p>
	</td>
</tr>