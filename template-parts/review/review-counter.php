<div class="review-counter-info">
	<div class="info-logo"></div>
	<div class="info-rating"><?php echo $args[ 'title' ]; ?> - <?php echo $args[ 'rating' ]; ?></div>
</div>
<div class="review-counter-set">
	<?php foreach( $args[ 'items' ] as $id => $item ) : ?>
		<div class="set-item set-item-<?php echo $id; ?>" >
			<div class="set-item-info">
				<div class="item-value"><?php echo $item[ 'value' ]; ?></div>
				<div class="item-label"><?php echo $item[ 'label' ]; ?></div>
			</div>
		</div>
	<?php endforeach; ?>
</div>