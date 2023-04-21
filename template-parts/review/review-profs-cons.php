<?php if( !empty( $args ) ) : ?>
    <div class="legal-profs-cons">
        <?php foreach( $args as $item ) : ?>
            <div class="profs-cons-title <?php echo $item[ 'type' ]; ?>">
                <?php echo $item[ 'title' ]; ?>
            </div>
            <div class="profs-cons-description">
                <?php echo $item[ 'description' ]; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>