<?php

LegalDebug::debug( $args );

?>
<div class="legal-compilation-bonus compilation-<?php echo $args['settings']['id']; ?>">
	<?php foreach( $args['billets'] as $billet ) : ?>
		<?php BilletMain::render_bonus( $billet ); ?>
	<?php endforeach; ?>
</div>