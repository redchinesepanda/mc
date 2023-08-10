<?php 

LegalDebug::debug( [
	'args' => $args,
] );

?>
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
	<pre class="legal-sitemap">
		<?php foreach( $args[ 'items' ] as $item ) : ?>
			<?php echo $item[ 'href' ]; ?>
		<?php endforeach; ?>
	</pre>
<?php endif; ?>