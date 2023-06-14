<ul class="legal-sitemap">
	<?php foreach( $args as $item ) : ?>
		<li>
			<a href="<?php echo $item[ 'href' ]; ?>">
				<?php echo $item[ 'label' ]; ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>