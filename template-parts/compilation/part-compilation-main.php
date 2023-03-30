<div class="legal-compilation <?php echo $args['achievement']; ?>">
    <?php foreach( $args['billets'] as $billet ) : ?>
        <?php BilletMain::render( $billet ); ?>
    <?php endforeach; ?>
</div>