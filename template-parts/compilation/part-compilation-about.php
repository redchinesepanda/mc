<?php

// LegalDebug::debug( [
// 	'args' => $args,
// ] );

?>
<!-- Compilation About Template -->
<?php if ( !empty( $args[ 'title' ] ) ) : ?>
    <div class="compilation-about-wrapper <?php echo $args[ 'class' ]; ?>">
        <div class="compilation-about">
            <div class="about-section-content">
                <?php echo $args[ 'title' ][ 'html' ]; ?>
                <?php foreach ( $args[ 'content' ] as $item ) : ?>
                    <?php echo $item[ 'html' ]; ?>
                <?php endforeach; ?>
				<?php if ( !empty( $args[ 'read-more' ] ) ) : ?>
                	<span class="legal-cut-control" data-content-default="<?php echo $args[ 'cut-control' ][ 'default' ]; ?>" data-content-active="<?php echo $args[ 'cut-control' ][ 'active' ]; ?>"><?php echo $args[ 'cut-control' ][ 'label' ]; ?></span>
				<?php endif; ?>
                <?php if ( !empty( $args[ 'buttons' ] ) ) : ?>
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ( $args[ 'buttons' ] as $button ) : ?>
                                <?php echo $button[ 'html' ]; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ( !empty( $args[ 'content' ] ) ) : ?>
                <div class="about-section-image">
                    <picture>
                        <source srcset="<?php echo $args[ 'image' ][ 'src' ]; ?>" media="(min-width: 960px)" width="<?php echo $args[ 'image' ][ 'width' ]; ?>" height="<?php echo $args[ 'image' ][ 'height' ]; ?>" alt="betting sites">
                        <img srcset="" width="0px" height="0px" alt="" loading="lazy">
                    </picture>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>