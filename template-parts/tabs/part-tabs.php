<div class="legal-tabs">
    <?php if ( !empty( $args[ 'text' ] ) ) : ?>
        <div class="legal-tabs-title">
            <?php echo $args[ 'text' ]; ?>
        </div>
    <?php endif; ?>
    <?php if ( !empty( $args[ 'tabs' ] ) ) : ?>
        <div class="legal-tab-menu">
            <style id="legal-tab-menu" type="text/css">
                <?php foreach( $args[ 'tabs' ] as $key => $arg ) : ?>
                    <?php if ( !empty( $arg[ 'image' ] ) ) : ?>
                        .<?php echo $arg[ 'class' ]; ?> {
                            background-image: url( '<?php echo $arg['image']; ?>' );
                        }
                    <?php endif; ?>
                <?php endforeach;?>
            </style>
            <?php foreach( $args[ 'tabs' ] as $key => $arg ) : ?>
                <div class="legal-tab-title <?php echo $arg[ 'active' ]; ?> <?php echo $arg[ 'class' ]; ?>" data-content="<?php echo $key; ?>">
                    <?php echo $arg[ 'text' ]; ?>
                </div>
            <?php endforeach;?>
        </div>
        <div class="legal-tab-display">
            <?php foreach( $args[ 'tabs' ] as $key => $arg ) : ?>
                <div class="legal-tab-content legal-content-<?php echo $key; ?> <?php echo $arg[ 'active' ]; ?>">
                    <?php foreach( $arg[ 'compilations' ] as $compilation ) : ?>
                        <?php echo CompilationMain::render_compilation( $compilation ); ?>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>
        </div>
    <?php else : ?>
        <?php echo $args[ 'empty' ]; ?>
    <?php endif; ?>
    <?php if ( !empty( $args['description'] ) ) : ?>
        <div class="legal-tabs-description">
            <?php echo $args['description'] ?>
        </div>
    <?php endif; ?>
    <?php if ( !empty( $args['link']['text'] ) ) : ?>
        <a class="legal-tabs-link" href="<?php echo $args['link']['url']; ?>">
            <?php echo $args['link']['text']; ?>
        </a>
    <?php endif; ?>
</div>

