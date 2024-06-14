<?php

class MultisiteFront
{
	public static function register_functions_subsite()
	{
		if ( MiltisiteMain::check_multisite() )
		{
			if ( MultisiteBlog::check_not_main_blog() )
			{
				$handler = new self();
	
				add_filter( 'locale', [ $handler, 'multisite_locale_modify' ] );
			}
		}
	}

	public static function multisite_locale_modify( $locale )
	{
		// $current_blog_id = MultisiteBlog::get_current_blog_id();

        // $blog_locale = MultisiteBlog::get_blog_option( $current_blog_id, MultisiteSiteOptions::OPTIONS[ 'blog-locale' ] );

		$blog_locale = MultisiteSiteOptions::get_blog_locale();
		
		LegalDebug::debug( [
			'MultisiteFront' => 'multisite_locale_modify',

			'blog_locale' => $blog_locale,

			'locale' => $locale,
		] );

        if ( !empty( $blog_locale ) )
        {
            return $blog_locale;
        }

		return $locale;
	}
}

?>