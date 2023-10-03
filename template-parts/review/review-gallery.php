<?php if( !empty( $args[ 'items' ] ) ): ?>
    <div class="legal-imageset <?php echo $args[ 'class' ]; ?>">
        <?php foreach( $args[ 'items' ] as $image ): ?>
            <div class="imageset-item">
                <img class="item-image" src="<?php echo $image[ 'src' ]; ?>" alt="<?php echo $image[ 'alt' ]; ?>" width="<?php echo $image[ 'width' ]; ?>" height="<?php echo $image[ 'height' ]; ?>" data-src="<?php echo $image[ 'data-src' ]; ?>">
                <div class="item-caption"><?php echo esc_html( $image[ 'caption' ] ); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>