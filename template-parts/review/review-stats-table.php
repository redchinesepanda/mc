<?php if( !empty( $args ) ) : ?>
	<style id="review-stats" type="text/css">
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
	<table>
		<tbody>
			<?php foreach ( $args as $item ) : ?>
				<tr>
					<td><?php echo $item[ 'title' ]; ?></td>
					<td><?php echo $item[ 'value' ]; ?></td>
					<td><?php echo $item[ 'description' ]; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>