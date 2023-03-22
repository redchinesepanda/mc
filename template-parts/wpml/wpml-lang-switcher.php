<style type="text/css">
    <?php foreach( $args['languages'] as $lang ) : ?>
        .container__menu-in-futter .img-before-text-block.locale-<?php echo $args['active']['id']; ?> {
            background-image: url('<?php echo $args['active']['src']; ?>');
        }
    <?php endforeach; ?>
</style>
<div class="container__menu-in-futter" style="position: relative;">
    <section class="menu-in-futter">
        <div class="buttton-country-whis-flag">
            <div class="img-before-text-block locale-<?php echo $args['active']['id']; ?>"></div>
            <div class="menu-in-futter__text-block">
                <?php echo $args['active']['title']; ?>
            </div>
            <svg class="tcb-icon" viewBox="0 0 24 24" data-id="icon-arrow_drop_up-duotone" data-name="">
                <path fill="none" d="M0 0h24v24H0V0z"></path>
                <path d="M7 14l5-5 5 5H7z"></path>
            </svg>
        </div>
    </section>
    <div class="drop-menu_content_Spoiler">
        <?php foreach( $args['languages'] as $lang ) : ?>
            <a class='lang' href="<?php echo $lang['href']; ?>" target="_blank">
                <div class="container__img-before-text-block">
                    <div class="img-before-text-block">
                        <img src="<?php echo $lang['src']; ?>" alt="<?php echo $lang['alt']; ?>" />
                    </div>
                    <div class="menu-in-futter__text-block">
                        <?php echo $lang['title']; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>