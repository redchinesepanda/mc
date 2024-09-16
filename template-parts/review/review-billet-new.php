<?php if( !empty( $args ) ) : ?>
	<div class="billet-review <?php echo $args[ 'class' ]; ?>">
		<div class="review-image">
			<img src="<?php echo $args[ 'image' ][ 'src' ]; ?>" alt="<?php echo $args[ 'image' ][ 'alt' ]; ?>" width="48" height="48" loading="lazy">
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
	<?php if( !empty( $args[ 'tnc-description' ] ) ) : ?>
		<div class="billet-footer">
			<div class="billet-tnc-description <?php echo $args[ 'tnc-class' ] ?>">
				<?php foreach ( $args[ 'tnc-description' ] as $item ) : ?>
					<?php echo $item; ?>
				<?php endforeach; ?>
				<span class="billet-footer-control" data-default="<?php echo $args[ 'footer-tnc' ]; ?>"></span>
			</div>
		</div>
	<?php endif; ?>
	
<?php endif; ?>