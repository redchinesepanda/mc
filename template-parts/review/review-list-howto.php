<?php

// LegalDebug::debug( [
// 	'template' => 'review-list-howto.php',

// 	'args' => $args,
// ] );

?>
<?php if ( ! empty( $args[ 'questions' ] ) ) : ?>
	<<?php echo $args[ 'tag' ]; ?> class="<?php echo $args[ 'class' ]; ?>">
		<?php foreach ( $args[ 'questions' ] as $question ) : ?>
			<li>
				<span class="question-title"><?php echo $question[ 'title' ]; ?></span>
				<br>
				<span class="question-content"><?php echo $question[ 'content' ]; ?></span>
			</li>
		<?php endforeach; ?>
	</<?php echo $args[ 'tag' ]; ?>>
<?php endif; ?>