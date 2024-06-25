<?php

LegalDebug::debug( [
    'args' => $args,
] );

?>
<?php if ( !empty( $args ) ) : ?>
    <div class="lang-switcher">
        <div class="lang-current lang-item legal-new">
            <div class="lang-title">
                <span><?php echo $args[ 'active' ][ 'title' ]; ?></span>
            </div>
            <!-- <img class="lang-image" src="<?php echo $args[ 'active' ][ 'src' ]; ?>" width="17" height="17" alt="<?php echo $args[ 'active' ][ 'title' ]; ?>" loading="lazy"> -->
            <?php if ( !empty( $args[ 'choose-your-country' ] ) ) : ?>
                <a class="lang-title-suffix" href="<?php echo $args[ 'choose-your-country' ][ 'href' ]; ?>"><?php echo $args[ 'choose-your-country' ][ 'suffix' ]; ?></a>
            <?php endif; ?>
        </div>
        <?php if ( !empty( $args[ 'languages' ] ) ) : ?>
            <div id="lang-menu-1" class="menu-avaible">
                <?php foreach( $args[ 'languages' ] as $lang ) : ?>
                    <a class='lang-avaible lang-item' href="<?php echo $lang[ 'href' ]; ?>" target="_blank">
                        <!-- <div class="lang-image locale-<?php echo $lang[ 'id' ]; ?>"></div> -->
                        <img class="lang-image" src="<?php echo $lang[ 'src' ]; ?>" width="18" height="18" alt="<?php echo $lang[ 'title' ]; ?>" loading="lazy">
                        <div class="lang-title"><?php echo $lang[ 'title' ]; ?></div>
                    </a>
                <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div> 
<?php endif; ?>