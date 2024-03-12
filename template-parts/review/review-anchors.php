<?php if( !empty( $args[ 'items' ] ) ) : ?>
    <nav class="anchors">
        <div class="review-anchors">
            <div class="anchors-title"><?php echo $args[ 'title' ]; ?></div>

            <div class="swiper"> <!--новый тег для swiper -->
                <div class="swiper-wrapper"> <!--новый тег для swiper -->
                <?php foreach( $args[ 'items' ] as $item ) : ?>
                    <a class="anchors-item swiper-slide" href="<?php echo $item[ 'href' ]; ?>"> <!--новый класс .swiper-slide для swiper -->
                        <?php echo $item[ 'label' ]; ?>
                    </a>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
        <span class="legal-to-top"></span>
    </nav>
<?php endif; ?>