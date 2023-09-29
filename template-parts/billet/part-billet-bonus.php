<?php

LegalDebug::debug( [
	'args' => $args,
] );

?>
<div class="legal-compilation-bonus <?php echo $args[ 'selector' ]; ?>" style="background-color: <?php echo $args[ 'color' ]; ?>;">
	<div class="legal-compilation-logo">
		<a class="<?php echo $args[ 'billet-logo' ][ 'logo' ][ 'class' ]; ?> check-oops" href="<?php echo $args[ 'billet-logo' ][ 'logo' ][ 'href' ]; ?>" rel="nofollow" target="_blank" draggable="false">
			<img src="<?php echo $args[ 'billet-logo' ][ 'logo' ][ 'src' ]; ?>" alt="William Hill" draggable="false">
		</a>
	</div>
	<div class="legal-compilation-peculiarity">
		<div class="legal-compilation-peculiarity-bonys">
			<a href="/go/william-hill-uk/" rel="nofollow" target="_blank" class="legal-compilation-peculiarity-bonys underline" draggable="false">William Hill: PayPal Betting Site with the Best Football Coverage</a>
		</div>
		<div class="legal-compilation-peculiarity-text">
			18+ To receive 2 x £10 free bets a new user must make a bet of at least £10 qualifying bet on any sport at odds of 1/2 or greater. Only the first single or accumulator bets count.
		</div>
	</div>
	<div class="legal-compilation-review">
		<a href="<?php echo $args[ 'billet-logo' ][ 'review' ][ 'href' ]; ?>" draggable="false" class="underline"><?php echo $args[ 'billet-logo' ][ 'review' ][ 'label' ]; ?></a>
	</div>
	<a href="<?php echo $args[ 'billet-right' ][ 'play' ][ 'href' ]; ?>" rel="nofollow" target="_blank" class="legal-compilation-button" draggable="false"><?php echo $args[ 'billet-right' ][ 'play' ][ 'label' ]; ?></a>
</div>