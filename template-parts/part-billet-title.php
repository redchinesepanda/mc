<?php

echo '<pre>part-billet-title.php:' . print_r( $args, true ) . '</pre>';

?>
<h3>
    <a href="<?php echo $args['billet-url'] ?>">
        <?php echo $args['billet-title-text'] ?>
    </a>
</h3>
<div class="billet-title-rating"><?php echo $args['billet-title-rating'] ?></div>
<div class="billet-title-best"><?php echo $args['billet-title-best'] ?></div>