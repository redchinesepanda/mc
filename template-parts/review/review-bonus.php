<div class="bonus-title">
	<?php if ( !empty( $args[ 'title' ] ) ) : ?>
		<?php echo $args[ 'title' ]; ?>
	<?php endif; ?>
</div>
<div class="bonus-description">
	<?php if ( !empty( $args[ 'description' ] ) ) : ?>
		<?php echo $args[ 'description' ]; ?>
	<?php endif; ?>
</div>
<div class="bonus-content">
	<?php if ( !empty( $args[ 'content' ] ) ) : ?>
		<?php foreach ( $args[ 'content' ] as $item ) : ?>
			<?php echo $item; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>