<?php if( !empty( $args ) ) : ?>
    <section class="overview">
        <div class="review-overview">
            <h2><?php echo $args[ 'title' ]; ?></h2>
            <div class="overview-description">
                <?php echo $args[ 'description' ]; ?>
            </div>
        </div>
    </section>
<?php endif; ?>