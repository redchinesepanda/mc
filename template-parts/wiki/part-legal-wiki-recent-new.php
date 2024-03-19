<div class="legal-wiki-recent fixed">
    <span class="title-of-sidebar"><?php echo $args[ 'title' ]; ?></span>
    <div class="block-with-articles">
		<?php foreach ( $args[ 'items' ] as $item ) : ?>
			<div class="recent-item">
				<a href="<?php echo $item[ 'href' ]; ?>" class="legal-sidebar-articles recent-item-title"><?php echo $item[ 'title' ]; ?></a>
				<span class="recent-item-date"><?php echo $item[ 'published' ]; ?></span>
			</div>
		<?php endforeach; ?>
    </div>
</div>