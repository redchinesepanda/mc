<?php if( !empty( $images ) ): ?>
    <div class="legal-imageset">
        <?php foreach( $images as $image ): ?>
            <div class="imageset-item">
                <img class="item-image" src="<?php echo $image[ 'src' ]; ?>" alt="<?php echo $image[ 'alt' ]; ?>" width="<?php echo $image[ 'width' ]; ?>" height="<?php echo $image[ 'height' ]; ?>" />
                <div class="item-caption"><?php echo esc_html( $image[ 'caption' ] ); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>