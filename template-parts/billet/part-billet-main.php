<div class="billet-item">
    <div id="<?php echo $args['selector']; ?>" class="billet">
        <div class="billet-left">
            <?php BilletLogo::render( $args ); ?>
        </div>
        <div class="billet-center">
            <?php BilletTitle::render( $args ); ?>

            <?php echo BilletDescription::render( $args ); ?>

            <?php BilletList::render( $args ); ?>
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