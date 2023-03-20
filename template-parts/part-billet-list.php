<?php if ( !empty( $args ) ): ?>
    <?php foreach( $args as $part ) :?>
        <?php if ( !empty( $part['part-items'] ) ): ?>
            <div class="billet-list-part <?php echo $part['part-icon']; ?> <?php echo $part['part-direction']; ?>">
                <?php foreach( $part['part-items'] as $item ) :?>
                    <div class="billet-list-part-item"><?php echo $item; ?></div>
                <?php endforeach;?>
            </div>
        <?php endif; ?>
    <?php endforeach;?>
<?php endif; ?>

