<?php if ( !empty( $args[ 'items' ] ) ) : ?>
	<div class="legal-bonus-categories">
		<!-- новый тег для swiper -->
		<div class="swiper">
			<!-- новый тег для swiper -->
			<div class="swiper-wrapper">
				<?php foreach ( $args[ 'items' ] as $item ) : ?>
					<?php if ( !empty( $item[ 'anchor' ] ) ) : ?>
						<a class="bonus-categories-item bonus-categories-item-<?php echo $item[ 'id' ]; ?> swiper-slide" href="<?php echo $item[ 'href' ]; ?>"><?php echo $item[ 'label' ]; ?></a>
					<?php else: ?>
						<span class="bonus-categories-item bonus-categories-item-<?php echo $item[ 'id' ]; ?> swiper-slide"><?php echo $item[ 'label' ]; ?></span>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php endif;?>