<?php if ( !empty( $args[ 'class' ] ) ) : ?>
    <?php if ( $args[ 'class' ] == BilletAchievement::TYPE[ 'image' ] ) : ?>
        .<?php echo $args[ 'selector' ]; ?> {
            background-color: <?php echo $args[ 'color' ]; ?>;
            background-image: url('<?php echo $args[ 'image' ]; ?>');
        }
    <?php endif; ?>
<?php endif; ?>