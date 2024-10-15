<?php

LegalDebug::debug( [
	'tempalte' => 'review-stats.php',

	'args' => $args,
] );

?>
<?php if( !empty( $args ) ) : ?>
	<?php foreach ( $args as $id => $item ) : ?>
		<div class="stats-item stats-item-<?php echo $id; ?>">
			<div class="item-data">
				<div class="item-title"><?php echo $item[ 'title' ]; ?></div>
				<div class="item-description"><?php echo $item[ 'description' ]; ?></div>
			</div>
			<div class="item-value-wrapper" data-value="<?php echo $item[ 'value' ]; ?>">
				<div class="item-value"></div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>