<?php

require_once( 'WikiTemplateSingle.php' );

require_once( 'WikiContent.php' );

class WikiMain
{
	const TEXT = [
		'best-bookmaker-bonuses' => 'Best Bookmaker Bonuses',
	];

	public static function register_style( $styles = [] )
    {
        if ( self::check() )
		{
			if ( empty( $styles ) )
			{
                $styles = self::CSS;
            }

            ToolEnqueue::register_style( $styles );
        }
    }

	public static function register()
    {
        WikiTemplateSingle::register();

		WikiContent::register();
    }

	const CATEGORY = [
        'wiki-tag',
    ];

	public static function check_not_admin()
	{
		return !is_admin();
	}

	public static function check_post_type_post()
	{
		return is_singular( [ 'post' ] );
	}

	const TAXONOMY = [
        'type' => 'page_type',
    ];

	const PAGE_TYPE = [
        'wiki' => 'legal-wiki',
    ];

	public static function check_taxonomy()
    {
        return has_term( self::PAGE_TYPE[ 'wiki' ], self::TAXONOMY[ 'type' ] );
    }

	public static function check_not_taxonomy()
    {
        return !has_term( self::PAGE_TYPE[ 'wiki' ], self::TAXONOMY[ 'type' ] );
    }

	public static function check_category()
    {
        return has_category( self::CATEGORY );
    }

	public static function check_thrive()
    {
		// LegalDebug::debug( [
		// 	'function' => 'WikiMain::check_thrive',

		// 	'check_not_admin' => self::check_not_admin(),

		// 	'check_taxonomy' => self::check_taxonomy(),

		// 	'check_category' => self::check_category(),

		// 	'check_not_taxonomy' => self::check_not_taxonomy(),
		// ] );

        return self::check_not_admin()

			&& self::check_post_type_post()

			// && self::check_category()

			&& self::check_not_taxonomy();
    }

    public static function check()
    {
		// LegalDebug::debug( [
		// 	'function' => 'WikiMain::check',

		// 	'check_not_admin' => self::check_not_admin(),

		// 	'check_post_type_post' => self::check_post_type_post(),

		// 	'check_category' => self::check_category(),

		// 	'check_taxonomy' => self::check_taxonomy(),
		// ] );

        return self::check_not_admin()

			&& self::check_post_type_post()

			&& self::check_category()

			&& self::check_taxonomy();
    }

	public static function get_id()
    {
		$post = get_post();

        if ( !empty( $post ) )
        {
            return $post->ID;
        }

        return 0;
    }
}

?>