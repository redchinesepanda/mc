<?php

LegalDebug::debug( [
	'args' => $args,
] );

?>
<div class="legal-tabs-mini item-<?php echo $args[ 'id' ]; ?>">
	<style type="text/css">
		legal-tabs-mini item-<?php echo $args[ 'id' ]; ?> .tabs-mini-title {
			background-image: url( '<?php echo $args['url']; ?>' );
		}
	</style>
	<div class="tabs-mini-title"><?php echo $args[ 'title' ]; ?></div>
	<div class="tabs-mini-description"><?php echo $args[ 'description' ]; ?></div>
	<div class="tabs-mini-items">

	</div>
	<div class="tabs-mini-button">
		<a href="<?php echo $args[ 'button' ][ 'href' ]; ?>" class="tabs-mini-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $args[ 'button' ][ 'label' ]; ?></a>
	</div>
	
</div>