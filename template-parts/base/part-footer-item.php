<?php if ( !empty( $args ) ) : ?>
	<div class="menu-item <?php echo $args[ 'class' ]; ?>">
		<?php if ( $args[ 'href' ] == '#' ) : ?>
			<span class="item-title" ><?php echo $args[ 'title' ]; ?></span>
		<?php elseif ( $args[ 'href' ] == 'https://www.ukclubsport.com/' ) : ?>
			<a class="item-title odds" href="<?php echo $args[ 'href' ]; ?>" rel="nofollow noreferrer" target="_blank"><?php echo $args[ 'title' ]; ?></a>
		<?php else : ?>
			<a class="item-title" href="<?php echo $args[ 'href' ]; ?>"><?php echo $args[ 'title' ]; ?></a>
		<?php endif; ?>
		<?php if ( !empty( $args[ 'children' ] ) ) : ?>
			<div class="item-children">
				<?php foreach( $args[ 'children' ] as $item ) : ?>
					<?php echo BaseFooter::render_item( $item ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>