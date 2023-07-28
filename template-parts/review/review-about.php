<?php if( !empty( $args[ 'title' ] ) ) : ?>
    <div class="review-about-wrapper <?php echo $args[ 'class' ]; ?>">
        <div class="review-about <?php echo $args[ 'font' ]; ?> <?php echo $args[ 'class' ]; ?>">
            <div class="about-left">
                <div class="about-logo"></div>
                <?php if( empty( $args['mode'] ) && !empty( $args[ 'rating' ][ 'value' ] ) ) : ?>
                    <div class="about-rating"><?php echo $args[ 'rating' ][ 'label' ]; ?> - <?php echo $args[ 'rating' ][ 'value' ]; ?></div>
                <?php endif; ?>
            </div>
            <div class="about-center">
                <?php if( empty( $args['mode'] ) ) : ?>
                    <h1><?php echo $args[ 'title' ]; ?></h1>
                <?php endif; ?>
                <?php if( empty( $args['achievement'] ) ) : ?>
                    <?php if( !empty( $args['bonus'][ 'name' ] ) ) : ?>
                        <div class="review-bonus-title"><?php echo $args[ 'bonus' ][ 'name' ]; ?></div>
                    <?php endif; ?>
                    <?php if( empty( $args['mode'] ) && !empty( $args[ 'bonus' ][ 'description' ] ) ) : ?>
                        <div class="review-bonus-description"><?php echo $args[ 'bonus' ][ 'description' ]; ?></div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="about-right">
                <a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="legal-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
                <?php if( !empty( $args[ 'afillate' ][ 'description' ] ) ) : ?>
                    <div class="legal-afillate-description"><?php echo $args[ 'afillate' ][ 'description' ]; ?></div>
                <?php endif; ?>
            </div>
            <?php if( !empty( $args['achievement'] ) && empty( $args['mode'] ) ) : ?>
                <div class="about-achievement">
                    <div class="achievement-bonus">
                        <a href="<?php echo $args[ 'achievement' ][ 'href' ]; ?>" class="achievement-bonus-link check-oops" style="" target="_blank" rel="nofollow"><?php echo $args[ 'achievement' ][ 'bonus' ]; ?></a>
                    </div>
                    <div class="achievement-name">
                        <span class="achievement-bonus-link"><?php echo $args[ 'achievement' ][ 'term' ]; ?></span>
                    </div>
                    <div class="achievement-app">
                        <a href="<?php echo $args[ 'achievement' ][ 'href' ]; ?>" class="achievement-bonus-link check-oops" style="" target="_blank" rel="nofollow"><?php echo $args[ 'achievement' ][ 'app' ]; ?></a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>