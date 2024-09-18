<div class="legal-compilation-bonus">
	<div class="compilation-bonus-main <?php echo $args[ 'selector' ]; ?> font-<?php echo $args[ 'font' ]; ?>">
		<div class="legal-compilation-logo">
			<?php if ( $args[ 'logo' ][ 'href' ] == '#' ) : ?>
				<img src="<?php echo $args[ 'logo' ][ 'src' ]; ?>" class="legal-logo-picture" alt="<?php echo $args[ 'logo' ][ 'alt' ]; ?>" width="48" height="48" loading="lazy">
			<?php else : ?>
				<a class="legal-logo-link<?php echo $args[ 'logo' ][ 'class' ]; ?>" href="<?php echo $args[ 'title' ][ 'href' ]; ?>" <?php echo BilletMain::render_nofollow( $args[ 'logo' ][ 'nofollow' ] ); ?>>
					<img src="<?php echo $args[ 'logo' ][ 'src' ]; ?>" class="legal-logo-picture" alt="<?php echo $args[ 'logo' ][ 'alt' ]; ?>" width="48" height="48" loading="lazy">
				</a>
			<?php endif; ?>
		</div>
		<div class="legal-compilation-peculiarity">
			<div class="legal-compilation-peculiarity-bonus">
				<?php echo $args[ 'title' ][ 'label' ]; ?>
			</div>
			<?php if ( !empty( $args[ 'description' ] ) ) : ?>
				<div class="legal-compilation-peculiarity-text"><?php echo $args[ 'description' ]; ?></div>
			<?php endif; ?>
		</div>
		<a href="<?php echo $args[ 'button' ][ 'href' ]; ?>" <?php echo BilletMain::render_nofollow( $args[ 'button' ][ 'nofollow' ] ); ?> class="legal-compilation-button check-oops"><?php echo $args[ 'button' ][ 'label' ]; ?></a>
	</div>
	<?php if ( !empty( $args[ 'description-full' ] ) ) : ?>
		<div class="compilation-bonus-footer <?php echo $args[ 'tnc-class' ] ?>">
			<p class="footer-tnc-info" data-text="<?php echo $args[ 'description-full' ]; ?>">
				<?php if ( ! in_array( $args[ 'bonus-href' ], [ '#', '' ] ) ) : ?>
					<a href="<?php echo $args[ 'bonus-href' ]; ?>" class="footer-tnc-link" rel="nofollow"><?php echo $args[ 'link-tnc' ]; ?></a>
				<?php endif; ?>
			</p>
			<span class="compilation-footer-control" data-default="<?php echo $args[ 'button-tnc' ]; ?>"></span>
		</div>
	<?php endif; ?>
</div>