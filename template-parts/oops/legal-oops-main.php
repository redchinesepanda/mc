<div class="legal-oops-background">
	<div class="legal-oops">
		<div class="oops-title"><?php echo $args[ 'title' ]; ?></div>
		<div class="oops-description"><?php echo $args[ 'description' ]; ?></div>
		<?php foreach( $args[ 'items' ] as $item ) : ?>
			<div class="oops-item">
				<div class="item-image-wrapper">
					<img class="item-image" src="<?php echo $item[ 'src' ]; ?>" width="<?php echo $item[ 'width' ]; ?>" height="<?php echo $item[ 'height' ]; ?>" alt="<?php echo $item[ 'alt' ]; ?>">
				</div>
				<?php if( !empty( $item[ 'bonus-label' ] ) ) : ?>
					<div class="item-bonus-wrapper">
						<a class="item-bonus" href="<?php echo $item[ 'href' ]; ?>"><?php echo $item[ 'bonus-label' ]; ?></a>
					</div>
				<?php endif; ?>
				<div class="item-button-wrapper">
					<a class="item-button" href="<?php echo $item[ 'href' ]; ?>"><?php echo $args[ 'label' ]; ?></a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>