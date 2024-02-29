<?php

LegalDebug::debug( [
    'template-part' => 'part-billet-mobile.php',

    'args' => $args,
] );

?>
<div class="bonus-mobile">
    <?php if ( !empty( $args['mobile']['iphone']['href'] ) ) : ?>
        <a class="bonus-mobile-item legal-iphone" href="<?php echo $args['mobile']['iphone']['href']; ?>" rel="nofollow"></a>
    <?php endif; ?>
    <?php if ( !empty( $args['mobile']['android']['href'] ) ) : ?>
        <a class="bonus-mobile-item legal-android" href="<?php echo $args['mobile']['android']['href']; ?>" rel="nofollow"></a>
    <?php endif; ?>
    <?php if ( !empty( $args['mobile']['site']['href'] ) ) : ?>
        <a class="bonus-mobile-item legal-site" href="<?php echo $args['mobile']['site']['href']; ?>" rel="nofollow"></a>
    <?php endif; ?>
</div>
