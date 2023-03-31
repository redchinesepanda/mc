<?php BilletBonus::render( $args ); ?>
<div class="bonus-button">
    <a class="legal-play <?php echo $args['play']['class']; ?>" href="<?php echo $args['play']['href']; ?>" rel="nofollow">
        <?php echo $args['play']['label']; ?>
    </a>
</div>
<?php BilletMobile::render( $args ); ?>
<?php BilletProfit::render( $args ); ?>