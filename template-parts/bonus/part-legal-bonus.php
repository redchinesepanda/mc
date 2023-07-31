<?php

// LegalDebug::debug( [
// 	'args' => $args,
// ] );

?>
<?php if ( !empty( $args[ 'items' ] ) ) : ?>
	<div class="legal-bonus-list">
		<?php foreach( $args[ 'items' ] as $item ) : ?>
			<div class="bonus-list-item item-<?php echo $item[ 'id' ]; ?>">
				<?php if ( !empty( $item[ 'preview' ] ) ) : ?>
					<a class="item-image-link" href="<?php echo $item[ 'preview' ][ 'href' ]; ?>">
						<img class="item-image" src="<?php echo $item[ 'preview' ][ 'src' ]; ?>" width="<?php echo $item[ 'preview' ][ 'width' ]; ?>" height="<?php echo $item[ 'preview' ][ 'height' ]; ?>" />
					</a>
				<?php endif; ?>
				<div class="list-item-about">
					<img class="item-logo" src="<?php echo $item[ 'logo' ][ 'src' ]; ?>" width="<?php echo $item[ 'logo' ][ 'width' ]; ?>" height="<?php echo $item[ 'logo' ][ 'height' ]; ?>" />
					<div class="item-about-title">
						<a class="item-image-link" href="<?php echo $item[ 'title' ][ 'href' ]; ?>"><?php echo $item[ 'title' ][ 'label' ]; ?></a>
					</div>
					<div class="item-about-size"><?php echo $item[ 'size' ]; ?></div>
					<div class="item-about-get">
						<a class="about-get-button" href="<?php echo $item[ 'get' ][ 'href' ]; ?>"><?php echo $item[ 'get' ][ 'label' ]; ?></a>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>