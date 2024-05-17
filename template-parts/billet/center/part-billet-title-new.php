<?php

// LegalDebug::debug( [
//     'part' => 'part-billet-title-new.php',

//     'args' => $args,
// ] );

?>
<div class="billet-title">
    <?php echo BilletAchievement::render( $args[ 'achievement' ] ); ?>
    <a class="legal-logo <?php echo $args['logo']['logo']['class']; ?> check-oops" href="<?php echo $args['logo']['logo']['href']; ?>" <?php echo BilletMain::render_nofollow( $args['logo'][ 'logo' ][ 'nofollow' ] ); ?>>
        <img src="<?php echo $args['logo']['logo']['src'] ?>" alt="<?php echo $args['logo']['logo']['alt'] ?>" loading="lazy">
    </a>
    <div class="title-data">
        <div class="title-data-group">
            <?php if ( $args[ 'title' ]['order'] == BilletTitle::ORDER_TYPE ) : ?>
                <div class="billet-order">#<?php echo $args[ 'title' ]['index']; ?></div>
            <?php endif; ?>
            <a class="legal-title <?php echo $args[ 'title' ]['class']; ?> check-oops" href="<?php echo $args[ 'title' ]['href']; ?>" <?php echo BilletMain::render_nofollow( $args[ 'title' ][ 'nofollow' ] ); ?>><?php echo $args[ 'title' ]['label']; ?></a>
        </div>
        <?php if ( !empty( $args[ 'title' ][ 'rating' ] ) ): ?>
            <div class="billet-title-rating"><?php echo $args[ 'title' ]['rating']; ?></div>
        <?php endif; ?>
        <?php if ( !empty( $args['logo']['review']['href'] ) ) : ?>
            <a class="legal-review <?php echo $args['logo']['review']['class']; ?> <?php echo $args['logo']['review']['font']; ?>" href="<?php echo $args['logo']['review']['href']; ?>"><?php echo $args['logo']['review']['label']; ?></a>
        <?php endif; ?>
        <?php if ( !empty( $args[ 'warning' ] ) ): ?>
            <div class="billet-title-watning"><?php echo $args[ 'warning' ]; ?></div>
        <?php endif; ?>
    </div>
    <?php echo BilletMobile::render_mobile( $args[ 'mobile' ] ); ?>
</div>