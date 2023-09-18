<div class="legal-bonus-duration <?php echo $args[ 'class' ]; ?>">
	<span class="duration-label-title"><?php echo $args[ 'title' ]; ?></span>
	<?php if ( !empty( $args[ 'duration' ] ) ) : ?>
		<span class="duration-label-prefix"><?php echo $args[ 'prefix' ]; ?></span>
		<span class="duration-label-duration"><?php echo $args[ 'duration' ]; ?></span>
	<?php endif; ?>
</div>