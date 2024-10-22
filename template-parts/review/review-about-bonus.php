<?php

// LegalDebug::debug( [
//     'template' => 'review-about-bonus.php',

//     'args' => $args,
// ] );

?>
<?php if( !empty( $args[ 'title' ] ) ) : ?>
    <div class="about-right">
        <div class="review-bonus-data">
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
        </div>
        <?php if ( ! empty( $args[ 'afillate' ][ 'stats' ] ) ) : ?>
            <div class="review-bonus-stats">
                <?php foreach ( $args[ 'afillate' ][ 'stats' ] as $stats_item ) : ?>
                    <div class="bonus-stats-items legal-tooltip-container">
                        <span class="stats-item-label"><?php echo $stats_item[ 'label' ]; ?></span>
                        <?php if ( ! empty( $stats_item[ 'tooltip' ] ) ) : ?>
                            <span class="stats-item-tooltip legal-tooltip-open" data-tooltip="<?php echo $stats_item[ 'tooltip' ]; ?>">
                                <div class="legal-tooltip">
                                    <span class="legal-tooltip-close"></span>
                                    <p class="legal-tooltip-text" data-tooltip-text="<?php echo $stats_item[ 'tooltip' ]; ?>"></p>
                                </div>
                            </span>
                        <?php endif; ?>
                        <span class="stats-item-value"><?php echo $stats_item[ 'value' ]; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>