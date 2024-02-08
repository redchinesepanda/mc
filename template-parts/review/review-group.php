<nav class="group" style="padding-bottom: 30px;">
    <?php if( !empty( $args[ 'other' ] ) ) : ?>
        <div class="review-group">

            <div class="swiper"> <!--новый тег для swiper -->
                <div class="swiper-wrapper"> <!--новый тег для swiper -->
                    <span class="group-item swiper-slide"><?php echo $args[ 'current' ][ 'label' ]; ?></span>
                    <?php foreach( $args[ 'other' ] as $item ) : ?>
                        <a class="group-item swiper-slide" href="<?php echo $item[ 'href' ]; ?>"><?php echo $item[ 'label' ]; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    <?php endif; ?>
</nav>