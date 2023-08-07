<div class="review-counter-info">
	<div class="info-logo"></div>
	<div class="info-rating"><?php echo $args[ 'title' ]; ?></div>
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
<?php if ( !empty( $args[ 'items_overall' ] ) ) ?>
	<div class="review-counter-overall">
		<?php foreach( $args[ 'items_overall' ] as $overall_id => $overall_item ) : ?>
			<div class="set-item set-item-<?php echo $id + 1 + $overall_id; ?>" >
				<div class="set-item-info">
					<div class="item-value"><?php echo $overall_item[ 'value' ]; ?></div>
					<div class="item-label"><?php echo $overall_item[ 'label' ]; ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>