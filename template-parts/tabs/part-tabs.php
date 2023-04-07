<div class="legal-tabs">
    <?php if ( !empty( $args[ 'text' ] ) ) : ?>
        <div class="legal-tabs-title">
            <?php echo $arg[ 'text' ]; ?>
        </div>
    <?php endif; ?>
    <?php if ( !empty( $args[ 'tabs' ] ) ) : ?>
        <div class="legal-tab-menu">
            <?php foreach( $args[ 'tabs' ] as $key => $arg ) : ?>
                <div class="legal-tab-title <?php echo $arg[ 'class' ]; ?>" data-content="<?php echo $key; ?>">
                    <?php echo $arg[ 'text' ]; ?>
                </div>
            <?php endforeach;?>
        </div>
        <div class="legal-tab-display">
            <?php foreach( $args[ 'tabs' ] as $key => $arg ) : ?>
                <div class="legal-tab-content legal-content-<?php echo $key; ?> <?php echo $arg[ 'class' ]; ?>">
                    <?php foreach( $arg[ 'compilations' ] as $compilation ) : ?>
                        <?php CompilationMain::render( $compilation ); ?>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>
        </div>
    <?php else : ?>
        <?php echo $args[ 'empty' ]; ?>
    <?php endif; ?>
</div>

