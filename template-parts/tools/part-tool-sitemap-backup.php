<?php if ( !$args[ 'url' ] ) : ?>
	<ul class="legal-sitemap">
		<?php foreach( $args[ 'items' ] as $item ) : ?>
			<li>
				<a href="<?php echo $item[ 'href' ]; ?>">
					<?php echo $item[ 'label' ]; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php else : ?>
	<div class="legal-sitemap">
		<?php foreach( $args[ 'items' ] as $item ) : ?>
			<span><?php echo $item[ 'href' ]; ?></span><br />
		<?php endforeach; ?>
	</div>
<?php endif; ?>