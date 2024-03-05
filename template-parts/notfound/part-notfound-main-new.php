<div class="legal-notfound">
	<div class="svg-before-text-block">
		<div class="svg-oops-notfound"></div>
		<h1 class="notfound-title"><?php echo $args[ 'title' ]; ?></h1>
	</div>
	<p class="notfound-description"><?php echo $args[ 'description' ]; ?></p>
	<div class="menu-notfound">
		<?php foreach( $args[ 'items' ] as $item ) : ?>
			<a class="menu-item" href="<?php echo $item[ 'href' ]; ?>" target="_blank"><?php echo $item[ 'label' ]; ?></a>
		<?php endforeach; ?>
	</div>
</div>