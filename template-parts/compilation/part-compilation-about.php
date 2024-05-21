<?php

// LegalDebug::debug( [
// 	'args' => $args,
// ] );

?>
<!-- Compilation About Template -->
<?php if ( !empty( $args[ 'title' ] ) ) : ?>
    <div class="compilation-about-wrapper">
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
                        <img src="<?php echo $args[ 'image' ][ 'src' ]; ?>" width="<?php echo $args[ 'image' ][ 'width' ]; ?>" height="<?php echo $args[ 'image' ][ 'height' ]; ?>" alt="Compilation about" loading="lazy">
                    </picture>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>