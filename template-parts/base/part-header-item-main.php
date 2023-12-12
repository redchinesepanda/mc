<?php if ( !empty( $args ) ) : ?>
	<div class="menu-item <?php echo $args[ 'class' ]; ?>">
		<a class="item-title" href="<?php echo $args[ 'href' ]; ?>" <?php echo $args[ 'data' ]; ?>><?php echo $args[ 'title' ]; ?></a>
		<?php if ( !empty( $args[ 'groups' ] ) ) : ?>
			<div class="sub-menu">
				<?php foreach( $args[ 'groups' ] as $item ) : ?>
					<?php echo BaseHeader::render_group( $item ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php if ( !empty( $args[ 'children' ] ) ) : ?>
			<div class="sub-menu">
				<?php foreach( $args[ 'children' ] as $item ) : ?>
					<?php echo BaseHeader::render_item( $item ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>