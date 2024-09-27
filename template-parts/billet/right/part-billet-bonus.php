<?php

// LegalDebug::debug( [
//     'file' => 'part-billet-bonus.php',

//     'args' => $args,
// ] );

?>
<?php if ( !empty( $args[ 'title' ] ) ): ?>
    <div class="bonus-title">
        <a class="legal-bonus <?php echo $args[ 'class' ]; ?> check-oops" href="<?php echo $args[ 'href' ]; ?>" <?php echo BilletMain::render_nofollow( $args[ 'nofollow' ] ); ?>>
            <?php echo $args[ 'title' ]; ?>
        </a>
    </div>
<?php endif; ?>
<?php if ( !empty( $args[ 'description' ] ) ): ?>
    <div class="bonus-description">
        <span><?php echo $args[ 'description' ]; ?></span>
    </div>
<?php endif; ?>