<?php

// LegalDebug::debug( [
// 	'load_template' => 'part-legal-forecast-preview.php',

// 	'args' => $args,
// ] );

?>
<div class="legal-forecast-list">
	<?php foreach( $args[ 'items' ] as $item ) : ?>
		<div class="legal-forecast-block">
			<a href="<?php echo $item[ 'href' ] ?>" class="block-prewiew chimaev-kosta">
				<span><?php echo $item[ 'date' ] ?></span>
			</a>
			<a href="<?php echo $item[ 'href' ] ?>" class="legal-forecast-block-title underline"><?php echo $item[ 'title' ] ?></a>
		</div>
	<?php endforeach; ?>
</div>