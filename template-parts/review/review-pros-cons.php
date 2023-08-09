<?php if( !empty( $args ) ) : ?>
    <<?php echo $args[ 'title' ][ 'tag' ]; ?> class="pros-cons-title">
        <?php if( !empty( $args[ 'title' ] ) ) : ?>
            <?php echo $args[ 'title' ][ 'text' ]; ?>
        <?php endif; ?>
    </<?php echo $args[ 'title' ][ 'tag' ]; ?>>
    <div class="pros-cons-description">
        <?php if( !empty( $args[ 'content' ] ) ) : ?>
            <?php echo $args[ 'content' ]; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>