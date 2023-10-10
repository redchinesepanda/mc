<?php if( !empty( $args ) ) : ?>
	<div class="legal-offers-compilation">
		<?php foreach ( $args as $item_id => $item ) : ?>
			<a href="<?php echo $item[ 'href' ]; ?>" class="offers-compilation-item offers-compilation-item-<?php echo $item_id; ?>"><?php echo $item[ 'label' ]; ?></a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>