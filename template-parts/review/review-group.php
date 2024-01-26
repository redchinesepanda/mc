<nav class="group" style="padding-bottom: 30px;">
    <?php if( !empty( $args[ 'other' ] ) ) : ?>
        <div class="review-group">
            <span class="group-item"><?php echo $args[ 'current' ][ 'label' ]; ?></span>
            <?php foreach( $args[ 'other' ] as $item ) : ?>
                <a class="group-item" href="<?php echo $item[ 'href' ]; ?>"><?php echo $item[ 'label' ]; ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</nav>