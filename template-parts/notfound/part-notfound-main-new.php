<div class="page404">
	<div class="svg-before-text-block">
		<div class="svg-oops-smile"></div>
		<h1 class="block-groups_title"><?php echo $args[ 'title' ]; ?></h1>
	</div>
	<p><?php echo $args[ 'description' ]; ?></p>
	<div class="menu-avaible-404">
		<?php foreach( $args[ 'items' ] as $item ) : ?>
			<a class="menu-item" href="<?php echo $item[ 'href' ]; ?>" target="_blank"><?php echo $item[ 'label' ]; ?></a>
		<?php endforeach; ?>
	</div>
</div>
