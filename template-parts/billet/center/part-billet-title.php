<div class="billet-title">
    <?php if ( $args['order'] == BilletTitle::ORDER_TYPE ) : ?>
        <div class="billet-order">#1</div>
    <?php endif; ?>
    <a class="legal-title <?php echo $args['class']; ?>" href="<?php echo $args['href']; ?>"><?php echo $args['label']; ?></a>
    <?php if ( !empty( $args['rating'] ) ): ?>
        <div class="billet-title-rating"><?php echo $args['rating']; ?></div>
    <?php endif; ?>
    <?php BilletAchievement::render( $args ); ?>
</div>