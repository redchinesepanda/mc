<?php if ( ! empty( $args ) ) : ?>
	<select name="<?php echo $args[ 'select' ][ 'name' ]; ?>">
		<?php foreach( $args[ 'select' ][ 'options' ] as $option ) : ?>
			<option value="<?php echo $option[ 'value' ]; ?>"><?php echo $option[ 'label' ]; ?></option>
		<?php endforeach; ?>
	</select>
<?php endif; ?>