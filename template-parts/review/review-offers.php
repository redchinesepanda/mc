<?php if( !empty( $args ) ) : ?>
	<?php foreach ( $args as $item_id => $item ) : ?>
		<div class="offers-item offers-item-<?php echo $item_id; ?>">
			<div class="item-bonus <?php echo $item[ 'font' ]; ?>"><?php echo $item[ 'bonus' ]; ?></div>
			<div class="item-logo"></div>
			<a href="<?php echo $item[ 'afillate' ][ 'href' ]; ?>" class="item-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $item[ 'afillate' ][ 'text' ]; ?></a>
		</div>
	<?php endforeach; ?>
<?php endif; ?>
<section class="slider-wrapper">
	<button class="slide-arrow" id="slide-arrow-prev">&#8249;</button>
	<button class="slide-arrow" id="slide-arrow-next">&#8250;</button>
	<ul class="slides-container" id="slides-container">
		<li class="slide"></li>
		<li class="slide"></li>
		<li class="slide"></li>
		<li class="slide"></li>
	</ul>
</section>