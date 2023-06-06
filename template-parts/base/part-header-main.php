<?php if ( !empty( $args ) ) : ?>
	<div class="legal-header">
		<a class="legal-logo" href="/">
			<img src="/wp-content/themes/thrive-theme-child/assets/img/base/header/mc-logo.png" width="213" height="21" alt="Match.Center UK" />
		</a>
		<div class="legal-header-control">
		</div>
		<?php if ( !empty( $args[ 'items' ] ) ) : ?>
			<div class="legal-menu">
				<?php foreach( $args[ 'items' ] as $item ) : ?>
					<?php echo BaseHeader::render_item( $item ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>