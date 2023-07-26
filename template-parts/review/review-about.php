<?php if( !empty( $args[ 'title' ] ) ) : ?>
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
            <?php if( !empty( $args['bonus'] ) ) : ?>
                <div class="review-bonus-title"><?php echo $args[ 'bonus' ]; ?></div>
            <?php endif; ?>
            <?php if( empty( $args['mode'] ) && !empty( $args[ 'description' ] ) ) : ?>
                <div class="review-bonus-description"><?php echo $args[ 'description' ]; ?></div>
            <?php endif; ?>
        </div>
        <div class="about-right">
            <a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="legal-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
            <?php if( !empty( $args[ 'afillate' ][ 'description' ] ) ) : ?>
                <div class="legal-afillate-description"><?php echo $args[ 'afillate' ][ 'description' ]; ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>