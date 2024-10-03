<div class="legal-author">
	<img class="author-photo" src="<?php echo $args[ 'file' ]; ?>" alt="author-photo" width="64" height="64" loading="lazy">
	<div class="author-data">
		<a href="<?php echo $args[ 'href' ]; ?>" class="author-name"><?php echo $args[ 'name' ]; ?></a>
		<div class="author-duty"><?php echo $args[ 'duty' ]; ?></div>
	</div>
	<?php if ( !empty( $args[ 'socialLinks' ] ) ) : ?>
		<div class="author-social-links">
			<?php if ( !empty( $args[ 'socialLinks' ][ 'twitter' ] ) ) : ?>
				<a href="<?php echo $args[ 'socialLinks' ][ 'twitter' ]; ?>" class="social-links social-link-twitter" target="_blank" rel="noreferrer nofollow"></a>
			<?php endif; ?>
			<?php if ( !empty( $args[ 'socialLinks' ][ 'facebook' ] ) ) : ?>
				<a href="<?php echo $args[ 'socialLinks' ][ 'facebook' ]; ?>" class="social-links social-link-facebook" target="_blank" rel="noreferrer nofollow"></a>
			<?php endif; ?>
			<?php if ( !empty( $args[ 'socialLinks' ][ 'linkedin' ] ) ) : ?>
				<a href="<?php echo $args[ 'socialLinks' ][ 'linkedin' ]; ?>" class="social-links social-link-linkedin" target="_blank" rel="noreferrer nofollow"></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>