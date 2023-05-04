<?php if( !empty( $args ) ) : ?>
	<div class="bonus-title">
		<img src="<?php echo $args[ 'src' ]; ?>" width="53" height="53" />
		<a class="bonus-title-link" href="<?php echo $args['title'][ 'href' ]; ?>">
			<?php echo $args['title'][ 'text' ]; ?>
		</a>
	</div>
	<div class="bonus-name">
		<?php echo $args[ 'name' ]; ?>
	</div>
	<div class="bonus-get">
		<a class="bonus-get-link" href="<?php echo $args['get'][ 'href' ]; ?>">
			<?php echo $args['get'][ 'text' ]; ?>
		</a>
	</div>
	<?php if ( !empty( $args[ 'content' ] ) ) : ?>
		<div class="bonus-content">
			<?php foreach ( $args[ 'content' ] as $item ) : ?>
				<?php echo $item; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
<?php endif; ?>