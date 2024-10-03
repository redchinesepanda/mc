<?php

// LegalDebug::debug( [
//     'template' => 'review-anchors.php',

//     'args' => $args,
// ] );

?>
<?php if( !empty( $args[ 'items' ] ) ) : ?>
    <nav class="anchors">
        <div class="review-anchors">
            <!-- <div class="anchors-title"><?php echo $args[ 'title' ]; ?></div> -->
            <div class="swiper">
                <div class="swiper-wrapper">
                <?php foreach( $args[ 'items' ] as $item ) : ?>
                    <a class="anchors-item swiper-slide" href="<?php echo $item[ 'href' ]; ?>"><?php echo $item[ 'label' ]; ?></a>
                <?php endforeach; ?>
                </div>
            </div>
            <div class="anchors-btn anchors-btn-prev"></div>
            <div class="anchors-btn anchors-btn-next"></div>
        </div>
        <span class="legal-to-top"></span>
    </nav>
<?php endif; ?>