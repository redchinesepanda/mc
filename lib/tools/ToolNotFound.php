<?php

// ini_set( 'error_reporting', -1 );
// ini_set( 'display_errors', 'On' );

class ToolNotFound
{
	public static function register()
    {
        $handler = new self();

		add_action( 'template_redirect', [ $handler, 'set_not_found' ] );

		// add_action( 'parse_request', [ $handler, 'debug_404_rewrite_dump' ] );

		// add_action( 'template_redirect', [ $handler, 'debug_404_template_redirect' ], 99999 );

		// add_filter ( 'template_include', [ $handler, 'debug_404_template_dump' ] );

		// add_action ( 'wp_loaded', [ $handler, 'get_trash' ] );
    }

	// const LOCALE = [
	// 	'kz' => [
	// 		'kz',

	// 		'ru',
	// 	],
	// ];

	public static function check()
	{
		$permission_category = self::check_category();

		LegalDebug::debug( [
			'function' => 'ToolNotFound::check',

			'permission_category' => $permission_category ? 'true' : 'false',
		] );

		return $permission_category;
	}

	public static function check_category()
	{
		return is_category();
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

	public static function set_not_found()
	{
		if ( self::check() )
		{
			global $wp_query;

			$wp_query->set_404();
			
			LegalDebug::debug( [
				'function' => 'ToolNotFound::check',
	
				'permission_category' => $permission_category ? 'true' : 'false',
			] );
		}
	}

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