<?php if ( !empty( $args ) ) : ?>
	<div class="legal-header-wrapper">
		<div class="legal-header">
			<a class="legal-logo" href="<?php echo $args[ 'href' ]; ?>">
				<!-- <img src="/wp-content/themes/thrive-theme-child/assets/img/base/header/mc-logo.png" width="213" height="21" alt="Match.Center"> -->
				<picture>
            		<source srcset="/wp-content/themes/thrive-theme-child/assets/img/base/header/header-logo-mc-mobile.svg" alt="Match.Center" media="(max-width: 767px)">
            		<img src="/wp-content/themes/thrive-theme-child/assets/img/base/header/header-logo-mc-desktop.svg" alt="Match.Center">
        		</picture>
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
	</div>
<?php endif; ?>