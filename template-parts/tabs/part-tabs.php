<div class="legal-tabs">
    <?php if ( !empty( $args ) ) : ?>
    
        <div class="legal-tab-menu">
            <?php foreach( $args as $key => $arg ) : ?>
                <div class="legal-tab-title legal-title-<?php echo $key; ?>">
                    <?php echo $arg[ 'label' ]; ?>
                </div>
            <?php endforeach;?>
        </div>
        <div class="legal-tab-display">
            <?php foreach( $args as $key => $arg ) : ?>
                <div class="legal-tab-content legal-content-<?php echo $key; ?>">
                    <?php CompilationMain::render( $arg[ 'compilation' ] ); ?>
                </div>
            <?php endforeach;?>
        </div>
    <?php else : ?>
        <?php echo $arg[ 'empty' ]; ?>
    <?php endif; ?>
</div>

