<div class="legal-billet-mega item-<?php echo $args[ 'id' ] ?> legal-<?php echo $args[ 'mode' ] ?>">
	<div class="billet-mega">
		<div class="billet-mega-about">
			<div class="mega-about-logo">
				<img src="<?php echo $args['logo']; ?>" width="70" height="70" alt="<?php echo $args[ 'name' ] ?>" loading="lazy">
			</div>
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
			<?php if( ! $args[ 'no-controls' ] ) : ?>
				<a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="mega-about-afillate check-oops" <?php echo BilletMain::render_nofollow( $args[ 'afillate' ][ 'nofollow' ] ); ?>><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
			<?php endif; ?>
			
			<?php if( !empty( $args[ 'author' ] ) ) : ?>
				<?php if( !empty( $args[ 'author' ][ 'items' ] ) ) : ?>
					<div class="mega-about-links">
						<?php foreach( $args[ 'author' ][ 'items' ] as $item ) : ?>
							<a class="social-links <?php echo $item[ 'class' ]; ?>" href="<?php echo $item[ 'url' ]; ?>"></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="billet-mega-content">
			<?php if( !$args[ 'no-controls' ] ) : ?>
				<<?php echo $args[ 'title' ][ 'tag' ]; ?> class="mega-content-title"><?php echo $args[ 'title' ][ 'text' ] ?></<?php echo $args[ 'title' ][ 'tag' ]; ?>>
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
		<div class="billet-mega-tnc <?php echo $args[ 'tnc-class' ] ?>">
			<p class="mega-tnc-info" data-text="<?php echo $args[ 'tnc' ] ?>">
				<?php if ( ! in_array( $args[ 'afillate' ][ 'href' ], [ '#', '' ] ) ) : ?>
					<a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="mega-tnc-link" <?php echo BilletMain::render_nofollow( $args[ 'afillate' ][ 'nofollow' ] ); ?>><?php echo $args[ 'title-tnc' ] ?> </a>
				<?php endif; ?>
			</p>
			<span class="billet-mega-tnc-control" data-default="<?php echo $args[ 'button-read-tnc' ]; ?>"></span>
		</div>
	<?php endif; ?>
</div>