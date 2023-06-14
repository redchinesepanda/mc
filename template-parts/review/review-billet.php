<?php if( !empty( $args ) ) : ?>
	<div class="billet-review">
		<img class="review-image" src="<?php echo $args[ 'src' ]; ?>" width="138" height="45" />
		<a class="review-title-link check-oops" href="<?php echo $args['review'][ 'href' ]; ?>">
			<?php echo $args['review'][ 'text' ]; ?>
		</a>
	</div>
	<div class="billet-body">
		<div class="billet-title">
			<?php echo $args[ 'title' ]; ?>
		</div>
		<div class="billet-description">
			<?php foreach ( $args[ 'description' ] as $item ) : ?>
				<?php echo $item; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="billet-get">
		<a class="billet-get-link check-oops" href="<?php echo $args['get'][ 'href' ]; ?>">
			<?php echo $args['get'][ 'text' ]; ?>
		</a>
	</div>
<?php endif; ?>