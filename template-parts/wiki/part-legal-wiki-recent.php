<div class="legal-wiki-recent fixed">
    <span class="title-of-sidebar"><?php echo $args[ 'title' ]; ?></span>
    <div class="block-with-articles">
		<?php foreach ( $args[ 'items' ] as $item ) : ?>
        	<a href="<?php echo $item[ 'href' ]; ?>" class="legal-sidebar-articles"><?php echo $item[ 'title' ]; ?></a>
		<?php endforeach; ?>
    </div>
</div>