<?php if ( !empty( $args ) ) : ?>
	<div class="legal-footer-wrapper">
		<div class="legal-footer <?php echo $args[ 'class' ]; ?>">
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
			<?php if ( !empty( $args[ 'logo' ] ) ) : ?>
				<div class="footer-logo">
					<?php foreach( $args[ 'logo' ] as $logo ) : ?>
						<?php if ( $logo[ 'href' ] == '#' ) : ?>
							<img class="<?php echo $logo[ 'class' ]; ?> no-link" src="<?php echo $logo[ 'src' ]; ?>" width="<?php echo $logo[ 'width' ]; ?>" height="<?php echo $logo[ 'height' ]; ?>" alt="<?php echo $logo[ 'alt' ]; ?>"  loading="lazy">
						<?php else : ?>
							<a class="logo-item" href="<?php echo $logo[ 'href' ]; ?>" target="_blank" rel="nofollow noreferrer">
								<img class="<?php echo $logo[ 'class' ]; ?>" src="<?php echo $logo[ 'src' ]; ?>" width="<?php echo $logo[ 'width' ]; ?>" height="<?php echo $logo[ 'height' ]; ?>" alt="<?php echo $logo[ 'alt' ]; ?>"  loading="lazy">
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<div class="footer-copy">
				<?php echo $args[ 'copy' ][ 'year' ]; ?> <?php echo $args[ 'copy' ][ 'company' ]; ?> © <?php echo $args[ 'copy' ][ 'reserved' ]; ?>.
			</div>
			<?php echo WPMLLangSwitcher::render(); ?>
			<div class="footer-text">
				<?php echo $args[ 'text' ]; ?>
			</div>
		</div>
	</div>
<?php endif; ?>