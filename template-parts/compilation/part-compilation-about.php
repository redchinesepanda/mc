<?php

// LegalDebug::debug( [
// 	'args' => $args,
// ] );

?>
<!-- Compilation About Template -->
<?php if ( !empty( $args ) ) : ?>
<div class="legal-section-main-screen">
    <div class="legal-main-screen-wrapper">
        <div class="legal-main-screen">
            <div class="block-title-text">
                <h1><?php echo $args[ 'title' ]; ?></h1>

				<?php foreach ( $args[ 'content' ] as $item ) : ?>

                	<p class="text <?php echo $item[ 'class' ]; ?>"><?php echo $item[ 'text' ]; ?></p>

				<?php endforeach; ?>

                <span class="legal-cut-control" data-content-default="Read more" data-content-active="Hide" data-cut-set-id="0"></span>
            </div>

            <div class="block-frame">
                <img class="frame" src="img/frame-1.png">
            </div>

        </div>
    </div>
</div>
<?php endif; ?>