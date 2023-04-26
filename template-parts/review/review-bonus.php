<?php if ( !empty( $args[ 'title' ] ) ) : ?>
	<div class="bonus-title">
		<?php echo $args[ 'title' ]; ?>
	</div>
<?php endif; ?>
<?php if ( !empty( $args[ 'description' ] ) ) : ?>
	<div class="bonus-description">
		<?php echo $args[ 'description' ]; ?>
	</div>
<?php endif; ?>
<?php if ( !empty( $args[ 'content' ] ) ) : ?>
	<div class="bonus-content">
		<?php foreach ( $args[ 'content' ] as $item ) : ?>
			<?php echo $item; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>