<?php BilletBonus::render( $args ); ?>
<?php if ( empty( $arg[ 'license' ] ) ) : ?>
    <div class="bonus-button">
        <a class="legal-play <?php echo $args[ 'play' ][ 'class' ]; ?> check-oops" href="<?php echo $args[ 'play' ][ 'href' ]; ?>" rel="nofollow">
            <?php echo $args[ 'play' ][ 'label' ]; ?>
        </a>
    </div>
<?php else : ?>
    <div class="billet-license">
        <span class="billet-license-label"><?php echo $args[ 'label' ]; ?></span> 
    </div>
<?php endif; ?>
<?php BilletMobile::render( $args ); ?>
<?php BilletProfit::render( $args ); ?>
<?php BilletSpoilerButton::render( $args ); ?>