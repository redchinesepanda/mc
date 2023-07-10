<?php if( !empty( $args ) ) : ?>
	<button class="offers-arrow offers-arrow-prev">&#8249;</button>
  	<button class="offers-arrow offers-arrow-next">&#8250;</button>
  	<div class="legal-other-offers" id="legal-other-offers">
		<?php foreach ( $args as $item_id => $item ) : ?>
			<div class="offers-item offers-item-<?php echo $item_id; ?>">
				<div class="item-bonus <?php echo $item[ 'font' ]; ?>"><?php echo $item[ 'bonus' ]; ?></div>
				<div class="item-logo"></div>
				<a href="<?php echo $item[ 'afillate' ][ 'href' ]; ?>" class="item-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $item[ 'afillate' ][ 'text' ]; ?></a>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>