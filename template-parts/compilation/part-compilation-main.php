<div class="legal-compilation <?php echo $args['achievement']; ?>">
    <?php foreach( $args as $billet ) : ?>
        <?php BilletMain::render( $billet ); ?>
    <?php endforeach; ?>
</div>