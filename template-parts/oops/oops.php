<div class="legal-oops-background">
	<div class="legal-oops">
		<div class="oops-title"><?php echo $args[ 'title' ]; ?></div>
		<div class="oops-description"><?php echo $args[ 'description' ]; ?></div>
		<?php foreach( $args[ 'items' ] as $item ) : ?>
			<div class="oops-item">
				<img class="item-image" src="<?php echo $args[ 'src' ]; ?>" width="88" height="29" />
				<a class="item-button" href="<?php echo $item[ 'href' ]; ?>">
					<?php echo $args[ 'label' ]; ?>
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</div>