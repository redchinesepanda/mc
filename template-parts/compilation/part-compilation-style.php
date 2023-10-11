<?php if ( !empty( $args['settings']['title']['image'] ) ) : ?>
    <style id="compilation-<?php echo $args['settings']['id']; ?>">
        .compilation-<?php echo $args['settings']['id']; ?> .compilation-title {
            background-image: url( '<?php echo $args['settings']['title']['image']; ?>' );
        }
    </style>
<?php endif; ?>