<?php

require_once( 'AdminBillet.php' );

require_once( 'AdminPage.php' );

class AdminMain
{
    public static function register()
    {
        add_filter( 'acf/settings/remove_wp_meta_box', '__return_false' );

        AdminBillet::register();

        AdminPage::register();
    }
}

?>