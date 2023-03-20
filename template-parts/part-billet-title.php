<?php

require_once( Template::LEGAL_PATH . '/lib/BilletAchievement.php' );

?>
<div class="billet-title">
    <h3 class="billet-title-text">
        <a href="<?php echo $args['url']['title']; ?>">
            <?php echo $args['title']; ?>
        </a>
    </h3>
    <?php if ( !empty( $args['rating'] ) ): ?>
        <div class="billet-title-rating"><?php echo $args['rating']; ?></div>
    <?php endif; ?>
    <?php BilletAchievement::render(); ?>
</div>