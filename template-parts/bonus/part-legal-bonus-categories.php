<?php if ( !empty( $args[ 'items' ] ) ) : ?>
	<div class="legal-bonus-categories">
		<?php foreach ( $args[ 'items' ] as $item ) : ?>
			<?php if ( !empty( $args[ 'items' ] ) ) : ?>
				<a class="bonus-categories-item bonus-categories-item-<?php echo $item[ 'id' ]; ?>" href="<?php echo $item[ 'href' ]; ?>"><?php echo $item[ 'label' ]; ?></a>
			<?php else: ?>
				<span class="bonus-categories-item bonus-categories-item-<?php echo $item[ 'id' ]; ?>"><?php echo $item[ 'label' ]; ?></span>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif;?>