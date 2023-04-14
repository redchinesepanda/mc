<?php if( !empty( $args ) ) : ?>
    <nav class="group">
        <div class="review-group">
            <?php foreach( $args as $item ) : ?>
                <a class="group-item" href="<?php echo $item[ 'href' ]; ?>">
                    <?php echo $item[ 'label' ]; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>
<?php endif; ?>