<style type="text/css">
    <?php foreach ( $args['progress'] as $key => $item ) : ?>
        .<?php echo $args['selector']; ?> .<?php echo $key; ?> {
            width: <?php echo $item['value']; ?>;
        }
    <?php endforeach; ?>
</style>
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
                    <div class="item-value"><?php echo $item['value']; ?>/10</div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="spoiler-review">
        <a href="<?php echo $args['url']['review']; ?>">
            <?php echo $args['review']; ?>
        </a>
    </div>
</div>