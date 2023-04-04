<div class="bonus-title">
    <a class="legal-bonus <?php echo $args['class']; ?>" href="<?php echo $args['href']; ?>" rel="nofollow">
        <?php echo $args['title']; ?>
    </a>
</div>
<?php if ( !empty( $args['description'] ) ): ?>
    <div class="bonus-description">
        <span><?php echo $args['description']; ?></span>
    </div>
<?php endif; ?>