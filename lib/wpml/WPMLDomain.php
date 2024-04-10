<?php

class WPMLDomain
{
	public static function register() {}

	public static function register_functions()
	{
		// if ( ToolNotFound::check_domain_restricted() )
		// {
		// 	$handler = new self();
	
		// 	add_filter( 'wpml_active_languages', [ $handler, 'wpml_get_active_languages_filter' ], 10, 2 );
		// }
	}

	// public static function wpml_get_active_languages_filter( $languages, $args = '' )
	// {
	// 	if ( empty( $languages) )
	// 	{
	// 		return $languages;
	// 	}
		
	// 	// $current_host = $_SERVER[ 'HTTP_HOST' ];
		
	// 	$current_host = ToolRobots::get_host();

	// 	$main_host = LegalMain::get_main_host();

	// 	if ( ToolNotFound::check_domain_restricted() )
	// 	{
	// 		foreach( $languages as $language )
	// 		{
	// 			if ( !empty( $language[ 'code' ] ) )
	// 			{
	// 				$code = $language[ 'code' ];

	// 				$replace_host = $main_host;
					
	// 				if ( $restricted_host = ToolNotFound::get_restricted_language_host( $code ) )
	// 				{
	// 					$replace_host = $restricted_host;
	// 				}
					
	// 				$languages[ $code ][ 'url' ] = str_replace( $current_host, $replace_host, $languages[ $code ][ 'url' ] );

	// 				$replace_code = ToolNotFound::get_default_language( $replace_host );

	// 				$languages[ $code ][ 'url' ] = str_replace( '/' . $replace_code . '/', '/', $languages[ $code ][ 'url' ] );
	// 			}
	// 		}
	// 	}
	// 	else
	// 	{
	// 		$restricted_languages = ToolNotFound::get_restricted_languages();

	// 		foreach( $restricted_languages as $language )
	// 		{
	// 			$restricted_host = ToolNotFound::get_restricted_language_host( $language );

	// 			if ( array_key_exists( $language, $languages ) )
	// 			{
	// 				$languages[ $language ][ 'url' ] = str_replace( $current_host, $restricted_host, $languages[ $language ][ 'url' ] );

	// 				$replace_code = ToolNotFound::get_default_language( $restricted_host );

	// 				$languages[ $language ][ 'url' ] = str_replace( '/' . $replace_code . '/', '/', $languages[ $language ][ 'url' ] );
	// 			}
	// 		}
	// 	}

	// 	return $languages;
	// }
}

?>