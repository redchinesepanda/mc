<?php

LegalDebug::debug( [
	$args,
] );

?>
<div class="legal-oops-cookie-wrapper">
	<div class="legal-oops-cookie">
		<span class="oops-cookie-description"><?php echo $args[ 'description' ]; ?></span>
		<a class="oops-cookie-privacy" href="<?php echo $args[ 'privacy' ][ 'href' ]; ?>"><?php echo $args[ 'privacy' ][ 'label' ]; ?></a>
		<div class="oops-cookie-button"><?php echo $args[ 'label' ]; ?></div>
	</div>
</div>