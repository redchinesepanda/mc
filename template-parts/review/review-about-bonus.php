<?php if( !empty( $args[ 'title' ] ) ) : ?>
    <div class="about-right">
        <?php if( !empty( $args[ 'bonus' ][ 'name' ] ) ) : ?>
            <span class="review-bonus-head"><?php echo $args[ 'text' ][ 'head' ]; ?></span>
            <div class="review-bonus-title"><?php echo $args[ 'bonus' ][ 'name' ]; ?></div>
        <?php endif; ?>
        <a href="<?php echo $args[ 'afillate' ][ 'href' ]; ?>" class="legal-afillate check-oops" style="" target="_blank" rel="nofollow"><?php echo $args[ 'afillate' ][ 'text' ]; ?></a>
        <?php if( empty( $args[ 'mode' ] ) && !empty( $args[ 'bonus' ][ 'description' ] ) ) : ?>
            <div class="review-bonus-description legal-cut-item <?php echo $args[ 'tnc-class' ] ?>" data-cut-set-id="0"><p class="bonus-description-text"><?php echo $args[ 'bonus' ][ 'description' ]; ?></p></div>
        <?php endif; ?>
        <?php if( empty( $args[ 'mode' ] ) && !empty( $args[ 'bonus' ][ 'description' ] ) ) : ?>
            <span class="legal-cut-control" data-review-default="<?php echo $args[ 'text' ][ 'show' ]; ?>" data-review-active="<?php echo $args[ 'text' ][ 'hide' ]; ?>" data-cut-set-id="0"></span>
        <?php endif; ?>
    </div>
<?php endif; ?>