<?php

class MultisiteFront
{
	public static function register_functions_subsite()
	{
		if ( MultisiteBlog::check_not_main_blog() )
		{
			$handler = new self();

			// add_filter( 'locale', [ $handler, 'filter_function_name_11' ] );
		}
	}

	public static function filter_function_name_11( $locale )
	{
		$current_blog_id = MultisiteBlog::get_current_blog_id();

        $blog_locale = MultisiteBlog::get_blog_option( $current_blog_id, MultisiteSiteOptions::OPTIONS[ 'blog-locale' ] );
		
		// LegalDebug::debug( [
		// 	'MultisiteFront' => 'filter_function_name_11',

		// 	'blog_locale' => $blog_locale,

		// 	'locale' => $locale,
		// ] );

        if ( !empty( $blog_locale ) )
        {
            return $blog_locale;
        }

		return $locale;
	}
}

?>