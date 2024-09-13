<?php

// LegalDebug::debug( [
//     'template' => 'part-billet-main-new',

//     'args' => $args,
// ] );

?>
<div class="billet-item">
    <div id="<?php echo $args['selector']; ?>" class="billet">
        <div class="billet-center billet-main">
            <?php echo BilletTitle::render_title( $args[ 'logo' ], $args[ 'title' ], $args[ 'achievement' ], $args[ 'mobile' ] ); ?>

            <?php echo BilletDescription::render( $args ); ?>

            <?php echo BilletList::render( $args ); ?>
        </div>
        <div class="billet-right billet-bonus">
            <?php echo BilletRight::render( $args ); ?>
        </div>
    </div>
    <?php BilletSpoiler::render( $args ); ?>
    <?php if ( !empty( $args[ 'bonus' ][ 'description-full' ] ) ) : ?>
        <div class="billet-footer <?php echo $args[ 'bonus' ][ 'tnc-class' ]; ?>">
            <p class="footer-tnc-info" data-text="<?php echo $args[ 'bonus' ][ 'description-full' ]; ?>">
                <?php if ( ! in_array( $args[ 'bonus' ][ 'href' ], [ '#', '' ] ) ) : ?>
                    <a href="<?php echo $args[ 'bonus' ][ 'href' ]; ?>" class="footer-tnc-link" <?php echo BilletMain::render_nofollow( $args[ 'bonus' ][ 'nofollow' ] ); ?>><?php echo $args[ 'footer-tnc' ][ 'link' ]; ?> </a>
                <?php endif; ?>
            </p>
            <span class="billet-footer-control" data-default="<?php echo $args[ 'footer-tnc' ][ 'button' ]; ?>"></span>
        </div>
    <?php endif; ?>
</div> 