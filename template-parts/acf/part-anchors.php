<div><?php echo $args[ 'title' ] ?></div>
<?php if ( !empty( $args[ 'items' ] ) ) : ?>
	<table>
		<th>
			<td><?php echo $args[ 'id' ] ?></td>
			<td><?php echo $args[ 'label' ] ?></td>
		</th>
		<?php foreach( $args[ 'items' ] as $item ) : ?>
			<tr>
				<td><?php echo $item[ 'id' ] ?></td>
				<td><?php echo $item[ 'label' ] ?></td>
			</tr>
		<?php endforeach; ?>
	<table>
<?php endif; ?>