<div class="legal-billet-mega item-<?php echo $args[ 'id' ] ?> legal-<?php echo $args[ 'mode' ] ?>">
	<style type="text/css">
		.legal-billet-mega.item-<?php echo $args[ 'id' ] ?> .mega-about-logo {
			background-image: url( '<?php echo $args['logo']; ?>' );
		}

		.legal-billet-mega.item-<?php echo $args[ 'id' ] ?> .legal-highlight {
			background-color: <?php echo $args['background']; ?>;
		}
	</style>
	<div class="billet-mega-about">
		<div class="mega-about-logo"></div>
		<?php if( !$args[ 'no-controls' ] ) : ?>
			<a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="mega-about-afillate check-oops" <?php echo BilletMain::render_nofollow( $args[ 'afillate' ][ 'nofollow' ] ); ?>><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
			<?php if ( !empty( $args[ 'review' ][ 'href' ] ) ) : ?>
				<a href="<?php echo $args[ 'review' ][ 'href' ]; ?>" class="mega-about-review check-oops"><?php echo $args[ 'review' ][ 'text' ]; ?></a>
			<?php endif; ?>
		<?php endif; ?>
		<?php if( !empty( $args[ 'author' ] ) ) : ?>
			<div class="mega-about-name"><?php echo $args[ 'author' ][ 'name' ] ?></div>
			<div class="mega-about-post"><?php echo $args[ 'author' ][ 'post' ] ?></div>
			<?php if( !empty( $args[ 'author' ][ 'items' ] ) ) : ?>
				<div class="mega-about-links">
					<span class="mega-about-prefix"><?php echo $args[ 'author' ][ 'prefix' ] ?>: </span>
					<?php foreach( $args[ 'author' ][ 'items' ] as $item ) : ?>
						<a class="link-item" href="<?php echo $item[ 'url' ]; ?>">
							<img src="<?php echo $item[ 'image' ]; ?>" width="25" height="25" />
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
		<?php echo $args[ 'content' ] ?>
	</div>
	<?php if( !empty( $args[ 'footer' ] ) ) : ?>
		<div class="billet-mega-footer">
			<?php echo $args[ 'footer' ] ?>
		</div>
	<?php endif; ?>
</div>