<?php if( !empty( $args[ 'title' ] ) ) : ?>
    <div class="review-about-wrapper <?php echo $args[ 'class' ]; ?>">
        <div class="review-about <?php echo $args[ 'font' ]; ?> <?php echo $args[ 'class' ]; ?>">
            <div class="about-center">
                <div class="about-logo"></div>
                <div class="about-data">
                    <?php if( empty( $args['mode'] ) ) : ?>
                        <h1><?php echo $args[ 'title' ]; ?></h1>
                    <?php endif; ?>
                    <?php if( empty( $args['mode'] ) && !empty( $args[ 'rating' ][ 'value' ] ) ) : ?>
                        <div class="about-rating"><?php echo $args[ 'rating' ][ 'label' ]; ?> - <?php echo $args[ 'rating' ][ 'value' ]; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="about-right">
                <?php if( !empty( $args['bonus'][ 'name' ] ) ) : ?>
                    <div class="review-bonus-title"><?php echo $args[ 'bonus' ][ 'name' ]; ?></div>
                <?php endif; ?>
                <a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="legal-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
                <?php if( empty( $args['mode'] ) && !empty( $args[ 'bonus' ][ 'description' ] ) ) : ?>
                    <div class="review-bonus-description legal-cut-item" data-cut-set-id="0"><?php echo $args[ 'bonus' ][ 'description' ]; ?></div>
                <?php endif; ?>
                <?php if( empty( $args['mode'] ) && !empty( $args[ 'bonus' ][ 'description' ] ) ) : ?>
                    <span class="legal-cut-control" data-content-default="Show T&C" data-content-active="Hide T&C" data-cut-set-id="0">Show T&C</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>