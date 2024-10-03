<?php

// LegalDebug::debug( [
//     'template' => 'review-anchors.php',

//     'args' => $args,
// ] );

?>
<?php if( !empty( $args[ 'items' ] ) ) : ?>
    <nav class="anchors">
        <div class="review-anchors">
            <div class="anchors-title"><?php echo $args[ 'title' ]; ?></div>
            <!-- новый тег для swiper -->
            <div class="swiper">
                <!-- новый тег для swiper -->
                <div class="swiper-wrapper">
                <!-- новый класс .swiper-slide для swiper -->
                <?php foreach( $args[ 'items' ] as $item ) : ?>
                    <a class="anchors-item swiper-slide" href="<?php echo $item[ 'href' ]; ?>"><?php echo $item[ 'label' ]; ?></a>
                <?php endforeach; ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
        <span class="legal-to-top"></span>
    </nav>
<?php endif; ?>