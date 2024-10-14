<?php

// LegalDebug::debug( [
//     'args' => $args,
// ] );

?>
<?php if ( !empty( $args[ 'title' ] ) ) : ?>
    <div class="review-about-wrapper <?php echo $args[ 'class' ]; ?>">
        <div class="review-about <?php echo $args[ 'font' ]; ?> <?php echo $args[ 'class' ]; ?>">
            <div class="about-center">
                <?php if ( !empty( $args[ 'achievement' ] ) && empty( $args['mode'] ) ) : ?>
                    <div class="about-achievement">
                        <div class="achievement-item">
                            <?php if ( !empty( $args[ 'achievement' ][ 'tooltip' ] ) ) : ?>
                                <div class="achievement-tooltip-background">
                                    <div class="achievement-tooltip"><span class="achievement-tooltip-close"></span><?php echo $args[ 'achievement' ][ 'tooltip' ]; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <span class="achievement-name">
                                <?php if ( !empty( $args[ 'achievement' ][ 'image' ] ) ) : ?>
                                <img class="achievement-image" src="<?php echo $args[ 'achievement' ][ 'image' ]; ?>" width="18" height="18" alt="<?php echo $args[ 'achievement' ][ 'name' ]; ?>">
                                <?php endif; ?>
                                <?php echo $args[ 'achievement' ][ 'name' ]; ?>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="about-logo"></div>
                <?php if ( empty( $args[ 'mode' ] ) ) : ?>  
                    <div class="about-data">
                        <h1><?php echo $args[ 'title' ]; ?></h1>
                        <?php if( !empty( $args[ 'rating' ][ 'value' ] ) ) : ?>
                            <div class="about-rating"><?php echo $args[ 'rating' ][ 'label' ]; ?> - <?php echo $args[ 'rating' ][ 'value' ]; ?></div>
                        <?php endif; ?>
                        <?php if( !empty( $args[ 'afillate' ][ 'description' ] ) ) : ?>
                            <span class="legal-afillate-description"><?php echo $args[ 'afillate' ][ 'description' ]; ?></span>
                            <?php if ( !empty( $args[ 'logo-items' ] ) ) : ?>
                                <div class="footer-logo">
                                    <?php foreach( $args[ 'logo-items' ] as $logo ) : ?>
                                        <a class="logo-item" href="<?php echo $logo[ 'href' ]; ?>" target="_blank" rel="nofollow noreferrer">
                                            <!-- <img class="<?php echo $logo[ 'class' ]; ?>" src="<?php echo $logo[ 'src' ]; ?>" width="<?php echo $logo[ 'width' ]; ?>" height="<?php echo $logo[ 'height' ]; ?>" alt="<?php echo $logo[ 'alt' ]; ?>"  loading="lazy"> -->
                                            <img class="<?php echo $logo[ 'class' ]; ?>" src="<?php echo $logo[ 'src' ]; ?>" width="auto" height="24" alt="<?php echo $logo[ 'alt' ]; ?>"  loading="lazy"></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ( $args[ 'mode' ] == ReviewAbout::MODE[ 'mini' ] ) : ?>    
                    <div class="about-button">
                        <a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="legal-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>