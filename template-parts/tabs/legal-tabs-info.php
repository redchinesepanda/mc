<?php if ( !empty( $args[ 'items' ] ) ) : ?>
    <div class="legal-section-tabs-info">
        <div class="tabs-info-wrapper">
            <div class="legal-tabs-info">
                <h2><?php echo $args[ 'title' ]; ?></h2>
                <div class="legal-tabs">
                    <div class="legal-tab-menu">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <?php foreach ( $args[ 'items' ] as $id => $item ) : ?>
                                    <div class="legal-tab-title swiper-slide legal-active" data-content="<?php echo $id; ?>" data-tabs="legal-tabs-<?php echo $id; ?>"><?php echo $item[ 'title' ]; ?></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="legal-tab-display">
                        <div class="legal-tab-content empty-tab-content"></div>
                        <div class="legal-tab-content empty-tab-content"></div>
                        <?php foreach ( $args[ 'items' ] as $id => $item ) : ?>
                            <div class="legal-tab-content legal-content-<?php echo $id; ?> legal-active"><?php echo $item[ 'content' ]; ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>