<?php

// LegalDebug::debug( [
//     'part' => 'part-billet-title-new.php',

//     'args' => $args,
// ] );

?>
<div class="billet-title">
    <a class="legal-logo <?php echo $args['logo']['logo']['class']; ?> check-oops" href="<?php echo $args['logo']['logo']['href']; ?>" <?php echo BilletMain::render_nofollow( $args['logo'][ 'logo' ][ 'nofollow' ] ); ?>>
        <img src="<?php echo $args['logo']['logo']['src'] ?>" alt="<?php echo $args['logo']['alt'] ?>" />
    </a>
    <div class="title-data">
        <?php if ( $args[ 'title' ]['order'] == BilletTitle::ORDER_TYPE ) : ?>
            <div class="billet-order">#<?php echo $args[ 'title' ]['index']; ?></div>
        <?php endif; ?>
        <a class="legal-title <?php echo $args[ 'title' ]['class']; ?> check-oops" href="<?php echo $args[ 'title' ]['href']; ?>" <?php echo BilletMain::render_nofollow( $args[ 'title' ][ 'nofollow' ] ); ?>><?php echo $args[ 'title' ]['label']; ?></a>
        <?php if ( !empty( $args[ 'title' ]['rating'] ) ): ?>
            <div class="billet-title-rating"><?php echo $args[ 'title' ]['rating']; ?></div>
        <?php endif; ?>
        <?php if ( !empty( $args['logo']['review']['href'] ) ) : ?>
            <a class="legal-review <?php echo $args['logo']['review']['class']; ?> <?php echo $args['logo']['review']['font']; ?>" href="<?php echo $args['logo']['review']['href']; ?>"><?php echo $args['logo']['review']['label']; ?></a>
        <?php endif; ?>
    </div>
    <?php //echo BilletAchievement::render_achievement( $args ); ?>
</div>