<?php

require_once( Template::LEGAL_PATH . '/lib/BilletLogo.php' );

require_once( Template::LEGAL_PATH . '/lib/BilletTitle.php' );

require_once( Template::LEGAL_PATH . '/lib/BilletList.php' );

require_once( Template::LEGAL_PATH . '/lib/BilletBonus.php' );

// echo '<pre>part-billet.php:' . print_r( $args, true ) . '</pre>';

?>
<style type="text/css">
    #<?php echo $args['selector']; ?> .billet-left {
        background-color: <?php echo $args['color']; ?>;
    }
</style>
<div id="<?php echo $args['selector']; ?>" class="billet">
    <div class="billet-left">
        <?php BilletLogo::render( $args['url'] ); ?>
    </div>
    <div class="billet-center">
        <?php BilletTitle::render( $args['url'] ); ?>
        <?php BilletList::render(); ?>
    </div>
    <div class="billet-right">
        <?php BilletBonus::render( $args['url'] ); ?>
    </div>
    <?php // BilletSpoiler::render(); ?>
</div>
<div class="billet-footer">
    <?php echo $args['description'] ?>
</div>