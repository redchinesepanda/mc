<?php if( !empty( $args[ 'title' ] ) ) : ?>
    <?php if( empty( $args['mode'] ) ) : ?>
        <!-- <style type="text/css">
            .review-about,
            .legal-highlight {
                background-color: <?php echo $args['background']; ?>;
            }

            .review-about .about-logo {
                background-image: url( '<?php echo $args['logo']; ?>' );
            }
        </style> -->
    <?php endif; ?>
    <div class="review-about <?php echo $args[ 'font' ]; ?>">
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
            <div class="review-bonus-title"><?php echo $args[ 'bonus' ]; ?></div>
            <?php if( empty( $args['mode'] ) ) : ?>
                <div class="review-bonus-description"><?php echo $args[ 'description' ]; ?></div>
            <?php endif; ?>
        </div>
        <div class="about-right">
            <a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="legal-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
        </div>
    </div>
<?php endif; ?>