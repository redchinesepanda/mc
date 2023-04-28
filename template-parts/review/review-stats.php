<?php if( !empty( $args ) ) : ?>
	<style type="text/css">
		<?php foreach ( $args as $id => $item ) : ?>
			.stats-item-<?php echo $id; ?> .item-value {
				width: <?php echo $item[ 'width' ]; ?>%;
			}
		<?php endforeach; ?>
    </style>
	<div class="review-stats">
		<?php foreach ( $args as $id => $item ) : ?>
			<div class="stats-item stats-item-<?php echo $id; ?>">
				<div class="item-title"><?php echo $item[ 'title' ]; ?></div>
				<div class="item-value-wrapper">
					<div class="item-value"></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>