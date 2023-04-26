<div class="bonus-review">
	<img src="<?php echo $args[ 'src' ]; ?>" width="" height="" />
	<a href="<?php echo $args['review'][ 'href' ]; ?>">
		<?php echo $args['review'][ 'text' ]; ?>
	</a>
</div>
<?php if ( !empty( $args[ 'title' ] ) ) : ?>
	<div class="bonus-title">
		<?php echo $args[ 'title' ]; ?>
	</div>
<?php endif; ?>
<?php if ( !empty( $args[ 'description' ] ) ) : ?>
	<div class="bonus-description">
		<?php echo $args[ 'description' ]; ?>
	</div>
<?php endif; ?>
<?php if ( !empty( $args[ 'content' ] ) ) : ?>
	<div class="bonus-content">
		<?php foreach ( $args[ 'content' ] as $item ) : ?>
			<?php echo $item; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<div class="bonus-get">
	<a href="<?php echo $args['get'][ 'href' ]; ?>">
		<?php echo $args['get'][ 'text' ]; ?>
	</a>
</div>