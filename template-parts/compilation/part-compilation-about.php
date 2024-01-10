<?php

// LegalDebug::debug( [
// 	'args' => $args,
// ] );

?>
<!-- Compilation About Template -->
<?php if ( !empty( $args ) ) : ?>
    <div class="compilation-about-wrapper">
        <div class="compilation-about">
            <div class="block-title-text">
                <h1><?php echo $args[ 'title' ]; ?></h1>

                <?php foreach ( $args[ 'content' ] as $item ) : ?>

                    <p class="text <?php echo $item[ 'class' ]; ?>"><?php echo $item[ 'text' ]; ?></p>

                <?php endforeach; ?>

                <span class="legal-cut-control" data-content-default="Read more" data-content-active="Hide" data-cut-set-id="0"></span>
            </div>

            <div class="block-frame">
                <img class="frame" src="https://test.match.center/wp-content/themes/thrive-theme-child/assets/img/compilation/compilation-frame-start-screen.png">
            </div>

        </div>
    </div>
<?php endif; ?>