<?php

require_once( Template::LEGAL_PATH . '/lib/BilletAchievement.php' );

?>
<div class="billet-title">
    <h3 class="billet-title-text">
        <a href="<?php echo $args['billet-url'] ?>">
            <?php echo $args['billet-title-text'] ?>
        </a>
    </h3>
    <div class="billet-title-rating"><?php echo $args['billet-title-rating'] ?></div>
    <?php BilletAchievement::render(); ?>
</div>