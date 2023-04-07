<?php if ( !empty( $args['settings']['title']['image'] ) ) : ?>
    <style type="text/css">
        .compilation-<?php echo $args['settings']['id']; ?> .compilation-title {
            background-image: url( '<?php echo $args['settings']['title']['image']; ?>' );
        }
    </style>
<?php endif; ?>
<div class="legal-compilation compilation-<?php echo $args['settings']['id']; ?>">
    <?php CompilationMain::render_attention( $args['settings']['attention'], CompilationMain::POSITION_ABOVE ); ?>
    <?php if ( !empty( $args['settings']['title']['text'] ) ) : ?>
        <div class="compilation-title  <?php echo $args['settings']['title']['class']; ?>">
            <?php echo $args['settings']['title']['text']; ?>
        </div>
    <?php endif; ?>
    <?php CompilationMain::render_attention( $args['settings']['attention'], CompilationMain::POSITION_BELOW ); ?>
    <?php foreach( $args['billets'] as $billet ) : ?>
        <?php BilletMain::render( $billet ); ?>
    <?php endforeach; ?>
    <?php CompilationMain::render_attention( $args['settings']['attention'], CompilationMain::POSITION_BOTTOM ); ?>
</div>