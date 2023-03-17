<?php

// echo '<pre>part-billet-bonus.php:' . print_r( $args, true ) . '</pre>';

?>
<div class="billet-bonus">
    <div class="bonus-title">
        <a href="<?php echo $args['bonus-url']; ?>" rel="nofollow">
            <?php echo $args['bonus-title']; ?>
        </a>
    </div>
    <div class="bonus-description">
        <?php echo $args['bonus-title']; ?>
    </div>
    <div class="bonus-button">
        <a href="<?php echo $args['bonus-url']; ?>" rel="nofollow">
            <?php echo $args['bonus-button']; ?>
        </a>
    </div>
    <div class="billet-spoiler-button">
        <?php echo $args['spoiler-button']; ?> 
    </div>
</div>