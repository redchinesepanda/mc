<?php if ( !empty( $args ) ) : ?>
    <div class="legal-tab-menu">
        <?php foreach( $args as $key => $arg ) : ?>
            <div class="legal-tab-title legal-title-<?php echo $key; ?>">
                <?php echo $arg['title']; ?>
            </div>
        <?php endforeach;?>
    </div>
    <div class="legal-tab-display">
        <?php foreach( $args as $key => $arg ) : ?>
            <div class="legal-tab-content legal-content-<?php echo $key; ?>">
                <?php CompilationMain::render( $arg ); ?>
            </div>
        <?php endforeach;?>
    </div>
<?php endif; ?>

