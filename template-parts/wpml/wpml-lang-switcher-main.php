<div class="lang-switcher">
    <div class="lang-current lang-item">
        <div class="lang-image locale-<?php echo $args['active']['id']; ?>"></div>
        <div class="lang-title">
            <?php echo $args['active']['title']; ?>
        </div>
    </div>
    <div id="lang-menu-1" class="menu-avaible">
        <?php foreach( $args['languages'] as $lang ) : ?>
            <a class='lang-avaible lang-item' href="<?php echo $lang['href']; ?>" target="_blank">
                <div class="lang-image locale-<?php echo $lang['id']; ?>"></div>
                <div class="lang-title">
                    <?php echo $lang['title']; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>