<?php if( !empty( $args[ 'items' ] ) ) : ?>
    <nav class="anchors">
        <div class="review-anchors">
            <div class="anchors-title"><?php echo $args[ 'title' ]; ?></div>
            <?php foreach( $args[ 'items' ] as $item ) : ?>
                <a class="anchors-item" href="<?php echo $item[ 'href' ]; ?>">
                    <?php echo $item[ 'label' ]; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>
<?php endif; ?>