<?php

// LegalDebug::debug( [
// 	'args' => $args,
// ] );

?>
<div class="legal-compilation-bonus <?php echo $args[ 'selector' ]; ?> font-<?php echo $args[ 'billet-logo' ][ 'review' ][ 'font' ]; ?>" style="background-color: <?php echo $args[ 'color' ]; ?>;">
	<div class="legal-compilation-logo">
		<a class="<?php echo $args[ 'billet-logo' ][ 'logo' ][ 'class' ]; ?> check-oops" href="<?php echo $args[ 'billet-logo' ][ 'logo' ][ 'href' ]; ?>" rel="nofollow" target="_blank" draggable="false">
			<img src="<?php echo $args[ 'billet-logo' ][ 'logo' ][ 'src' ]; ?>" alt="William Hill" draggable="false">
		</a>
	</div>
	<div class="legal-compilation-peculiarity">
		<div class="legal-compilation-peculiarity-bonys">
			<a href="<?php echo $args[ 'title' ][ 'href' ]; ?>" rel="nofollow" target="_blank" class="legal-compilation-peculiarity-bonys underline peculiarity-bonys-link" draggable="false"><?php echo $args[ 'title' ][ 'label' ]; ?></a>
		</div>
		<?php if ( !empty( $args[ 'bonus' ][ 'description' ] ) ) : ?>
			<div class="legal-compilation-peculiarity-text"><?php echo $args[ 'bonus' ][ 'description' ]; ?></div>
		<?php endif; ?>
	</div>
	<?php if ( !empty( $args[ 'billet-logo' ][ 'review' ][ 'href' ] ) ) : ?>
		<div class="legal-compilation-review">
			<a href="<?php echo $args[ 'billet-logo' ][ 'review' ][ 'href' ]; ?>" draggable="false" class="underline compilation-review-link"><?php echo $args[ 'billet-logo' ][ 'review' ][ 'label' ]; ?></a>
		</div>
	<?php endif; ?>
	<a href="<?php echo $args[ 'billet-right' ][ 'play' ][ 'href' ]; ?>" rel="nofollow" target="_blank" class="legal-compilation-button" draggable="false"><?php echo $args[ 'billet-right' ][ 'play' ][ 'label' ]; ?></a>
</div>