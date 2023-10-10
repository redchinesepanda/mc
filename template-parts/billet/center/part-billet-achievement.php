<?php if ( $args['class'] == BilletAchievement::TYPE_IMAGE ) : ?>
    <style id="<?php echo $args['selector']; ?>" type="text/css">
        .<?php echo $args['selector']; ?> {
            background-color: <?php echo $args['color']; ?>;
            background-image: url('<?php echo $args['image']; ?>');
        }
    </style>
<?php endif; ?>
<div class="billet-title-achivement <?php echo $args['selector'];?> <?php echo $args['class']; ?>">
    <?php echo $args['name']; ?>
</div>