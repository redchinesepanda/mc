<?php

class MultisiteFront
{
	public static function register_functions_subsite()
	{
		if ( MultisiteBlog::check_not_main_blog() )
		{
			$handler = new self();

			add_filter( 'locale', [ $handler, 'filter_function_name_11' ] );
		}
	}

	public static function filter_function_name_11( $locale )
	{
		LegalDebug::debug( [
			'MultisiteFront' => 'filter_function_name_11',

			'locale' => $locale,
		] );

		return $locale;
	}
}

?>