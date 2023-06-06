<?php

LegalDebug::debug( [
	'args' => $args,
] );

?>
<?php if ( !empty( $args ) ) : ?>
	<div class="menu-item">
		<a class="item-title" href="<?php echo $args[ 'href' ]; ?>">
			<?php echo $args[ 'title' ]; ?>
		</a>
		<?php if ( !empty( $args[ 'children' ] ) ) : ?>
			<div class="item-children">
				<?php foreach( $args[ 'children' ] as $item ) : ?>
					<?php echo BaseFooter::render_item( $item ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>