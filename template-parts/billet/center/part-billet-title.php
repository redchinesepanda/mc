<?php

// LegalDebug::debug( [
//     'part' => 'part-billet-title.php',

//     'args' => $args,
// ] );

?>
<div class="billet-title">
    <?php if ( $args['order'] == BilletTitle::ORDER_TYPE ) : ?>
        <div class="billet-order">#<?php echo $args['index']; ?></div>
    <?php endif; ?>
    <a class="legal-title <?php echo $args['class']; ?>" href="<?php echo $args['href']; ?>"><?php echo $args['label']; ?></a>
    <?php if ( !empty( $args['rating'] ) ): ?>
        <div class="billet-title-rating"><?php echo $args['rating']; ?></div>
    <?php endif; ?>
    <?php echo BilletAchievement::render_achievement( $args ); ?>
</div>