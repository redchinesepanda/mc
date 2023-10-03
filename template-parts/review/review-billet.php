<?php if( !empty( $args ) ) : ?>
	<div class="billet-review <?php echo $args[ 'class' ]; ?>">
		<img class="review-image" src="<?php echo $args[ 'image' ][ 'src' ]; ?>" width="138" height="45" alt="<?php echo $args[ 'image' ][ 'alt' ]; ?>">
		<?php if( empty( $args['review'][ 'disabled' ] ) ) : ?>
			<a class="review-title-link check-oops" href="<?php echo $args['review'][ 'href' ]; ?>">
				<?php echo $args['review'][ 'text' ]; ?>
			</a>
		<?php endif; ?>
	</div>
	<div class="billet-body">
		<<?php echo $args[ 'title' ][ 'tag' ]; ?> class="billet-title">
			<?php echo $args[ 'title' ][ 'text' ]; ?>
		</<?php echo $args[ 'title' ][ 'tag' ]; ?>>
		<?php if( !empty( $args[ 'description' ] ) ) : ?>
			<div class="billet-description">
				<?php foreach ( $args[ 'description' ] as $item ) : ?>
					<?php echo $item; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="billet-get">
		<a class="billet-get-link check-oops" href="<?php echo $args['get'][ 'href' ]; ?>">
			<?php echo $args['get'][ 'text' ]; ?>
		</a>
	</div>
<?php endif; ?>