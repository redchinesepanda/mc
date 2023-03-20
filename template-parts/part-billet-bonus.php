<?php

// echo '<pre>part-billet-bonus.php:' . print_r( $args, true ) . '</pre>';

?>
<div class="bonus-title">
    <a href="<?php echo $args['url']['bonus']; ?>" rel="nofollow">
        <?php echo $args['bonus']['title']; ?>
    </a>
</div>
<div class="bonus-description">
    <?php echo $args['bonus']['description']; ?>
</div>
<div class="bonus-button">
    <a href="<?php echo $args['url']['play']; ?>" rel="nofollow">
        <?php echo $args['bonus']['play']; ?>
    </a>
</div>
<div class="billet-spoiler-button">
    <?php echo $args['spoiler']; ?>
</div>
