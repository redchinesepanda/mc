<div class="banner-image">
	<img src="<?php echo $args[ 'image' ][ 'src' ]; ?>" width="<?php echo $args[ 'image' ][ 'width' ]; ?>" height="<?php echo $args[ 'image' ][ 'height' ]; ?>" />
	<?php if( !empty( $args[ 'caption' ] ) ) : ?>
		<p><?php echo $args[ 'caption' ]; ?></p>
	<?php endif; ?>
</div>