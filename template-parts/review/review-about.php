<?php

LegalDebug::debug( [
    'args' => $args, 
] );

?>
<?php if( !empty( $args[ 'about-title' ] ) ) : ?>
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
            <?php if( empty( $args['mode'] ) ) : ?>
                <div class="about-rating"><?php echo $args[ 'rating' ]; ?></div>
            <?php endif; ?>
        </div>
        <div class="about-center">
            <?php if( empty( $args['mode'] ) ) : ?>
                <h1><?php echo $args[ 'title' ]; ?></h1>
            <?php endif; ?>
            <h3><?php echo $args[ 'bonus' ]; ?></h3>
            <?php if( empty( $args['mode'] ) ) : ?>
                <p><?php echo $args[ 'description' ]; ?></p>
            <?php endif; ?>
        </div>
        <div class="about-right">
        <a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="legal-afillate" style="" target="_blank" rel="nofollow"><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
        </div>
    </div>
<?php endif; ?>