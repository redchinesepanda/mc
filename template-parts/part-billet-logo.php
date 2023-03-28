<div class="billet-order">#1</div>

<a class="legal-logo <?php echo $args['logo']['class']; ?>" href="<?php echo $args['logo']['href']; ?>" rel="nofollow">
    <img src="<?php echo $args['logo']['src'] ?>" alt="billet logo" />
</a>
<a class="legal-review <?php echo $args['review']['class']; ?>" href="<?php echo $args['review']['href']; ?>">
    <?php echo $args['review']['label']; ?>
</a>

<!-- <?php if ( !empty( $args['url']['logo'] ) ): ?>
    <a href="<?php echo $args['url']['logo'] ?>" rel="nofollow">
<?php endif; ?>
    <img src="<?php echo $args['logo'] ?>" alt="billet logo" />
<?php if ( !empty( $args['url']['logo'] ) ): ?>
    </a>
<?php endif; ?>
<?php if ( !empty( $args['url']['review'] ) ): ?>
    <a class="legal-review" href="<?php echo $args['url']['review'] ?>">
<?php else: ?>
    <span class="legal-review">
<?php endif; ?>
    <?php echo $args['review']; ?>
<?php if ( !empty( $args['url']['review'] ) ): ?>
    </a>
<?php else: ?>
    </span>
<?php endif; ?> -->