<style type="text/css">
    .lang-switcher .locale-<?php echo $args['active']['id']; ?> {
        background-image: url('<?php echo $args['active']['src']; ?>');
    }
    <?php foreach( $args['languages'] as $lang ) : ?>
        .lang-switcher .locale-<?php echo $lang['id']; ?> {
            background-image: url('<?php echo $lang['src']; ?>');
        }
    <?php endforeach; ?>
</style>
<div class="lang-switcher">
    <div class="lang-current">
        <div class="lang-image locale-<?php echo $args['active']['id']; ?>"></div>
        <div class="lang-title">
            <?php echo $args['active']['title']; ?>
        </div>
    </div>
    <div class="menu-avaible">
        <?php foreach( $args['languages'] as $lang ) : ?>
            <a class='lang-avaible' href="<?php echo $lang['href']; ?>" target="_blank">
                <div class="lang-image locale-<?php echo $lang['id']; ?>"></div>
                <div class="lang-title">
                    <?php echo $lang['title']; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>