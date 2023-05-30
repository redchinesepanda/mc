<?php

// LegalDebug::debug( [
// 	'$args' => $args,
// ] );

?>
<?php if ( !empty( $args ) ) : ?>
	<div class="legal-footer">
		<?php if ( !empty( $args[ 'items' ] ) ) : ?>
			<div class="footer-menu">
				<?php foreach( $args[ 'items' ] as $item ) : ?>
					<?php echo BaseFooter::render_item( $item ); ?>
				<?php endforeach; ?>
				<div class="menu-item-end">
					<?php foreach( $args[ 'end' ] as $item ) : ?>
						<?php echo BaseFooter::render_item( $item ); ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="footer-logo">
			<a class="logo-item" href="/">
				<img src="/wp-content/themes/thrive-theme-child/assets/img/base/header/mc-logo.png" width="213" height="21" alt="Match.Center UK" />
			</a>
		</div>
		<div class="footer-copy">
			<?php echo $args[ 'copy' ][ 'year' ]; ?> <?php echo $args[ 'copy' ][ 'company' ]; ?> © <?php echo $args[ 'copy' ][ 'reserved' ]; ?>.
		</div>
		<?php echo WPMLLangSwitcher::render(); ?>
		<div class="footer-text">
			<?php foreach( $args[ 'text' ] as $text ) : ?>
				<p><?php echo $text; ?></p>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>