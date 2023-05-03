<?php if( !empty( $args ) ): ?>
    <div class="legal-gallery">
        <?php foreach( $args as $image ): ?>
            <div class="gallery-item">
                <a href="<?php echo esc_url( $image[ 'url' ] ); ?>">
                     <img src="<?php echo esc_url( $image[ 'sizes' ][ 'thumbnail' ] ); ?>" alt="<?php echo esc_attr( $image[ 'alt' ] ); ?>" />
                </a>
                <p><?php echo esc_html( $image[ 'caption' ] ); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>