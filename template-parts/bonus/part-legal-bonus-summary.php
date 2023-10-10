<div class="legal-bonus-summary">
	<?php foreach ( $args as $key => $item ) : ?>
		<div class="bonus-summary-item bonus-summary-item-<?php echo $key; ?>">
			<div class="item-label item-label-<?php echo $key; ?>"><?php echo $item[ 'label' ]; ?>:</div>
			<div class="item-value item-value-<?php echo $key; ?>"><?php echo $item[ 'value' ]; ?></div>
		</div>
	<?php endforeach; ?>
</div>