<div class="legal-tabs">
    <?php if ( !empty( $args[ 'tabs' ] ) ) : ?>
    
        <div class="legal-tab-menu">
            <?php foreach( $args[ 'tabs' ] as $key => $arg ) : ?>
                <div class="legal-tab-title <?php echo $arg[ 'class' ]; ?>" data-content="<?php echo $key; ?>">
                    <?php echo $arg[ 'label' ]; ?>
                </div>
            <?php endforeach;?>
        </div>
        <div class="legal-tab-display">
            <?php foreach( $args[ 'tabs' ] as $key => $arg ) : ?>
                <div class="legal-tab-content legal-content-<?php echo $key; ?> <?php echo $arg[ 'class' ]; ?>">
                    <?php CompilationMain::render( $arg[ 'compilation' ] ); ?>
                </div>
            <?php endforeach;?>
        </div>
    <?php else : ?>
        <?php echo $args[ 'empty' ]; ?>
    <?php endif; ?>
</div>

