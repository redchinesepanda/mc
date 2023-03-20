<?php if ( !empty( $args['url']['logo'] ) ): ?>
    <a href="<?php echo $args['url']['logo'] ?>" rel="nofollow">
<?php endif; ?>
        <img src="<?php echo $args['logo'] ?>" alt="billet logo" />
<?php if ( !empty( $args['url']['logo'] ) ): ?>
    </a>
<?php endif; ?>
<?php if ( !empty( $args['url']['review'] ) ): ?>
    <a href="<?php echo $args['url']['review'] ?>">
<?php endif; ?>
        Review
<?php if ( !empty( $args['url']['review'] ) ): ?>
    </a>
<?php endif; ?>