<?php if( !empty( $args ) ) : ?>
    <nav class="anchors">
        <div class="review-anchors">
            <div class="anchors-title"><?php echo $args[ 'title' ]; ?></div>
            <div class="anchors-control"></div>
            <?php foreach( $args[ 'items' ] as $item ) : ?>
                <a class="anchors-item" href="<?php echo $item[ 'href' ]; ?>">
                    <?php echo $item[ 'label' ]; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>
<?php endif; ?>