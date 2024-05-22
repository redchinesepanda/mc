<?php if ( ! empty( $args[ 'items' ] ) ) : ?>
	<?php foreach ( $args[ 'items' ] as $code => $item ) : ?>
		<link rel="alternate" hreflang="<?php echo $item[ 'hreflang' ]; ?>" href="<?php echo $item[ 'href' ]; ?>">
	<?php endforeach; ?>
<?php endif; ?>