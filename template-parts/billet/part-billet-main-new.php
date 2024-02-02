<div class="billet-item">
    <div id="<?php echo $args['selector']; ?>" class="billet">
        <div class="billet-center billet-main">
            <?php echo BilletTitle::render_title( $args[ 'logo' ], $args[ 'title' ] ); ?>

            <?php echo BilletDescription::render( $args ); ?>

            <?php echo BilletList::render( $args ); ?>
        </div>
        <div class="billet-right billet-bonus">
            <?php BilletRight::render( $args ); ?>
        </div>
    </div>
    <?php BilletSpoiler::render( $args ); ?>
    <div class="billet-footer"><?php echo $args[ 'bonus' ][ 'description-full' ] ?></div>
</div>