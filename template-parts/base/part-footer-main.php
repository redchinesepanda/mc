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
			<?php foreach( $args[ 'logo' ] as $logo ) : ?>
				<a class="logo-item" href="<?php echo $logo[ 'href' ]; ?>" rel="nofollow">
					<img src="<?php echo $logo[ 'src' ]; ?>" width="<?php echo $logo[ 'width' ]; ?>" height="<?php echo $logo[ 'height' ]; ?>" alt="<?php echo $logo[ 'alt' ]; ?>" />
				</a>
			<?php endforeach; ?>
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