<div class="legal-compilation-bonus <?php echo $args[ 'selector' ]; ?> font-<?php echo $args[ 'font' ]; ?>">
	<div class="legal-compilation-logo">
		<a class="legal-logo-link<?php echo $args[ 'logo' ][ 'class' ]; ?> check-oops" href="<?php echo $args[ 'logo' ][ 'href' ]; ?>" <?php echo BilletMain::render_nofollow( $args[ 'logo' ][ 'nofollow' ] ); ?>>
			<img src="<?php echo $args[ 'logo' ][ 'src' ]; ?>" class="legal-logo-picture" alt="<?php echo $args[ 'logo' ][ 'alt' ]; ?>" width="138" height="45" loading="lazy">
		</a>
	</div>
	<div class="legal-compilation-peculiarity">
		<div class="legal-compilation-peculiarity-bonys">
			<a href="<?php echo $args[ 'title' ][ 'href' ]; ?>" <?php echo BilletMain::render_nofollow( $args[ 'title' ][ 'nofollow' ] ); ?> class="peculiarity-bonys-link"><?php echo $args[ 'title' ][ 'label' ]; ?></a>
		</div>
		<?php if ( !empty( $args[ 'description' ] ) ) : ?>
			<div class="legal-compilation-peculiarity-text"><?php echo $args[ 'description' ]; ?></div>
		<?php endif; ?>
	</div>
	<?php if ( !empty( $args[ 'review' ][ 'href' ] ) ) : ?>
		<div class="legal-compilation-review">
			<a href="<?php echo $args[ 'review' ][ 'href' ]; ?>" class="compilation-review-link"><?php echo $args[ 'review' ][ 'label' ]; ?></a>
		</div>
	<?php endif; ?>
	<a href="<?php echo $args[ 'button' ][ 'href' ]; ?>" <?php echo BilletMain::render_nofollow( $args[ 'button' ][ 'nofollow' ] ); ?> class="legal-compilation-button check-oops"><?php echo $args[ 'button' ][ 'label' ]; ?></a>
</div>
<?php if ( !empty( $args[ 'description-full' ] ) ) : ?>
	<div class="billet-footer">
		<p class="footer-tnc-info" data-text="<?php echo $args[ 'description-full' ]; ?>">
			tnc text
			<?php if ( ! in_array( $args[ 'bonus-href' ], [ '#', '' ] ) ) : ?>
				<a href="<?php echo $args[ 'bonus-href' ]; ?>" class="footer-tnc-link" <?php echo BilletMain::render_nofollow( $args[ 'bonus' ][ 'nofollow' ] ); ?>><?php echo $args[ 'footer-tnc' ][ 'link' ]; ?> </a>
			<?php endif; ?>
		</p>
		<span class="billet-footer-control" data-default="<?php echo $args[ 'button-tnc' ]; ?>">Read more</span>
	</div>
<?php endif; ?>