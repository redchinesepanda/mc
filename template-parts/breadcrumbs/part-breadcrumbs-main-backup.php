<nav class="breadcrumbs">
    <div class="legal-breadcrumbs">
        <?php foreach( $args as $arg ) : ?>
            <div class="legal-breadcrumbs-item">
                <?php if( !empty( $arg[ 'link' ] ) ) : ?>
                    <a class="legal-item-title" itemprop="<?php echo $arg[ 'link' ][ 'itemprop' ]; ?>" href="<?php echo $arg[ 'link' ][ 'href' ]; ?>">
                        <span itemprop="<?php echo $arg[ 'title' ][ 'itemprop' ]; ?>"><?php echo $arg[ 'title' ]['text']; ?></span>
                    </a>
                <?php else : ?>
                    <span class="legal-item-title" itemprop="<?php echo $arg[ 'title' ][ 'itemprop' ]; ?>"><?php echo $arg[ 'title' ]['text']; ?></span>
                <?php endif; ?>
                <meta content="<?php echo $arg[ 'meta' ]['content']; ?>" itemprop="<?php echo $arg[ 'meta' ][ 'itemprop' ]; ?>" />
            </div>
        <? endforeach; ?>
    </div>
</nav>