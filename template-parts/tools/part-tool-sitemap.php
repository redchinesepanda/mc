<?php if ( !empty( $args[ 'settings' ][ 'title' ] ) ) : ?>
	<div class="legal-sitemap-item">
		<span class="sitemap-item-title"><?php echo $args[ 'settings' ][ 'title' ]; ?></span>
		<?php foreach( $args[ 'items' ] as $item ) : ?>
			<a href="<?php echo $item[ 'href' ]; ?>"><?php echo $item[ 'label' ]; ?></a>
		<?php endforeach; ?>
	</div>
<?php else : ?>
	<?php echo ToolSitemap::render_items( $args[ 'items' ] ); ?>
<?php endif; ?>