<?php

// LegalDebug::debug( [
//     'template' => 'part-compilation-attention.php',

//     'args' => $args,
// ] );

?>
<div class="compilation-attention <?php echo $args[ 'type' ]; ?>" data-tooltip-text="<?php echo $args[ 'text-data' ]; ?>">
    <!-- <?php echo $args[ 'text' ]; ?> -->
    <?php echo $args[ 'text-anchors' ]; ?>
    <?php if ( $args[ 'type' ] == CompilationMain::TYPE[ 'tooltip' ] ) : ?>
        <span class="legal-tooltip-close"></span>
    <?php endif; ?>
</div>