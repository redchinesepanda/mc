<?php if ( !empty( $args['settings']['title']['image'] ) ) : ?>
    <style type="text/css">
        .compilation-<?php echo $args['settings']['id']; ?> .compilation-title-image {
            background-image: url( '<?php echo $args['settings']['title']['image']; ?>' );
        }
    </style>
<?php endif; ?>
<div class="legal-compilation <?php echo $args['achievement']; ?> compilation-<?php echo $args['settings']['id']; ?>">
    <?php if ( !empty( $args['settings']['title']['text'] ) ) : ?>
        <?php if ( !empty( $args['settings']['title']['image'] ) ) : ?>
            <div class="compilation-title-image"></div>
        <?php endif; ?>
        <div class="compilation-title-text">
            <?php echo $args['settings']['title']['text']; ?>
        </div>
    <?php endif; ?>
    <?php foreach( $args['billets'] as $billet ) : ?>
        <?php BilletMain::render( $billet ); ?>
    <?php endforeach; ?>
    <?php if ( !empty( $args['settings']['attention']['text'] ) ) : ?>
        <div class="compilation-attention">
            <?php echo $args['settings']['attention']['text']; ?>
        </div>
    <?php endif; ?>
    <?php if ( !empty( $args['settings']['all']['text'] ) ) : ?>
        <a class="compilation-all" href="<?php echo $args['settings']['all']['url']; ?>">
            <?php echo $args['settings']['all']['text']; ?>
        </a>
    <?php endif; ?>
</div>