<div class="review-counter-info">
	<div class="info-logo"></div>
	<div class="info-rating"><?php echo $args[ 'title' ]; ?></div>
</div>
<div class="review-counter-set">
	<?php foreach( $args[ 'items' ] as $id => $item ) : ?>
		<div class="set-item-wrapper">
			<div class="set-item set-item-<?php echo $id; ?>" >
				<div class="set-item-info">
					<div class="item-value"><?php echo $item[ 'value' ]; ?></div>
				</div>
			</div>
			<div class="item-label set-item-<?php echo $id; ?>"><?php echo $item[ 'label' ]; ?></div>
		</div>
	<?php endforeach; ?>
</div>
<?php if ( !empty( $args[ 'items_overall' ] ) ) : ?>
	<div class="review-counter-overall">
		<?php foreach( $args[ 'items_overall' ] as $overall_id => $overall_item ) : ?>
			<div class="set-item-wrapper">
				<div class="set-item set-item-<?php echo $args[ 'amount' ] + $overall_id; ?>" >
					<div class="set-item-info">
						<div class="item-value"><?php echo $overall_item[ 'value' ]; ?></div>
					</div>
				</div>
				<div class="item-label"><?php echo $overall_item[ 'label' ]; ?></div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="review-counter-footer">
		<a href="<?php echo $args[ 'button' ][ 'href' ]; ?>" class="review-counter-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $args[ 'button' ][ 'text' ]; ?></a>
	</div>
<?php endif; ?>