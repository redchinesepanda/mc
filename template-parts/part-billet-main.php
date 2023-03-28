<?php

require_once( Template::LEGAL_PATH . '/lib/BilletLogo.php' );

require_once( Template::LEGAL_PATH . '/lib/BilletTitle.php' );

require_once( Template::LEGAL_PATH . '/lib/BilletList.php' );

require_once( Template::LEGAL_PATH . '/lib/BilletBonus.php' );

require_once( Template::LEGAL_PATH . '/lib/BilletSpoiler.php' );

// echo '<pre>part-billet.php:' . print_r( $args, true ) . '</pre>';

?>
<style type="text/css">
    #<?php echo $args['selector']; ?> .billet-left {
        background-color: <?php echo $args['color']; ?>;
    }
</style>
<div id="<?php echo $args['selector']; ?>" class="billet">
    <div class="billet-left">
        <?php BilletLogo::render( $args ); ?>
    </div>
    <div class="billet-center">
        <?php BilletTitle::render( $args ); ?>
        <?php BilletList::render(); ?>
    </div>
    <div class="billet-right">
        <?php BilletBonus::render( $args ); ?>
    </div>
</div>
<?php BilletSpoiler::render( $args ); ?>
<div class="billet-footer">
    <?php echo $args['description'] ?>
</div>