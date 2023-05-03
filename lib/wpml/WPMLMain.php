<?php

require_once( 'WPMLLangSwitcher.php' );

require_once( 'WPMLTrid.php' );

require_once( 'WPMLLanguageMismatch.php' );

class WPMLMain
{
    public static function current_language()
    {
        return apply_filters( 'wpml_current_language', NULL );
    }

    public static function register()
    {
        WPMLLangSwitcher::register();

        WPMLTrid::register();

        WPMLLanguageMismatch::register();
    }
}

?>