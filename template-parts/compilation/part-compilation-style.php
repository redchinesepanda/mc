<?php if ( !empty( $args[ 'settings' ][ 'title' ][ 'image' ] ) ) : ?>
	.compilation-<?php echo $args[ 'settings' ][ 'id' ]; ?> .compilation-title {
		background-image: url( '<?php echo $args[ 'settings' ][ 'title' ][ 'image' ]; ?>' );
	}
<?php endif; ?>
<?php if ( !empty( $args[ 'billets' ] ) ) : ?>
	<?php foreach( $args[ 'billets' ] as $billet ) : ?>
		<?php echo BilletMain::render_style( $billet ); ?>
		
		<?php echo BilletAchievement::render_style( $billet ); ?>
	<?php endforeach; ?>
<?php endif; ?>