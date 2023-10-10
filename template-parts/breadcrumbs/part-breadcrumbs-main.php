<nav class="breadcrumbs">
    <div class="legal-breadcrumbs">
        <?php foreach( $args as $arg ) : ?>
            <div class="legal-breadcrumbs-item">
                <?php if( !empty( $arg[ 'link' ] ) ) : ?>
                    <a class="legal-item-title" href="<?php echo $arg[ 'link' ][ 'href' ]; ?>">
                        <span><?php echo $arg[ 'title' ]['text']; ?></span>
                    </a>
                <?php else : ?>
                    <span class="legal-item-title"><?php echo $arg[ 'title' ]['text']; ?></span>
                <?php endif; ?>
            </div>
        <? endforeach; ?>
    </div>
</nav>