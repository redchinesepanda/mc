<div class="legal-compilation">
    <?php foreach( $args as $billet ) : ?>
        <?php BilletMain::render( $billet ); ?>
    <?php endforeach; ?>
</div>