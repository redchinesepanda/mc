<style id="legal-author" type="text/css">
	.legal-author .author-photo {
		background-image: url( '<?php echo $args[ 'file' ]; ?>' );
	}
</style>
<div class="legal-author">
	<div class="author-photo"></div>
	<div class="author-data">
		<a href="<?php echo $args[ 'href' ]; ?>" class="author-name"><?php echo $args[ 'name' ]; ?></a>
		<div class="author-duty"><?php echo $args[ 'duty' ]; ?></div>
	</div>
</div>