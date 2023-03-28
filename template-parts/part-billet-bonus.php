<?php

require_once( Template::LEGAL_PATH . '/lib/billet/right/BilletMobile.php' );

?>
<div class="bonus-title">
    <a class="legal-bonus <?php echo $args['bonus']['class']; ?>" href="<?php echo $args['bonus']['href']; ?>" rel="nofollow">
        <?php echo $args['bonus']['label']; ?>
    </a>
</div>
<?php if ( !empty( $args['bonus']['description'] ) ): ?>
    <div class="bonus-description">
        <span><?php echo $args['bonus']['description']; ?></span>
    </div>
<?php endif; ?>
<div class="bonus-button">
    <a class="legal-play <?php echo $args['play']['class']; ?>" href="<?php echo $args['play']['href']; ?>" rel="nofollow">
        <?php echo $args['play']['label']; ?>
    </a>
</div>
<div class="bonus-mobile">
    <?php BilletMobile::render(); ?>
</div>
<?php if ( BilletSpoiler::check() ): ?>
    <div class="bonus-spoiler" data-id="<?php echo $args['spoiler']['id']; ?>">
        <span class="spoiler-open"><?php echo $args['spoiler']['open']; ?></span>
        <span class="spoiler-close"><?php echo $args['spoiler']['close']; ?></span>
    </div>
<?php endif; ?>