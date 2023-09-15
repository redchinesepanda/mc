<div class="legal-bonus-related">
	<div class="bonus-related-title"><?php echo $args[ 'title' ]; ?></div>
	<div class="bonus-related-container">
		<?php foreach ( $args[ 'items' ] as $item ) : ?>
			<div class="related-container-item">
				<a class="container-item-image-link" href="<?php echo $item[ 'preview' ][ 'href' ]; ?>">
					<img class="container-item-image container-item-image-<?php echo $item[ 'preview' ][ 'id' ]; ?>" src="<?php echo $item[ 'preview' ][ 'src' ]; ?>" width="<?php echo $item[ 'preview' ][ 'width' ]; ?>" height="<?php echo $item[ 'preview' ][ 'height' ]; ?>" />
				</a>
				<a class="item-image-title" href="<?php echo $item[ 'title' ][ 'href' ]; ?>"><?php echo $item[ 'title' ][ 'label' ]; ?></a>
			</div>
		<?php endforeach; ?>
	</div>
</div>