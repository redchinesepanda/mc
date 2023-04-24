<?php

require_once( 'WPMLLangSwitcher.php' );

require_once( 'WPMLTrid.php' );

require_once( 'WPMLLanguageMismatch.php' );

class WPMLMain
{
    public static function register()
    {
        WPMLLangSwitcher::register();

        WPMLTrid::register();

        WPMLLanguageMismatch::register();
    }
}

?>