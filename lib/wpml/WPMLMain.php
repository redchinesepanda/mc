<?php

require_once( 'WPMLLangSwitcher.php' );

require_once( 'WPMLTrid.php' );

class WPMLMain
{
    public static function register()
    {
        WPMLLangSwitcher::register();

        WPMLTrid::register();
    }
}

?>