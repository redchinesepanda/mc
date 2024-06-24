<?php if( !empty( $args ) ) : ?>
	<div class="bonus-header">
		<div class="bonus-title">
			<!-- <style type="text/css">
				.legal-bonus.item-<?php echo $args[ 'index' ]; ?> .bonus-title-image {
					background-image: url( '<?php echo $args[ 'src' ]; ?>' );
				}
			</style> -->
			<?php if( !empty( $args['src'] ) ) : ?>
				<img class="bonus-title-image" alt="<?php echo $args['title'][ 'text' ]; ?>" src="<?php echo $args[ 'src' ]; ?>" width="70" height="70" loading="lazy">
			<?php endif; ?>
			<?php if( !empty( $args['title'][ 'text' ] ) ) : ?>
				<a class="bonus-title-link check-oops" href="<?php echo $args['title'][ 'href' ]; ?>"><?php echo $args['title'][ 'text' ]; ?></a>
			<?php endif; ?>
		</div>
		<h3 class="bonus-name">
			<?php echo $args[ 'name' ][ 'text' ]; ?>
		</h3>
		<div class="bonus-get">
			<a class="bonus-get-link check-oops" href="<?php echo $args['get'][ 'href' ]; ?>" target="_blank" rel="nofollow">
				<?php echo $args['get'][ 'text' ]; ?>
			</a>
		</div>
	</div>
	<?php if ( !empty( $args[ 'content' ] ) ) : ?>
		<div class="bonus-content <?php echo $args[ 'class' ]; ?>">
			<?php foreach ( $args[ 'content' ] as $item ) : ?>
				<?php echo $item; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
<?php endif; ?>