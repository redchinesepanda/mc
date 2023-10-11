<div class="legal-compilation compilation-<?php echo $args['settings']['id']; ?>">
    <?php echo CompilationMain::render_attention( $args['settings']['attention'], CompilationMain::POSITION[ 'above' ] ); ?>
    <?php if ( !empty( $args['settings']['title']['text'] ) ) : ?>
        <div class="compilation-title  <?php echo $args['settings']['title']['class']; ?>"><?php echo $args['settings']['title']['text']; ?></div>
    <?php endif; ?>
    <?php if ( !empty( $args[ 'settings' ][ 'date' ][ 'value' ] ) ) : ?>
        <div class="compilation-date"><?php echo $args[ 'settings' ][ 'date' ][ 'label' ]; ?>: <?php echo $args[ 'settings' ][ 'date' ][ 'value' ]; ?></div>
    <?php endif; ?>
    <?php echo CompilationMain::render_attention( $args['settings']['attention'], CompilationMain::POSITION[ 'below' ] ); ?>
    <?php foreach( $args['billets'] as $billet ) : ?>
        <?php echo BilletMain::render_billet( $billet ); ?>
    <?php endforeach; ?>
    <?php echo CompilationMain::render_attention( $args['settings']['attention'], CompilationMain::POSITION[ 'bottom' ] ); ?>
</div>