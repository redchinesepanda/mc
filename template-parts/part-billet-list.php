<?php

echo '<pre>part-billet-list.php:' . print_r( $args, true ) . '</pre>';

?>

<?php if ( !empty( $args ) ): ?>
    <?php foreach( $args as $part ) :?>
        <?php if ( !empty( $part['part-items'] ) ): ?>
            <div class="part-items <?php echo $part['part-icon']; ?> <?php echo $part['part-direction']; ?>">
                <?php foreach( $part['part-items'] as $item ) :?>
                    <div class=""><?php echo $item; ?></div>
                <?php endforeach;?>
            </div>
        <?php endif; ?>
    <?php endforeach;?>
<?php endif; ?>

