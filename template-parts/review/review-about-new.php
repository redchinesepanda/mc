<?php

// LegalDebug::debug( [
//     'template' => 'review-about-new.php',

//     'args' => $args,
// ] );

?>
<?php if ( !empty( $args[ 'title' ] ) ) : ?>
    <div class="review-about-wrapper <?php echo $args[ 'class' ]; ?>">
        <div class="review-about <?php echo $args[ 'font' ]; ?> <?php echo $args[ 'class' ]; ?>">
            <div class="about-center">
                <?php if ( !empty( $args[ 'achievement' ] ) && empty( $args['mode'] ) ) : ?>
                    <div class="about-achievement legal-tooltip-container">
                        <div class="achievement-item">
                            <span class="achievement-name legal-tooltip-control">
                                <?php if ( !empty( $args[ 'achievement' ][ 'image' ] ) ) : ?>
                                <img class="achievement-image" src="<?php echo $args[ 'achievement' ][ 'image' ]; ?>" width="18" height="18" alt="<?php echo $args[ 'achievement' ][ 'name' ]; ?>">
                                <?php endif; ?>
                                <?php echo $args[ 'achievement' ][ 'name' ]; ?>
                            </span>
                        </div>
                        <?php if ( !empty( $args[ 'achievement' ][ 'tooltip' ] ) ) : ?>
                            <div class="achievement-tooltip-background legal-tooltip legal-tooltip-wrapper">
                                <div class="achievement-tooltip">
                                    <!-- <span class="achievement-tooltip-close legal-tooltip-close"></span> -->
                                    <span class="achievement-tooltip-text" ><?php echo $args[ 'achievement' ][ 'tooltip' ]; ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="about-logo"></div>
                <?php if ( empty( $args[ 'mode' ] ) ) : ?>  
                    <div class="about-data">
                        <h1><?php echo $args[ 'title' ]; ?></h1>
                        <?php if( !empty( $args[ 'rating' ][ 'value' ] ) ) : ?>
                            <div class="about-rating-wrapper">
                                <div class="about-rating">
                                    <!-- <?php echo $args[ 'rating' ][ 'label' ]; ?> -  -->
                                    <?php echo $args[ 'rating' ][ 'value' ]; ?>
                                </div>
                                <div class="legal-tooltip">
                                    <span class="legal-tooltip-title"><?php echo $args[ 'text' ][ 'tooltip-rating-title' ]; ?></span>
                                    <span class="legal-tooltip-close"></span>
                                    <span class="legal-tooltip-text" data-tooltip-text="<?php echo $args[ 'text' ][ 'tooltip-text' ]; ?>">
                                        <?php if ( ! empty( $args[ 'text' ][ 'tooltip-href' ] ) ) : ?>
                                            <a href="<?php echo $args[ 'text' ][ 'tooltip-href' ]; ?>"><?php echo $args[ 'text' ][ 'tooltip-href-label' ]; ?></a>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if( !empty( $args[ 'afillate' ][ 'description' ] ) ) : ?>
                            <span class="legal-afillate-description"><?php echo $args[ 'afillate' ][ 'description' ]; ?></span>
                            <?php if ( !empty( $args[ 'logo-items' ] ) ) : ?>
                                <div class="footer-logo">
                                    <?php foreach( $args[ 'logo-items' ] as $logo ) : ?>
                                        <a class="logo-item" href="<?php echo $logo[ 'href' ]; ?>" target="_blank" rel="nofollow noreferrer">
                                            <!-- <img class="<?php echo $logo[ 'class' ]; ?>" src="<?php echo $logo[ 'src' ]; ?>" width="<?php echo $logo[ 'width' ]; ?>" height="<?php echo $logo[ 'height' ]; ?>" alt="<?php echo $logo[ 'alt' ]; ?>"  loading="lazy"> -->
                                            <img class="<?php echo $logo[ 'class' ]; ?>" src="<?php echo $logo[ 'src' ]; ?>" width="auto" height="18" alt="<?php echo $logo[ 'alt' ]; ?>"  loading="lazy"></a>
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
        <!-- <div class="review-about-info">
            <a href="<?php echo $args[ 'info' ][ 'author' ][ 'href' ]; ?>" class="info-author-href">
                <img class="info-author-file" src="<?php echo $args[ 'info' ][ 'author' ][ 'file' ]; ?>" with="24" height="24" loading="lazy">
            </a>
            <div class="about-info-checked-by">
                <span class="info-checked-by-label"><?php echo $args[ 'info' ][ 'checked-by' ][ 'label' ]; ?></span>
                <span class="info-checked-by-value"><?php echo $args[ 'info' ][ 'checked-by' ][ 'value' ][ 'name' ]; ?></span>
            </div>
            <div class="about-info-data">
                <a href="<?php echo $args[ 'info' ][ 'author' ][ 'href' ]; ?>" class="info-author-href">
                    <span  class="info-author-name"><?php echo $args[ 'info' ][ 'author' ][ 'name' ]; ?></span>
                </a>
                <div class="about-info-date"><?php echo $args[ 'info' ][ 'date' ][ 'label' ]; ?>: <?php echo $args[ 'info' ][ 'date' ][ 'value' ]; ?></div>
            </div>
        </div> -->
    </div>
<?php endif; ?>