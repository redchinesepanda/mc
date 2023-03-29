<div class="billet-title">
    <div class="billet-order">#1</div>
        <a class="legal-title <?php echo $args['title']['class']; ?>" href="<?php echo $args['title']['href']; ?>" rel="nofollow">
            <h3 class="legal-title">
                <?php echo $args['title']['label']; ?>
            </h3>
        </a>
    <?php if ( !empty( $args['rating'] ) ): ?>
        <div class="billet-title-rating"><?php echo $args['rating']; ?></div>
    <?php endif; ?>
    <?php BilletAchievement::render(); ?>
</div>