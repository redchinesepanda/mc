<?php

require_once( Template::LEGAL_PATH . '/lib/BilletAchievement.php' );

?>
<div class="billet-title">
    <?php if ( !empty( $args['url']['title'] ) ): ?>
        <a class="legal-title" href="<?php echo $args['url']['title']; ?>" rel="nofollow">
    <?php endif; ?>
    <div class="billet-order">#1</div>
    <h3 class="legal-title">
        <?php echo $args['title']; ?>
    </h3>
    <?php if ( !empty( $args['url']['title'] ) ): ?>
        </a>
    <?php endif; ?>
    <?php if ( !empty( $args['rating'] ) ): ?>
        <div class="billet-title-rating"><?php echo $args['rating']; ?></div>
    <?php endif; ?>
    <?php BilletAchievement::render(); ?>
</div>