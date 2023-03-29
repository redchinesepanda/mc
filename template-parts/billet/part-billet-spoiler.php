<div class="billet-spoiler <?php echo $args['selector']; ?>">
    <div class="spoiler-stats">
        <?php foreach ( $args['stats'] as $stat ) : ?>
            <div class="spoiler-stat">
                <div class="stat-title"><?php echo $stat['title']; ?>:</div>
                <div class="stat-description"><?php echo $stat['description']; ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="spoiler-description">
        <div class="spoiler-description-wrapper">
            <?php echo $args['description']; ?>
        </div>
    </div>
    <div class="spoiler-progress">
        <?php foreach ( $args['progress'] as $key => $item ) : ?>
            <div class="progress-item item-<?php echo $key; ?>">
                <div class="item-title"><?php echo $item['title']; ?></div>
                <div class="item-value-wrapper">
                    <div class="item-value legal-<?php echo $item['class']; ?>"><?php echo $item['value']; ?>/10</div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="spoiler-review">
        <a class="legal-review <?php echo $args['review']['class']; ?>" href="<?php echo $args['review']['href']; ?>" rel="nofollow">
            <?php echo $args['review']['label']; ?>
        </a>
    </div>
</div>