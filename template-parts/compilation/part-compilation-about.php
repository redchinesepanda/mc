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
                    <p class="<?php echo $item[ 'class' ]; ?>"><?php echo $item[ 'text' ]; ?></p>
                <?php endforeach; ?>
				<?php if ( !empty( $args[ 'read-more' ] ) ) : ?>
                	<span class="legal-cut-control" data-content-default="Read more" data-content-active="Hide" data-cut-set-id="0">Read more</span>
				<?php endif; ?>
            </div>
			<div class="about-section-image">
				<img class="section-image-item" src="<?php echo $args[ 'image' ][ 'src' ]; ?>" width="<?php echo $args[ 'image' ][ 'width' ]; ?>" height="<?php echo $args[ 'image' ][ 'height' ]; ?>">
			</div>
        </div>
    </div>
<?php endif; ?>