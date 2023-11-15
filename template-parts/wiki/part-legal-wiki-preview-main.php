<?php

// LegalDebug::debug( [
// 	'template-part' => 'part-legal-wiki-preview.php',

// 	'args' => $args,
// ] );

?>
<div class="block-article-item block-article-item-<?php echo $args[ 'settings' ][ 'id' ] ?> ">
	<div class="block-item-title">
		<?php if ( !empty( $args[ 'settings' ][ 'href' ] ) ) : ?>
			<a href="<?php echo $args[ 'settings' ][ 'href' ] ?>" class="underline"><?php echo $args[ 'settings' ][ 'title' ] ?></a>
		<?php else : ?>
			<span class="underline"><?php echo $args[ 'settings' ][ 'title' ] ?></span>
		<?php endif; ?>
	</div>
	<div class="list-article">
		<?php foreach( $args[ 'items' ] as $item ) : ?>
			<a href="<?php echo $item[ 'href' ] ?>" class="article article-<?php echo $item[ 'id' ] ?>"><?php echo $item[ 'title' ] ?></a>
		<?php endforeach; ?>
	</div>
</div>