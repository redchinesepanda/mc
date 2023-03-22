<style type="text/css">
    /* Language Display */

    .container__menu-in-futter .container__img-before-text-block {
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    /* Language Width and Height */

    .container__menu-in-futter .img-before-text-block {
        width: 20px;
    }

    .container__menu-in-futter .img-before-text-block .img {
        width: 20px;
    }

    /* Language Position */

    .container__menu-in-futter .container__img-before-text-block {
        padding: 5px 0;
    }

    .container__menu-in-futter .img-before-text-block {
        margin-right: 10px;
    }

    .container__menu-in-futter .menu-in-futter__text-block {
        margin: 0 5px 0 0;
    }

    /* Language Typography */

    .container__menu-in-futter .container__img-before-text-block {
        font-weight: 400;
        font-size: 14px;
        color: #fff;
    }

    .container__menu-in-futter .tcb-icon {
        font-size: 24px;
        color:#fff !important;
    }
</style>
<div class="container__menu-in-futter" style="position: relative;">
    <section class="menu-in-futter">
        <div class="buttton-country-whis-flag">
            <div class="container__img-before-text-block click_me">
                <div class="img-before-text-block">
                    <img src="<?php echo $args['active']['src']; ?>" alt="<?php echo $args['active']['alt']; ?>" />
                </div>
                <div class="menu-in-futter__text-block"><?php echo $args['active']['title']; ?></div>
                <svg class="tcb-icon" viewBox="0 0 24 24" data-id="icon-arrow_drop_up-duotone" data-name="">
                    <path fill="none" d="M0 0h24v24H0V0z"></path>
                    <path d="M7 14l5-5 5 5H7z"></path>
                </svg>
            </div>
        </div>
    </section>
    <div class="drop-menu_content_Spoiler" style="display: none;">
        <table class="table-left-column">
            <tbody>
                <?php foreach( $args['languages'] as $lang ) : ?>
                    <tr>
                        <th>
                            <a href="<?php echo $lang['href']; ?>" target="_blank">
                                <div class="container__img-before-text-block">
                                    <div class="img-before-text-block">
                                        <img src="<?php echo $lang['src']; ?>" alt="<?php echo $lang['alt']; ?>" />
                                    </div>
                                    <div class="menu-in-futter__text-block">
                                        <?php echo $lang['title']; ?>
                                    </div>
                                </div>
                            </a>
                        </th>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>