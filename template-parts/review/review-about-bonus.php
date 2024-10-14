<?php

// LegalDebug::debug( [
//     'template' => 'review-about-bonus.php',

//     'args' => $args,
// ] );

?>
<?php if( !empty( $args[ 'title' ] ) ) : ?>
    <div class="about-right">
        <?php if( !empty( $args[ 'bonus' ][ 'name' ] ) ) : ?>
            <div class="review-bonus-title"><?php echo $args[ 'bonus' ][ 'name' ]; ?></div>
        <?php endif; ?>
        <a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="legal-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
        <?php if( empty( $args[ 'mode' ] ) && !empty( $args[ 'bonus' ][ 'description' ] ) ) : ?>
            <div class="review-bonus-description legal-cut-item <?php echo $args[ 'tnc-class' ] ?>" data-cut-set-id="0"><p class="bonus-description-text"><?php echo $args[ 'bonus' ][ 'description' ]; ?></p></div>
        <?php endif; ?>
        <?php if( empty( $args[ 'mode' ] ) && !empty( $args[ 'bonus' ][ 'description' ] ) ) : ?>
            <span class="legal-cut-control" data-review-default="<?php echo $args[ 'text' ][ 'show' ]; ?>" data-review-active="<?php echo $args[ 'text' ][ 'hide' ]; ?>" data-cut-set-id="0"></span>
        <?php endif; ?>
        <?php if ( ! empty( $args[ 'afillate' ][ 'stats' ] ) ) : ?>
            <div class="review-bonus-stats">
                <span>License</span><span><?php echo $args[ 'afillate' ][ 'stats' ][ 'license' ]; ?></span>
                <span>Regulator</span><span><?php echo $args[ 'afillate' ][ 'stats' ][ 'regulator' ]; ?></span>
                <span>Date Founded</span><span><?php echo $args[ 'afillate' ][ 'stats' ][ 'date-founded' ]; ?></span>
                <span>Apps</span><span><?php echo $args[ 'afillate' ][ 'stats' ][ 'apps' ]; ?></span>
                <span>Min. Deposit</span><span><?php echo $args[ 'afillate' ][ 'stats' ][ 'min-deposit' ]; ?></span>
                <span>Margin</span><span><?php echo $args[ 'afillate' ][ 'stats' ][ 'margin' ]; ?></span>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>