<?php if( !empty( $args ) ) : ?>
	<div class="billet-review <?php echo $args[ 'class' ]; ?>">
		<div class="review-image">
			<img src="<?php echo $args[ 'image' ][ 'src' ]; ?>" alt="<?php echo $args[ 'image' ][ 'alt' ]; ?>" width="<?php echo $args[ 'width' ]; ?>" loading="lazy">
		</div>
		<div class="review-data">
			<?php if( !empty( $args[ 'name' ] ) ) : ?>
				<span class="billet-name"><?php echo $args[ 'name' ]; ?></span>
			<?php endif; ?>
		</div>
		<<?php echo $args[ 'title' ][ 'tag' ]; ?> class="billet-title">
			<?php echo $args[ 'title' ][ 'text' ]; ?>
		</<?php echo $args[ 'title' ][ 'tag' ]; ?>>
		<a class="billet-get-link check-oops" href="<?php echo $args['get'][ 'href' ]; ?>" target="_blank" rel="nofollow">
			<?php echo $args['get'][ 'text' ]; ?>
		</a>
	</div>
	<div class="billet-body">
		<?php if( !empty( $args[ 'description' ] ) ) : ?>
			<div class="billet-description">
				<?php foreach ( $args[ 'description' ] as $item ) : ?>
					<?php echo $item; ?>
				<?php endforeach; ?>
				<span class="billet-footer-control" data-default="<?php echo $args[ 'footer-tnc' ]; ?>"></span>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>