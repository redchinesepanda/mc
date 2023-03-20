<?php

// echo '<pre>part-billet-bonus.php:' . print_r( $args, true ) . '</pre>';

?>
<div class="bonus-title">
    <?php if ( !empty( $args['url']['review'] ) ): ?>
        <a class="legal-bonus" href="<?php echo $args['url']['bonus']; ?>" rel="nofollow">
    <?php else: ?>
        <span class="legal-bonus">
    <?php endif; ?>
            <?php echo $args['bonus']['title']; ?>
    <?php if ( !empty( $args['url']['review'] ) ): ?>
        </a>
    <?php else: ?>
        </span>
    <?php endif; ?>
</div>
<?php if ( !empty( $args['bonus']['description'] ) ): ?>
    <div class="bonus-description">
        <?php echo $args['bonus']['description']; ?>
    </div>
<?php endif; ?>
<div class="bonus-button">
    <a href="<?php echo $args['url']['play']; ?>" rel="nofollow">
        <?php echo $args['bonus']['play']; ?>
    </a>
</div>
<div class="billet-spoiler-button">
    <?php echo $args['spoiler']; ?>
</div>
