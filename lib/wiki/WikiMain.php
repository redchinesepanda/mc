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

	public static function check_not_admin()
	{
		return !is_admin();
	}

	public static function check_post_type()
	{
		return is_singular( [ 'post' ] );
	}

	public static function check()
    {
        return self::check_not_admin() && self::check_post_type();
    }

	public static function register()
    {
        WikiTemplateSingle::register();

		WikiContent::register();
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