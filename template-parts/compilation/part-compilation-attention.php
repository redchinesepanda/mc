<?php

LegalDebug::debug( [
    'template' => 'part-compilation-attention.php',

    'args' => $args,
] );

?>
<div class="compilation-attention <?php echo $args[ 'type' ]; ?>">
    <?php if ( $args[ 'type' ] == CompilationMain::TYPE[ 'tooltip' ] ) : ?>
        <span class="legal-tooltip-close"></span>
    <?php endif; ?>
    <?php echo $args[ 'text' ]; ?>
</div>