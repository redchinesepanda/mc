<?php if ( !empty( $args[ 'items' ] ) ) : ?>
	<div class="legal-bonus-categories">
		<?php foreach ( $args[ 'items' ] as $item ) : ?>
			<a class="bonus-categories-item bonus-categories-item-<?php echo $item[ 'id' ]; ?>" href="<?php echo $item[ 'href' ]; ?>"><?php echo $item[ 'label' ]; ?></a>
		<?php endforeach; ?>
	</div>
<?php endif;?>