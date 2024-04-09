<?php

LegalDebug::debug( [
    'args' => $args,
] );

?>
<?php if ( !empty( $args ) ) : ?>
    <div class="lang-switcher">
        <div class="lang-current lang-item <?php echo $args[ 'active' ][ 'class' ]; ?>">
            <div class="lang-title"><?php echo $args[ 'active' ][ 'title' ]; ?></div>
            <?php if ( $args[ 'active' ][ 'suffix' ] ) : ?>
                <a class="lang-title-suffix" href="<?php echo $args[ 'active' ][ 'href' ]; ?>"><?php echo $args[ 'active' ][ 'suffix' ]; ?></a>
            <?php endif; ?>
        </div>
        <div id="lang-menu-1" class="menu-avaible">
            <?php if ( !empty( $args[ 'languages' ] ) ) : ?>
                <?php foreach( $args[ 'languages' ] as $lang ) : ?>
                    <a class='lang-avaible lang-item' href="<?php echo $lang[ 'href' ]; ?>" target="_blank">
                        <div class="lang-image locale-<?php echo $lang[ 'id' ]; ?>"></div>
                        <div class="lang-title">
                            <?php echo $lang[ 'title' ]; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div> 
<?php endif; ?>