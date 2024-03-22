<?php if( !empty( $args ) ) : ?>
	<div class="legal-offers-compilation">
		<!-- новый тег для swiper -->
		<div class="swiper">
			<!-- новый тег для swiper -->
			<div class="swiper-wrapper">
				<?php foreach ( $args as $item_id => $item ) : ?>
					<a href="<?php echo $item[ 'href' ]; ?>" class="offers-compilation-item offers-compilation-item-<?php echo $item_id; ?> swiper-slide"><?php echo $item[ 'label' ]; ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php endif; ?>