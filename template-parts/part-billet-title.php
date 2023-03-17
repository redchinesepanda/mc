<?php

// echo '<pre>part-billet-title.php:' . print_r( $args, true ) . '</pre>';

?>
<style type="text/css">
    .<?php echo $args['achievement-selector']; ?> {
        background-color: <?php echo $args['billet-achievement']['achievement-color']; ?>;
        background-image: url('<?php echo $args['billet-achievement']['achievement-color']; ?>');
    }
</style>
<div class="billet-title">
    <h3 class="billet-title-text">
        <a href="<?php echo $args['billet-url'] ?>">
            <?php echo $args['billet-title-text'] ?>
        </a>
    </h3>
    <div class="billet-title-rating"><?php echo $args['billet-title-rating'] ?></div>
    <div class="billet-title-achivement <?php echo $args['achievement-selector']; ?>">
        <?php echo $args['billet-achievement']['achievement-name']; ?>
    </div>
</div>