<div class="legal-compilation-bonus <?php echo $args[ 'selector' ]; ?> font-<?php echo $args[ 'font' ]; ?>" style="background-color: <?php echo $args[ 'color' ]; ?>;">
	<div class="legal-compilation-logo">
		<a class="<?php echo $args[ 'logo' ][ 'class' ]; ?> check-oops" href="<?php echo $args[ 'logo' ][ 'href' ]; ?>" <?php echo BilletMain::render_nofollow( $args[ 'logo' ][ 'nofollow' ] ); ?>>
			<img src="<?php echo $args[ 'logo' ][ 'src' ]; ?>" alt="<?php echo $args[ 'logo' ][ 'alt' ]; ?>" width="138" height="45">
		</a>
	</div>
	<div class="legal-compilation-peculiarity">
		<div class="legal-compilation-peculiarity-bonys">
			<a href="<?php echo $args[ 'title' ][ 'href' ]; ?>" <?php echo BilletMain::render_nofollow( $args[ 'title' ][ 'nofollow' ] ); ?> class="legal-compilation-peculiarity-bonys underline peculiarity-bonys-link"><?php echo $args[ 'title' ][ 'label' ]; ?></a>
		</div>
		<?php if ( !empty( $args[ 'description' ] ) ) : ?>
			<div class="legal-compilation-peculiarity-text"><?php echo $args[ 'description' ]; ?></div>
		<?php endif; ?>
	</div>
	<?php if ( !empty( $args[ 'review' ][ 'href' ] ) ) : ?>
		<div class="legal-compilation-review">
			<a href="<?php echo $args[ 'review' ][ 'href' ]; ?>" class="underline compilation-review-link"><?php echo $args[ 'review' ][ 'label' ]; ?></a>
		</div>
	<?php endif; ?>
	<a href="<?php echo $args[ 'button' ][ 'href' ]; ?>" <?php echo BilletMain::render_nofollow( $args[ 'button' ][ 'nofollow' ] ); ?> class="legal-compilation-button check-oops"><?php echo $args[ 'button' ][ 'label' ]; ?></a>
</div>