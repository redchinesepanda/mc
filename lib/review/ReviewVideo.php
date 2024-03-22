<?php

class ReviewVideo
{
	public static function register()
    {
		if ( self::check_contains_iframe() )
		{
			$handler = new self();
	
			add_filter( 'the_content', [ $handler, 'modify_content' ] );
		}
    }
	
	public static function check_contains_iframe()
    {
        return LegalComponents::check_contains( 'iframe' );
    }

	public static function modify_content( $content )
	{
		return str_replace( '<iframe ', '<iframe loading="lazy" ', $content );
	}
}

?>