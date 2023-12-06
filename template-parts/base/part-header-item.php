<?php if ( !empty( $args ) ) : ?>
	<div class="menu-item <?php echo $args[ 'class' ]; ?>">
		<a class="item-title" href="<?php echo $args[ 'href' ]; ?>" data-text-default="<?php echo $args[ 'class' ]; ?>"><?php echo $args[ 'title' ]; ?></a>
		<?php if ( !empty( $args[ 'children' ] ) ) : ?>
			<div class="sub-menu">
				<?php foreach( $args[ 'children' ] as $item ) : ?>
					<?php echo BaseHeader::render_item( $item ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>