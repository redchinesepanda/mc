<div class="legal-billet-mega item-<?php echo $args[ 'id' ] ?> legal-<?php echo $args[ 'mode' ] ?>">
	<style type="text/css">
		.legal-billet-mega.item-<?php echo $args[ 'id' ] ?> .mega-about-logo {
			background-image: url( '<?php echo $args['logo']; ?>' );
		}

		.legal-billet-mega.item-<?php echo $args[ 'id' ] ?> .legal-highlight {
			background-color: <?php echo $args['background']; ?>;
		}
	</style>
	<div class="billet-mega">
		<div class="billet-mega-about">
			<div class="mega-about-logo"></div>
			<div class="mega-about-options">
				<?php if( !empty( $args[ 'name' ] ) ) : ?>
					<div class="mega-about-name"><?php echo $args[ 'name' ] ?></div>
				<?php endif; ?>
				<?php echo $args[ 'license' ]; ?>
				<?php if( !$args[ 'no-controls' ] ) : ?>
					<?php if ( !empty( $args[ 'review' ][ 'href' ] ) ) : ?>
						<a href="<?php echo $args[ 'review' ][ 'href' ]; ?>" class="mega-about-review check-oops"><?php echo $args[ 'review' ][ 'text' ]; ?></a>
					<?php endif; ?>
				<?php endif; ?>
				<?php if( !empty( $args[ 'author' ] ) ) : ?>
					<div class="mega-about-name"><?php echo $args[ 'author' ][ 'name' ] ?></div>
					<div class="mega-about-post"><?php echo $args[ 'author' ][ 'post' ] ?></div>
				<?php endif; ?>
			</div>
			<?php if( !$args[ 'no-controls' ] ) : ?>
				<a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="mega-about-afillate check-oops" <?php echo BilletMain::render_nofollow( $args[ 'afillate' ][ 'nofollow' ] ); ?>><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
			<?php endif; ?>
			
			<?php if( !empty( $args[ 'author' ] ) ) : ?>
				<?php if( !empty( $args[ 'author' ][ 'items' ] ) ) : ?>
					<div class="mega-about-links">
						<?php foreach( $args[ 'author' ][ 'items' ] as $item ) : ?>
							<a class="link-item" href="<?php echo $item[ 'url' ]; ?>">
								<img src="<?php echo $item[ 'image' ]; ?>" width="18" height="18" loading="lazy">
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="billet-mega-content">
			<?php if( !$args[ 'no-controls' ] ) : ?>
				<<?php echo $args[ 'title' ][ 'tag' ]; ?> class="mega-content-title">
					<a href="<?php echo $args[ 'title' ][ 'href' ]; ?>" class="content-title-link" <?php echo BilletMain::render_nofollow( $args[ 'title' ][ 'nofollow' ] ); ?>><?php echo $args[ 'title' ][ 'text' ] ?></a>
				</<?php echo $args[ 'title' ][ 'tag' ]; ?>>
			<?php endif; ?>
			<?php echo $args[ 'content' ]; ?>
		</div>
		<?php if( !empty( $args[ 'footer' ] ) ) : ?>
			<div class="billet-mega-footer">
				<?php echo $args[ 'footer' ] ?>
			</div>
		<?php endif; ?>
	</div> 
	<?php if( !empty( $args[ 'tnc' ] ) ) : ?>
		<div class="billet-mega-tnc">
			<p class="data-tnc" data-text="<?php echo $args[ 'tnc' ] ?>"><a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="link-tnc" <?php echo BilletMain::render_nofollow( $args[ 'afillate' ][ 'nofollow' ] ); ?>>T&C</a></p>
			<?php echo $args[ 'tnc' ] ?>
			<span class="billet-mega-tnc-control" data-default="<?php echo $args[ 'button-read-tns' ]; ?>"></span>
		</div>
	<?php endif; ?>
</div>