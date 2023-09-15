<div class="legal-bonus-summary">
	<?php foreach ( $args as $key => $item ) : ?>
		<div class="bonus-summary-bookmaker">
			<div class="summary-<?php echo $key; ?>-label"><?php echo $item[ 'label' ]; ?></div>
			<div class="summary-<?php echo $key; ?>-value"><?php echo $item[ 'value' ]; ?></div>
		</div>
	<?php endforeach; ?>
</div>