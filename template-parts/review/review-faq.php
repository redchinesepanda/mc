<?php if( !empty( $args ) ) : ?>
    <section class="faq">
        <?php foreach( $args as $item ) : ?>
            <div class="faq-item">
                <div class="faq-item-title">
                    <?php echo $item[ 'title' ]; ?>
                </div>
                <div class="faq-item-content">
                    <?php echo $item[ 'content' ]; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>