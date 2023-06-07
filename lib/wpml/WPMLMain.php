<?php

require_once( 'WPMLLangSwitcher.php' );

require_once( 'WPMLTrid.php' );

require_once( 'WPMLLanguageMismatch.php' );

require_once( 'WPMLMedia.php' );

// require_once( 'WPMLMenu.php' );

class WPMLMain
{
    public static function get_all_languages() {
        $languages = apply_filters(
            'wpml_active_languages',

            NULL,
            [
                'skip_missing' => 0,

                'orderby' => 'id',

                'order' => 'asc',
            ]
        );

        return $languages;
    }

    public static function filter_language( $items, $value )
	{
		return array_filter( $items, function( $item ) use ( $value ) {
			return (
				strpos( $item[ 'default_locale' ], $value ) !== false
				&& !array_key_exists( $item[ 'code' ], LegalBreadcrumbsMain::HOME )
			);
		} );
	}

	public static function get_group_language()
	{
		$details = WPMLMain::get_post_language_details();

		return substr( $details[ 'locale' ], 0, 2 );
	}

    public static function get_post_language_details()
	{
		return apply_filters( 'wpml_post_language_details', NULL ) ;
	}

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

        // WPMLMenu::register();
    }
}

?>