<?php if( !empty( $args ) ) : ?>
	<style id="stats-item-set" type="text/css">
		<?php foreach ( $args as $id => $item ) : ?>
			.stats-item-<?php echo $id; ?> .item-value {
				width: <?php echo $item[ 'width' ]; ?>%;
			}
		<?php endforeach; ?>
    </style>
	<?php foreach ( $args as $id => $item ) : ?>
		<div class="stats-item stats-item-<?php echo $id; ?>">
			<div class="item-title"><?php echo $item[ 'title' ]; ?></div>
			<div class="item-value-wrapper">
				<div class="item-value"></div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>