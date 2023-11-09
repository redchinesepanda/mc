<?php if ( !empty( $args[ 'items' ] ) ) : ?>
	<div class="legal-bonus-categories">
		<?php foreach ( $args[ 'items' ] as $item ) : ?>
			<<?php echo $item[ 'tag' ]; ?> class="bonus-categories-item bonus-categories-item-<?php echo $item[ 'id' ]; ?>" href="<?php echo $item[ 'href' ]; ?>"><?php echo $item[ 'label' ]; ?></<?php echo $item[ 'tag' ]; ?>>
		<?php endforeach; ?>
	</div>
<?php endif;?>