<?php

// LegalDebug::debug([
// 	'template' => 'part-header-group-main.php',

// 	'args' => $args,
// ]);

?>
<?php if ( !empty( $args ) ) : ?>
	<div class="menu-group">
		<?php foreach( $args as $item ) : ?>
			<?php echo BaseHeader::render_item( $item ); ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>