<?php

// ini_set( 'error_reporting', -1 );
// ini_set( 'display_errors', 'On' );

class ToolNotFound
{
	public static function register()
    {
        $handler = new self();

		add_action( 'template_redirect', [ $handler, 'set_not_found' ] );

		// add_action( 'template_redirect', [ $handler, 'set_forbidden' ] );

		// add_action( 'parse_request', [ $handler, 'debug_404_rewrite_dump' ] );

		// add_action( 'template_redirect', [ $handler, 'debug_404_template_redirect' ], 99999 );

		// add_filter ( 'template_include', [ $handler, 'debug_404_template_dump' ] );

		// add_action ( 'wp_loaded', [ $handler, 'get_trash' ] );
    }

	const RESTRICTED = [
		'old-pl.match.center' => [
			'pl'
		],

		'old-ca.match.center' => [
			'ca',

			'ca-fr',
		],
	];

	public static function check_domain_not_in_restricted()
	{
		$result = true;

		if ( !array_key_exists( $_SERVER[ 'HTTP_HOST' ], self::RESTRICTED ) )
		{
			$language = WPMLMain::current_language();

			foreach ( self::RESTRICTED as $languages )
			{
				if ( in_array( $language, $languages ) )
				{
					$result = false;
				}
			}
		}

		return $result;
	}

	public static function check_domain_in_restricted()
	{
		if ( array_key_exists( $_SERVER[ 'HTTP_HOST' ], self::RESTRICTED ) )
		{
			if ( in_array( WPMLMain::current_language(), self::RESTRICTED )[ $_SERVER[ 'HTTP_HOST' ] ] )
			{
				return true;
			}
		}

		return false;
	}

	public static function check_domain()
	{
		return self::check_domain_in_restricted()
			
			|| self::check_domain_not_in_restricted();
	}

	public static function check()
	{
		return self::check_not_found();
	}

	public static function check_taxonomy()
	{
		return is_tax();
	}

	public static function check_tag()
	{
		return is_tag();
	}

	public static function check_category()
	{
		return is_category();
	}
	
	public static function check_not_found()
	{
		return self::check_category()

			|| self::check_tag()

			|| self::check_taxonomy()

			|| self::check_domain();
	}

	public static function set_not_found()
	{
		// LegalDebug::debug( [
		// 	'function' => 'ToolNotFound::set_not_found',
		// ] );

		if ( self::check_not_found() )
		{
			global $wp_query;

			$wp_query->set_404();

			// LegalDebug::debug( [
			// 	'function' => 'ToolNotFound::set_not_found',

			// 	'permissionwp_query_category' => $wp_query,
			// ] );
		}
	}

	public static function set_forbidden()
	{
		// LegalDebug::debug( [
		// 	'function' => 'ToolNotFound::set_not_found',
		// ] );

		if ( self::check_forbidden() )
		{
			global $wp_query;

			$wp_query->set_403();

			// LegalDebug::debug( [
			// 	'function' => 'ToolNotFound::set_not_found',

			// 	'permissionwp_query_category' => $wp_query,
			// ] );
		}
	}

	const FORBIDDEN = [
		'de' => [
			'de',
		],
	];

	public static function check_forbidden()
	{
		return self::check_locale_forbidden();
	}

	public static function get_locale_user()
	{
		$country = self::get_country();

		if ( !empty( $country ) )
		{
			return $country;
		}

		return 'en';
	}

	public static function check_locale_user( $locale )
    {
		return array_key_exists( $locale, self::FORBIDDEN );
	}

	public static function check_locale_country( $countries )
	{
		return in_array( WPMLMain::current_language(), $countries );
    }

	public static function check_locale_forbidden()
	{
		$locale = self::get_locale_user();

		if ( self::check_locale_user( $locale ) )
		{
			return self::check_locale_country( self::FORBIDDEN[ $locale ] );
		}

		return false;
	}

	public static function get_country()
	{
		return self::parse_country( self::get_ip_data() );
	}

