<?php

LegalDebug::debug( [
	'args' => $args,
] );

?>
<!-- <?php if ( !empty( $args ) ) : ?>
	<div class="legal-header">
		<a class="legal-logo" href="/">
			<img src="/wp-content/themes/thrive-theme-child/assets/img/base/header/mc-logo.png" width="213" height="21" alt="Match.Center UK" />
		</a>
		<div class="legal-header-control">
		</div>
		<?php echo $args; ?>
	</div>
<?php endif; ?> -->
<?php if ( !empty( $args ) ) : ?>
	<div class="legal-header">
		<a class="legal-logo" href="/">
			<img src="/wp-content/themes/thrive-theme-child/assets/img/base/header/mc-logo.png" width="213" height="21" alt="Match.Center UK" />
		</a>
		<div class="legal-header-control">
		</div>
		<?php if ( !empty( $args[ 'items' ] ) ) : ?>
			<div class="header-menu">
				<?php foreach( $args[ 'items' ] as $item ) : ?>
					<?php echo BaseFooter::render_item( $item ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>