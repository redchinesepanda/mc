<?php if ( !empty( $args ) ) : ?>
	<div class="menu-item <?php echo $args[ 'class' ]; ?>">
		<?php if ( $args[ 'href' ] == '#' ) : ?>
			<span class="item-title" <?php echo $args[ 'data' ]; ?>><?php echo $args[ 'title' ]; ?></span>
		<?php else : ?>
			<a class="item-title" href="<?php echo $args[ 'href' ]; ?>" <?php echo $args[ 'data' ]; ?>><?php echo $args[ 'title' ]; ?></a>
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