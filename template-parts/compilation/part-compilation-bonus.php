<?php

LegalDebug::debug( $args );

?>
<div class="legal-compilation-bonus compilation-<?php echo $args['settings']['id']; ?>">
	<?php foreach( $args['billets'] as $billet ) : ?>
		<?php BilletMain::render( $billet ); ?>
	<?php endforeach; ?>
</div>