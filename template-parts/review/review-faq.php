<?php if( !empty( $args ) ) : ?>
    <div itemscope itemtype="https://schema.org/FAQPage" class="review-faq">
        <?php foreach( $args as $item ) : ?>
            <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="faq-item">
                <div itemprop="name" class="item-title">
                    <?php echo $item[ 'title' ]; ?>
                </div>
                <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="item-content">
                    <?php foreach( $item[ 'content' ] as $part ) : ?>
                        <div itemprop="text" class="content-part">
                            <?php echo $part; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>