<div class="legal-billet-mega item-<?php echo $args[ 'id' ] ?> <?php echo $args[ 'mode' ] ?>">
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
			<a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="mega-about-afillate check-oops" rel="nofollow"><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
			<a href="<?php echo $args[ 'review' ][ 'href' ]; ?>" class="mega-about-review check-oops" rel="nofollow"><?php echo $args[ 'review' ][ 'text' ]; ?></a>
		<?php endif; ?>
	</div>
	<div class="billet-mega-content">
		<?php if( !$args[ 'no-controls' ] ) : ?>
			<<?php echo $args[ 'title' ][ 'tag' ]; ?> class="mega-content-title"><a href="<?php echo $args[ 'title' ][ 'href' ]; ?>" class="content-title-link"><?php echo $args[ 'title' ][ 'text' ] ?></a></<?php echo $args[ 'title' ][ 'tag' ]; ?>>
		<?php endif; ?>
		<?php echo $args[ 'content' ] ?>
	</div>
	<?php if( !empty( $args[ 'footer' ] ) ) : ?>
		<div class="billet-mega-footer">
			<?php echo $args[ 'footer' ] ?>
		</div>
	<?php endif; ?>
</div>