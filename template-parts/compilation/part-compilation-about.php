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
                <h1><?php echo $args[ 'title' ]; ?></h1>
                <?php foreach ( $args[ 'content' ] as $item ) : ?>
                    <?php echo $item[ 'html' ]; ?>
                <?php endforeach; ?>
				<?php if ( !empty( $args[ 'read-more' ] ) ) : ?>
                	<span class="legal-cut-control" data-content-default="Read more" data-content-active="Hide" data-cut-set-id="0">Read more</span>
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