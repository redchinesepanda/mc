<?php echo BilletBonus::render( $args[ 'bonus' ] ); ?>
<?php if ( empty( $args[ 'license' ] ) ) : ?>
    <div class="bonus-button">
        <a class="legal-play <?php echo $args[ 'play' ][ 'class' ]; ?> check-oops" href="<?php echo $args[ 'play' ][ 'href' ]; ?>" <?php echo BilletMain::render_nofollow( $args[ 'play' ][ 'nofollow' ] ); ?>><?php echo $args[ 'play' ][ 'label' ]; ?></a>
    </div>
<?php else : ?>
    <div class="billet-license">
        <span class="billet-license-label"><?php echo $args[ 'license' ][ 'label' ]; ?></span> 
    </div>
<?php endif; ?>
<?php BilletProfit::render( $args ); ?>
<?php if ( !empty( $args[ 'bonus' ][ 'description-full' ] ) ) : ?>
    <span class="billet-footer-control" data-default="<?php echo $args[ 'footer-control' ][ 'default' ]; ?>" data-active="<?php echo $args[ 'footer-control' ][ 'active' ]; ?>">Test</span>
<?php endif; ?>
<?php BilletSpoilerButton::render( $args ); ?>