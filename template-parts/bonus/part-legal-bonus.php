<?php

LegalDebug::debug( [
	'args' => $args,
] );

?>
<?php if ( !empty( $args[ 'items' ] ) ) : ?>
	<div class="legal-bonus-list">
		<?php foreach( $args[ 'items' ] as $item ) : ?>
			<div class="bonus-list-item">
				<?php if ( !empty( $item[ 'preview' ] ) ) : ?>
					<img class="item-image" src="<?php echo $item[ 'preview' ][ 'src' ]; ?>" width="<?php echo $item[ 'preview' ][ 'width' ]; ?>" height="<?php echo $item[ 'preview' ][ 'height' ]; ?>" />
				<?php endif; ?>
			</div>	
		<?php endforeach; ?>
	</div>
<?php endif; ?>