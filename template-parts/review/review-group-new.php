<nav class="group">
    <?php if( !empty( $args[ 'other' ] ) ) : ?>
        <div class="review-group">
            <!-- новый тег для swiper -->
            <div class="swiper">
                <!-- новый тег для swiper -->
                <div class="swiper-wrapper">
                    <?php foreach( $args[ 'other' ] as $item ) : ?>
                        <a class="group-item swiper-slide <?php echo $item[ 'class' ]; ?>" href="<?php echo $item[ 'href' ]; ?>"><?php echo $item[ 'label' ]; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</nav>