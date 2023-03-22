<div class="bonus-title">
    <?php if ( !empty( $args['url']['bonus'] ) ): ?>
        <a class="legal-bonus" href="<?php echo $args['url']['bonus']; ?>" rel="nofollow">
    <?php else: ?>
        <span class="legal-bonus">
    <?php endif; ?>
        <?php echo $args['bonus']['title']; ?>
    <?php if ( !empty( $args['url']['bonus'] ) ): ?>
        </a>
    <?php else: ?>
        </span>
    <?php endif; ?>
</div>
<?php if ( !empty( $args['bonus']['description'] ) ): ?>
    <div class="bonus-description">
        <span><?php echo $args['bonus']['description']; ?></span>
    </div>
<?php endif; ?>
<div class="bonus-button">
    <?php if ( !empty( $args['url']['play'] ) ): ?>
        <a class="legal-play" href="<?php echo $args['url']['play']; ?>" rel="nofollow">
    <?php else: ?>
        <span class="legal-play">
    <?php endif; ?>
        <?php echo $args['bonus']['play']; ?>
    <?php if ( !empty( $args['url']['play'] ) ): ?>
        </a>
    <?php else: ?>
        </span>
    <?php endif; ?>
</div>
<?php if ( BilletSpoiler::check() ): ?>
    <div class="bonus-spoiler" data-id="<?php echo $args['data']['id']; ?>">
        <span class="spoiler-open"><?php echo $args['spoiler']; ?></span>
    </div>
<?php endif; ?>
