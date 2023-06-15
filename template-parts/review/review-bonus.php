<?php if( !empty( $args ) ) : ?>
	<div class="bonus-title">
		<img src="<?php echo $args[ 'src' ]; ?>" width="53" height="53" />
		<h4 class="bonus-title-wrapper">
			<a class="bonus-title-link check-oops" href="<?php echo $args['title'][ 'href' ]; ?>">
				<?php echo $args['title'][ 'text' ]; ?>
			</a>
		</h4>
	</div>
	<div class="bonus-name">
		<?php echo $args[ 'name' ]; ?>
	</div>
	<div class="bonus-get">
		<a class="bonus-get-link check-oops" href="<?php echo $args['get'][ 'href' ]; ?>">
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