<?php if ( !empty( $args[ 'settings' ][ 'title' ] ) ) : ?>
	<div class="legal-sitemap-item">
		<span class="sitemap-item-title"><?php echo $args[ 'settings' ][ 'title' ]; ?></span>
		<?php echo ToolSitemap::render_items( $args[ 'items' ] ); ?>
	</div>
<?php else : ?>
	<?php echo ToolSitemap::render_items( $args[ 'items' ] ); ?>
<?php endif; ?>