<div class="bonus-title">
    <a class="legal-bonus <?php echo $args['bonus']['class']; ?>" href="<?php echo $args['bonus']['href']; ?>" rel="nofollow">
        <?php echo $args['bonus']['label']; ?>
    </a>
</div>
<?php if ( !empty( $args['bonus']['description'] ) ): ?>
    <div class="bonus-description">
        <span><?php echo $args['bonus']['description']; ?></span>
    </div>
<?php endif; ?>