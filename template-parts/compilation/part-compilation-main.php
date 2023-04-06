<?php if ( !empty( $args['title']['image'] ) ) : ?>
    <style type="text/css">
        #compilation-<?php echo $args['id']; ?> .compilation-title {
            background-image: url( '<?php echo $args['title']['image']; ?>' );
        }
    </style>
<?php endif; ?>
<div class="legal-compilation <?php echo $args['achievement']; ?> compilation-<?php echo $args['id']; ?>">
    <?php if ( !empty( $args['title']['text'] ) ) : ?>
        <div class="compilation-title">
            <?php echo $args['title']['text']; ?>
        </div>
    <?php endif; ?>
    <?php foreach( $args['billets'] as $billet ) : ?>
        <?php BilletMain::render( $billet ); ?>
    <?php endforeach; ?>
    <?php if ( !empty( $args['attention']['text'] ) ) : ?>
        <div class="compilation-attention">
            <?php echo $args['attention']['text']; ?>
        </div>
    <?php endif; ?>
    <?php if ( !empty( $args['all']['text'] ) ) : ?>
        <a class="compilation-all" href="<?php echo $args['all']['url']; ?>">
            <?php echo $args['all']['text']; ?>
        </a>
    <?php endif; ?>
</div>