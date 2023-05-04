<?php if( !empty( $args ) ) : ?>
	<div class="billet-review">
		<img class="review-image" src="<?php echo $args[ 'src' ]; ?>" width="138" height="45" />
		<a class="review-title-link" href="<?php echo $args['review'][ 'href' ]; ?>">
			<?php echo $args['review'][ 'text' ]; ?>
		</a>
	</div>
	<div class="billet-body">
		<div class="billet-title">
			<?php echo $args[ 'title' ]; ?>
		</div>
		<div class="billet-description">
			<?php echo $args[ 'description' ]; ?>
		</div>
	</div>
	<div class="billet-get">
		<a class="billet-get-link" href="<?php echo $args['get'][ 'href' ]; ?>">
			<?php echo $args['get'][ 'text' ]; ?>
		</a>
	</div>
<?php endif; ?>