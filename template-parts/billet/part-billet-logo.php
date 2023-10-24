<?php if ( $args['order'] == BilletLogo::ORDER_VALUE ) : ?>
    <div class="billet-order">#<?php echo $args['index']; ?></div>
<?php endif; ?>
<a class="legal-logo <?php echo $args['logo']['class']; ?> check-oops" href="<?php echo $args['logo']['href']; ?>" <?php BilletMain::render_nofollow( $args['logo']['nofollow'] ); ?>>
    <img src="<?php echo $args['logo']['src'] ?>" alt="<?php echo $args['logo']['alt'] ?>" />
</a>
<a class="legal-review <?php echo $args['review']['class']; ?> <?php echo $args['review']['font']; ?>" href="<?php echo $args['review']['href']; ?>">
    <?php echo $args['review']['label']; ?>
</a>