<div class="banner-image">
	<img src="<?php echo $args[ 'image' ][ 'src' ]; ?>" width="<?php echo $args[ 'image' ][ 'width' ]; ?>" height="<?php echo $args[ 'image' ][ 'height' ]; ?>" loading="lazy">
</div>
<div class="banner-info">
	<div class="banner-title">
		<?php echo $args[ 'title' ]; ?>
	</div>
	<div class="banner-description">
		<?php echo $args[ 'description' ]; ?>
	</div>
	<div class="banner-terms">
		<a class="banner-terms-link check-oops" href="<?php echo $args['terms'][ 'href' ]; ?>">
			<?php echo $args['terms'][ 'text' ]; ?>
		</a>
	</div>
</div>