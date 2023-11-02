<?php

// LegalDebug::debug( [
// 	'load_template' => 'part-legal-forecast-preview.php',

// 	'args' => $args,
// ] );

?>
<?php foreach( $args[ 'items' ] as $id => $item ) : ?>
	.legal-forecast-list legal-forecast-block-<?php echo $item[ 'id' ]; ?> .block-prewiew {
		background-image: url('<?php echo $item[ 'preview' ][ 'src' ] ?>');
	}
<?php endforeach; ?>