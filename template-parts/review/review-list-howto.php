<?php

LegalDebug::debug( [
	'template' => 'review-list-howto.php',

	'args' => $args,
] );

?>
<span>test</span>

<?php if ( ! empty( $args[ 'questions' ] ) ) : ?>
	<ol>
		<?php foreach ( $args[ 'questions' ] as $question ) : ?>
			<li>
				<span class="question-title"><?php echo $question[ 'title' ]; ?></span>
				<span class="question-content"><?php echo $question[ 'content' ]; ?></span>
			</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>