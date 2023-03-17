<?php

require_once( Template::LEGAL_PATH . '/lib/BilletTitle.php' );

require_once( Template::LEGAL_PATH . '/lib/BilletList.php' );

require_once( Template::LEGAL_PATH . '/lib/BilletBonus.php' );

// echo '<pre>part-billet.php:' . print_r( $args, true ) . '</pre>';

?>
<style type="text/css">
    #<?php echo $args['billet-selector']; ?> .billet-left {
        background-color: <?php echo $args['billet-color']; ?>;
    }
</style>
<div id="<?php echo $args['billet-selector']; ?>" class="billet">
    <div class="billet-left">
        <a href="<?php echo $args['billet-url'] ?>" rel="nofollow">
            <img src="<?php echo $args['featured-image'] ?>" alt="<?php echo $args['billet-title'] ?>">
        </a>
        <a href="<?php echo $args['billet-url'] ?>">Review</a>
    </div>
    <div class="billet-center">
        <?php BilletTitle::render(); ?>
        <?php BilletList::render(); ?>
    </div>
    <div class="billet-right">
        <?php BilletBonus::render(); ?>
    </div>
    <?php // BilletSpoiler::render(); ?>
    <div class="billet-footer">
        <?php echo $args['billet-description'] ?>
    </div>
</div>