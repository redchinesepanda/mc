<?php if( !empty( $args[ 'items' ] ) ) : ?>
    <nav class="anchors">
        <div class="review-anchors">
            <div class="anchors-title"><?php echo $args[ 'title' ]; ?></div>

            <div class="swiper">
                <div class="swiper-wrapper">
                <?php foreach( $args[ 'items' ] as $item ) : ?>
                    <a class="anchors-item swiper-slide" href="<?php echo $item[ 'href' ]; ?>">
                        <?php echo $item[ 'label' ]; ?>
                    </a>
                <?php endforeach; ?>
                </div>
            </div>

        </div>
    </nav>
<?php endif; ?>