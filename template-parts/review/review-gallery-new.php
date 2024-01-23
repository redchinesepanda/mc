<?php if( !empty( $args[ 'items' ] ) ): ?>
    <div class="legal-imageset-wrapper">
        <div class="legal-imageset <?php echo $args[ 'class' ]; ?>">
            <?php foreach( $args[ 'items' ] as $image ): ?>
                <div class="imageset-item">
                    <img class="item-image <?php echo $image[ 'class' ]; ?>" src="<?php echo $image[ 'src' ]; ?>" alt="<?php echo $image[ 'alt' ]; ?>" width="<?php echo $image[ 'width' ]; ?>" height="<?php echo $image[ 'height' ]; ?>" data-src="<?php echo $image[ 'data-src' ]; ?>">
                    <div class="item-caption"><?php echo esc_html( $image[ 'caption' ] ); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="imageset-pagination">
            <div class="pagination-item legal-active"></div>
        </div>
        <div class="imageset-backward"></div>
        <div class="imageset-forward"></div>
    </div>
<?php endif; ?>