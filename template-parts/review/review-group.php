<nav class="group">
    <div class="review-group">
        <?php if( !empty( $args[ 'other' ] ) ) : ?>
            <span class="group-item">
                <?php echo $args[ 'current' ][ 'label' ]; ?>
            </span>
            <?php foreach( $args[ 'other' ] as $item ) : ?>
                <a class="group-item" href="<?php echo $item[ 'href' ]; ?>">
                    <?php echo $item[ 'label' ]; ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</nav>