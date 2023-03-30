<?php if ( $args['order'] == BilletLogo::ORDER_VALUE ) : ?>
    <div class="billet-order">#1</div>
<?php endif; ?>
<a class="legal-logo <?php echo $args['logo']['class']; ?>" href="<?php echo $args['logo']['href']; ?>" rel="nofollow">
    <img src="<?php echo $args['logo']['src'] ?>" alt="billet logo" />
</a>
<a class="legal-review <?php echo $args['review']['class']; ?>" href="<?php echo $args['review']['href']; ?>">
    <?php echo $args['review']['label']; ?>
</a>