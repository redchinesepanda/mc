<div class="billet-item">
    <div id="<?php echo $args['selector']; ?>" class="billet">
        <div class="billet-left">
            <?php echo BilletLogo::render_logo( $args[ 'logo' ] ); ?>
        </div>
        <div class="billet-center">
            <?php echo BilletTitle::render( $args[ 'title' ] ); ?>

            <?php echo BilletDescription::render( $args ); ?>

            <?php echo BilletList::render( $args ); ?>
        </div>
        <div class="billet-right">
            <?php BilletRight::render( $args ); ?>
        </div>
    </div>
    <?php BilletSpoiler::render( $args ); ?>
    <div class="billet-footer">
        <?php echo $args[ 'bonus' ][ 'description-full' ] ?>
    </div>
</div>