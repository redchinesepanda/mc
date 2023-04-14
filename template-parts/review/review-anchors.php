<?php if( !empty( $args ) ) : ?>
    <div class="review-anchors">
        <div class="anchors-label"><?php echo $args[ 'label' ]; ?></div>
        <?php foreach( $args[ 'items' ] as $item ) : ?>
            <a class="anchors-item" href="<?php echo $item[ 'href' ]; ?>">
                <?php echo $item[ 'label' ]; ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>