<?php

// LegalDebug::debug( [
//     'part' => 'part-billet-title.php',

//     'args' => $args,
// ] );

?>
<div class="billet-title">
    <?php if ( $args[ 'title' ]['order'] == BilletTitle::ORDER_TYPE ) : ?>
        <div class="billet-order">#<?php echo $args[ 'title' ]['index']; ?></div>
    <?php endif; ?>
    <a class="legal-title <?php echo $args[ 'title' ]['class']; ?> check-oops" href="<?php echo $args[ 'title' ]['href']; ?>" <?php echo BilletMain::render_nofollow( $args[ 'title' ][ 'nofollow' ] ); ?>><?php echo $args[ 'title' ]['label']; ?></a>
    <?php if ( !empty( $args[ 'title' ]['rating'] ) ): ?>
        <div class="billet-title-rating"><?php echo $args[ 'title' ]['rating']; ?></div>
    <?php endif; ?>
    <?php //echo BilletAchievement::render_achievement( $args ); ?>
</div>