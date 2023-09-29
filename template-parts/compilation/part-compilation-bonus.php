<div class="legal-compilation-bonus-set legal-compilation-bonus-set-<?php echo $args[ 'settings' ][ 'id' ]; ?>">
	<?php foreach( $args[ 'billets' ] as $billet ) : ?>
		<?php echo BilletMain::render_bonus( $billet ); ?>
	<?php endforeach; ?>
</div>