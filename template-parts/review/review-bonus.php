<?php if( !empty( $args ) ) : ?>
	<div class="bonus-title">
		<img src="<?php echo $args[ 'image' ][ 'src' ]; ?>" width="<?php echo $args[ 'image' ][ 'width' ]; ?>" height="<?php echo $args[ 'image' ][ 'height' ]; ?>" />
		<?php if( !empty( $args['title'][ 'text' ] ) ) : ?>
			<a class="bonus-title-link check-oops" href="<?php echo $args['title'][ 'href' ]; ?>"><?php echo $args['title'][ 'text' ]; ?></a>
		<?php endif; ?>
	</div>
	<h3 class="bonus-name">
		<?php echo $args[ 'name' ][ 'text' ]; ?>
	</h3>
	<div class="bonus-get">
		<a class="bonus-get-link check-oops" href="<?php echo $args['get'][ 'href' ]; ?>">
			<?php echo $args['get'][ 'text' ]; ?>
		</a>
	</div>
	<?php if ( !empty( $args[ 'content' ] ) ) : ?>
		<div class="bonus-content <?php echo $args[ 'class' ]; ?>">
			<?php foreach ( $args[ 'content' ] as $item ) : ?>
				<?php echo $item; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
<?php endif; ?>