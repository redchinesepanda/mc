<?php if ( !empty( $args['settings']['title']['image'] ) ) : ?>
	.compilation-<?php echo $args['settings']['id']; ?> .compilation-title {
		background-image: url( '<?php echo $args['settings']['title']['image']; ?>' );
	}
<?php endif; ?>