<?php if ( !empty( $args[ 'preview' ] ) ) : ?>
	<div class="legal-wiki-featured">
		<img class="wiki-featured-image wiki-featured-image-<?php echo $args[ 'preview' ][ 'id' ]; ?>" src="<?php echo $args[ 'preview' ][ 'src' ]; ?>" width="<?php echo $args[ 'preview' ][ 'width' ]; ?>" height="<?php echo $args[ 'preview' ][ 'height' ]; ?>" />
	</div>
<?php endif; ?>