	public static function parse_country( $json )
	{
		if ( $json )
		{
			$data = json_decode( $json );

			// LegalDebug::debug( [
			// 	'ToolNotFound' => 'get_ip_data',

			// 	'data' => $data,
			// ] );

			return strtolower( $data->countryCode );
		}

		return '';
	}
	public static function get_ip_data()
	{
		// $_SERVER['REMOTE_ADDR']

		// $_SERVER['HTTP_X_FORWARDED_FOR']

		$url = 'http://ip-api.com/json/' . $_SERVER['REMOTE_ADDR'];

		$curl = curl_init( $url );

		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

		$json = curl_exec( $curl );

		// LegalDebug::debug( [
		// 	'ToolNotFound' => 'get_ip_data',

		// 	'curl_error' => curl_error( $curl ),
		// ] );

		curl_close( $curl );

		return $json;
	}

	// public static function check_not_found()
    // {
	// 	$locale_user = 'en';

	// 	if ( !empty( $_SERVER[ 'HTTP_CF_IPCOUNTRY' ] ) )
	// 	{
	// 		$locale_user = strtolower( $_SERVER[ 'HTTP_CF_IPCOUNTRY' ] );
	// 	}

	// 	$permission_country = array_key_exists( $locale_user, self::LOCALE );

	// 	$permission_page = false;

	// 	$locale_page = WPMLMain::current_language();

	// 	if ( $permission_country )
	// 	{
	// 		$permission_page = !in_array( $locale_page, self::LOCALE[ $locale_user ] );
	// 	}

	// 	LegalDebug::debug( [
	// 		'function' => 'ToolNotFound::check_not_found',

	// 		'locale_user' => $locale_user,

	// 		'locale_page' => $locale_page,

	// 		'permission_country' => $permission_country ? 'true' : 'false',

	// 		'permission_page' => $permission_page ? 'true' : 'false',
	// 	] );

	// 	return $permission_country && $permission_page;
    // }

	// public static function get_trash()
	// {
	// 	$posts = get_posts( [
	// 		'posts_per_page' => -1,

	// 		'post_type' => [ 'page' ],

	// 		'post_status' => 'draft',
	// 	] );

	// 	foreach ( $posts as $post )
	// 	{
	// 		// if ( $post->ID == 2470508 && $post->post_type != 'page' )
			
	// 		if ( $post->post_status == 'draft' && $post->post_author == 10 )
	// 		{
	// 			$post->post_status = 'publish';

	// 			// $post->post_type = 'page';

	// 			wp_update_post( $post );

	// 			LegalDebug::debug( [
	// 				'posts' => count( $posts ),
	// 			] );
	// 		}
			
	// 		// wp_delete_post( $post->ID );
	// 	}
	// }

	// function debug_404_rewrite_dump( &$wp )
	// {
	// 	global $wp_rewrite;

	// 	global $wp_the_query;

	// 	LegalDebug::debug( [
	// 		'function' => 'debug_404_rewrite_dump',
			
	// 		'rewrite rules' => var_export( $wp_rewrite->wp_rewrite_rules(), true ),

	// 		'permalink structure' => var_export( $wp_rewrite->permalink_structure, true ),

	// 		'page permastruct' => var_export( $wp_rewrite->get_page_permastruct(), true ),

	// 		'matched rule and query' => var_export( $wp->matched_rule, true ),

	// 		'request' => var_export( $wp->request, true ),

	// 		'the query' => var_export( $wp_the_query, true )
	// 	] );
	// }

	// function debug_404_template_redirect()
	// {
	// 	global $wp_filter;

	// 	LegalDebug::debug( [
	// 		'function' => 'debug_404_template_redirect',
			
	// 		'template redirect filters' =>  var_export( $wp_filter[current_filter()], true ),
	// 	] );
	// }

	// function debug_404_template_dump( $template )
	// {
	// 	LegalDebug::debug( [
	// 		'function' => 'debug_404_template_dump',
			
	// 		'template file selected' =>  var_export( $template, true ),
	// 	] );

	// 	exit();
	// }
}

?>