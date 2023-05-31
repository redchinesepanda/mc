<?php

require_once( 'WPMLLangSwitcher.php' );

require_once( 'WPMLTrid.php' );

require_once( 'WPMLLanguageMismatch.php' );

require_once( 'WPMLMedia.php' );

class WPMLMain
{
    public static function translated_menu_id( $menu_id )
	{
		return apply_filters( 'wpml_object_id', $menu_id, 'nav_menu' );
	}

    public static function current_language()
    {
        return apply_filters( 'wpml_current_language', NULL );
    }

    public static function locale_permalink( $url, $locale )
    {
        return apply_filters( 'wpml_permalink', $url, $locale );
    }

    public static function register()
    {
        WPMLLangSwitcher::register();

        WPMLTrid::register();

        WPMLLanguageMismatch::register();

        WPMLMedia::register();
    }
}

?>