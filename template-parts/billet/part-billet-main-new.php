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
        <!-- <div class="billet-footer"></div> -->
        <div class="billet-footer">
            <p class="footer-tnc-info" data-text="<?php echo $args[ 'bonus' ][ 'description-full' ]; ?>"><a href="<?php echo $args[ 'href' ][ 'href' ]; ?>" class="footer-tnc-link" rel="nofollow">Full T&Cs apply </a></p>
            <!-- <?php echo $args[ 'bonus' ][ 'description-full' ]; ?> -->
            <span class="billet-footer-control" data-default="<?php echo $args[ 'footer-control' ][ 'default' ]; ?>"></span>
        </div>
    <?php endif; ?>
</div> 