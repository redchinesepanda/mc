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
        </div>
    </div>
<?php endif; ?>