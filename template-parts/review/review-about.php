<?php if( !empty( $args ) ) : ?>
    <style type="text/css">
        .review-about {
            background-color: <?php echo $args['background']; ?>;
        }

        .review-about .about-logo {
            background-image: url( '<?php echo $args['logo']; ?>' );
        }
    </style>
    <div class="review-about">
        <div class="about-left">
            <div class="about-logo"></div>
            <div class="about-rating"><?php echo $args[ 'rating' ]; ?></div>
        </div>
        <div class="about-center">
            <h1><?php echo $args[ 'title' ]; ?></h1>
            <h3><?php echo $args[ 'bonus' ]; ?></h3>
            <p><?php echo $args[ 'description' ]; ?></p>
        </div>
        <div class="about-right">
        <a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="legal-afillate" style="" target="_blank" rel="nofollow"><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
        </div>
    </div>
<?php endif; ?>