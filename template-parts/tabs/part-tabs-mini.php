<div class="legal-tabs-mini-set">
	<?php foreach ( $args as $id => $page ) : ?>
		<div class="legal-tabs-mini item-<?php echo $id; ?> <?php echo $page[ 'class' ]; ?>">
			<style id="item-<?php echo $id; ?>" type="text/css">
				.legal-tabs-mini.item-<?php echo $id; ?> .tabs-mini-title {
					background-image: url( '<?php echo $page['url']; ?>' );
				}
				<?php foreach ( $page[ 'items' ] as $item ) : ?>
					.legal-tabs-mini.item-<?php echo $id; ?> .tabs-mini-item.item-<?php echo $item[ 'id' ]; ?> .mini-item-logo-afillate {
						background-image: url( '<?php echo $item[ 'logo' ][ 'url' ]; ?>' );
					}
				<?php endforeach; ?>
			</style>
			<div class="tabs-mini-title"><?php echo $page[ 'title' ]; ?></div>
			<div class="tabs-mini-description"><?php echo $page[ 'description' ]; ?></div>
			<div class="tabs-mini-items">
				<?php foreach ( $page[ 'items' ] as $item ) : ?>
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
							<a href="<?php echo $item[ 'button' ][ 'href' ]; ?>" class="mini-item-button-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $item[ 'button' ][ 'label' ]; ?></a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="tabs-mini-button">
				<a href="<?php echo $page[ 'button' ][ 'href' ]; ?>" class="tabs-mini-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $page[ 'button' ][ 'label' ]; ?></a>
			</div>
		</div>
	<?php endforeach; ?>
</div>