<div class="legal-bonus-summary">
	<!-- новый тег для swiper -->
	<div class="swiper">
		<!-- новый тег для swiper -->
		<div class="swiper-wrapper">
			<?php foreach ( $args as $key => $item ) : ?>
				<div class="bonus-summary-item bonus-summary-item-<?php echo $key; ?> swiper-slide">
					<div class="item-label item-label-<?php echo $key; ?>"><?php echo $item[ 'label' ]; ?>:</div>
					<div class="item-value item-value-<?php echo $key; ?>"><?php echo $item[ 'value' ]; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>