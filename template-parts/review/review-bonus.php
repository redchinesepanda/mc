<div class="legal-bonus">
	<?php if ( !empty( $args[ 'title' ] ) ) : ?>
		<?php echo $args[ 'title' ]; ?>
	<?php endif; ?>
	<?php if ( !empty( $args[ 'description' ] ) ) : ?>
		<?php echo $args[ 'description' ]; ?>
	<?php endif; ?>
	<?php if ( !empty( $args[ 'content' ] ) ) : ?>
		<?php foreach ( $args[ 'content' ] as $item ) : ?>
			<?php echo $item; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>