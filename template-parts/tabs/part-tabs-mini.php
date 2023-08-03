<?php

// LegalDebug::debug( [
// 	'args' => $args,
// ] );

?>
<div class="legal-tabs-mini item-<?php echo $args[ 'id' ]; ?>">
	<style type="text/css">
		.legal-tabs-mini.item-<?php echo $args[ 'id' ]; ?> .tabs-mini-title {
			background-image: url( '<?php echo $args['url']; ?>' );
		}
		<?php foreach ( $args[ 'items' ] as $item ) : ?>
			.legal-tabs-mini.item-<?php echo $args[ 'id' ]; ?> .tabs-mini-item .item-<?php echo $item[ 'id' ]; ?> .mini-item-logo {
				background-image: url( '<?php echo $args['url']; ?>' );
			}
		<?php endforeach; ?>
	</style>
	<div class="tabs-mini-title"><?php echo $args[ 'title' ]; ?></div>
	<div class="tabs-mini-description"><?php echo $args[ 'description' ]; ?></div>
	<div class="tabs-mini-items">
		<?php foreach ( $args[ 'items' ] as $item ) : ?>
			<div class="tabs-mini-item item-<?php echo $item[ 'id' ]; ?>">
				<div class="mini-item-logo">
					<a href="<?php echo $item[ 'logo' ][ 'href' ]; ?>" class="mini-item-logo-afillate check-oops" style="" target="_blank" rel="nofollow"></a>
				</div>
				<?php if ( !empty( $item[ 'bonus' ] ) ) : ?>
					<div class="mini-item-bonus"><?php echo $item[ 'bonus' ]; ?></div>
				<?php endif; ?>
				<?php if ( !empty( $item[ 'profit' ] ) ) : ?>
					<div class="mini-item-profit"><?php echo $item[ 'profit' ]; ?></div>
				<?php endif; ?>
				<div class="mini-item-button">
					<a href="<?php echo $item[ 'href' ]; ?>" class="mini-item-button-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $item[ 'button' ][ 'label' ]; ?></a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="tabs-mini-button">
		<a href="<?php echo $args[ 'button' ][ 'href' ]; ?>" class="tabs-mini-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $args[ 'button' ][ 'label' ]; ?></a>
	</div>
</div>