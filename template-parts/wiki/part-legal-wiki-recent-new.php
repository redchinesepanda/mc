<div class="legal-wiki-recent fixed">
    <span class="wiki-recent-title title-of-sidebar"><?php echo $args[ 'title' ]; ?></span>
    <div class="wiki-recent-list block-with-articles">
		<?php foreach ( $args[ 'items' ] as $item ) : ?>
			<div class="recent-list-item">
				<a href="<?php echo $item[ 'href' ]; ?>" class="list-item-title legal-sidebar-articles"><?php echo $item[ 'title' ]; ?></a>
				<span class="list-item-date"><?php echo $item[ 'published' ]; ?></span>
			</div>
		<?php endforeach; ?>
    </div>
</div>