<div class="legal-author">
	<img class="author-photo" src="<?php echo $args[ 'file' ]; ?>" alt="author-photo" width="64" height="64" loading="lazy">
	<div class="author-data">
		<a href="<?php echo $args[ 'href' ]; ?>" class="author-name"><?php echo $args[ 'name' ]; ?></a>
		<div class="author-duty"><?php echo $args[ 'duty' ]; ?></div>
	</div>
	<?php if ( !empty( $args[ 'socialLinks' ] ) ) : ?>
		<div class="author-social-links">
			<a href="<?php echo $args[ 'socialLinks' ][ 'twitter' ]; ?>" class="social-links-twitter" target="_blank" rel="nofollow"></a>
		</div>
	<?php endif; ?>
</div>