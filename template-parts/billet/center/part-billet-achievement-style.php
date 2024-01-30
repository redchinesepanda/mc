<?php if ( array_key_exists( 'class', $args ) ) : ?>
    <?php if ( $args['class'] == BilletAchievement::TYPE_IMAGE ) : ?>
        .<?php echo $args['selector']; ?> {
            background-color: <?php echo $args['color']; ?>;
            background-image: url('<?php echo $args['image']; ?>');
        }
    <?php endif; ?>
<?php endif; ?>