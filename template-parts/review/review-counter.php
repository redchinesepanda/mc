<div class="review-counter-info">
	<div class="info-logo">
		<img src="/wp-content/uploads/betvictor-logo-white-e1651661939629-300x49.png" alt="BetVictor" width="" height="" />
	</div>
	<div class="info-rating"><?php echo $args[ 'title' ]; ?> - <?php echo $args[ 'rating' ]; ?></div>
</div>
<div class="review-counter-set">
	<?php foreach( $args[ 'items' ] as $item ) : ?>
		<div class="set-item" >
			<div class="set-item-info">
				<div class="item-value"><?php echo $item[ 'value' ]; ?></div>
				<div class="item-label"><?php echo $item[ 'label' ]; ?></div>
			</div>
		</div>
	<?php endforeach; ?>
</div>