<div class="legal-billet-mega item-<?php echo $args[ 'id' ] ?>">
	<div class="billet-mega-about">
		<div class="mega-about-logo"></div>
		<a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="mega-about-afillate check-oops" rel="nofollow"><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
		<a href="<?php echo $args[ 'review' ][ 'href' ]; ?>" class="mega-about-review check-oops" rel="nofollow"><?php echo $args[ 'review' ][ 'text' ]; ?></a>
	</div>
	<div class="billet-mega-content">
		<?php echo $args[ 'content' ] ?>
	</div>
	<?php if( !empty( $args[ 'footer' ] ) ) : ?>
		<div class="billet-mega-footer">
			<?php echo $args[ 'footer' ] ?>
		</div>
	<?php endif; ?>
</div>