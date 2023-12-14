<a class="legal-logo" href="<?php echo $args[ 'href' ]; ?>">
	<picture>
		<?php if ( !empty( $args[ 'source' ] ) ) : ?>
			<?php foreach( $args[ 'source' ] as $item ) : ?>
				<source srcset="<?php echo $item[ 'srcset' ]; ?>" media="<?php echo $item[ 'media' ]; ?>" width="<?php echo $item[ 'width' ]; ?>" height="<?php echo $item[ 'height' ]; ?>">
			<?php endforeach; ?>
		<?php endif; ?>
		<img src="<?php echo $args[ 'img' ][ 'src' ]; ?>" width="<?php echo $args[ 'img' ][ 'width' ]; ?>" height="<?php echo $args[ 'img' ][ 'height' ]; ?>" alt="<?php echo $args[ 'img' ][ 'alt' ]; ?>">
	</picture>
</a>