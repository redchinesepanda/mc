<?php if( !empty( $args ) ) : ?>
    <div class="legal-pros-cons">
        <?php foreach( $args as $item ) : ?>
            <div class="pros-cons-item">
                <div class="pros-cons-title <?php echo $item[ 'type' ]; ?>">
                    <?php echo $item[ 'title' ]; ?>
                </div>
                <div class="pros-cons-description">
                    <?php echo $item[ 'description' ]; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>