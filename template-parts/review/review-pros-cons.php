<?php if( !empty( $args ) ) : ?>
    <div class="pros-cons-title">
        <?php if( !empty( $args[ 'title' ] ) ) : ?>
            <?php echo $args[ 'title' ]; ?>
        <?php endif; ?>
    </div>
    <div class="pros-cons-description">
        <?php if( !empty( $args[ 'content' ] ) ) : ?>
            <?php echo $args[ 'content' ]; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>