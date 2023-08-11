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

	const LOCALE = [
		'kz',

		'by',
	];

	public static function check_not_found()
    {
		$locale_page = WPMLMain::current_language();

		$locale_user = strtolower( $_SERVER[ 'HTTP_CF_IPCOUNTRY' ] );

		return in_array( $locale_user, self::LOCALE ) && !in_array( $locale_page, self::LOCALE );
    }

	public static function set_not_found()
	{
		if ( self::check_not_found() )
		{
			global $wp_query;

			$wp_query->set_404();
		}
	}

	public static function get_trash()
	{
		$posts = get_posts( [
			'posts_per_page' => -1,

			'post_type' => [ 'page' ],

			'post_status' => 'draft',
		] );

		foreach ( $posts as $post )
		{
			// if ( $post->ID == 2470508 && $post->post_type != 'page' )
			
			if ( $post->post_status == 'draft' && $post->post_author == 10 )
			{
				$post->post_status = 'publish';

				// $post->post_type = 'page';

				wp_update_post( $post );

				LegalDebug::debug( [
					'posts' => count( $posts ),
				] );
			}
			
			// wp_delete_post( $post->ID );
		}
	}

	function debug_404_rewrite_dump( &$wp )
	{
		global $wp_rewrite;

		global $wp_the_query;

		LegalDebug::debug( [
			'function' => 'debug_404_rewrite_dump',
			
			'rewrite rules' => var_export( $wp_rewrite->wp_rewrite_rules(), true ),

			'permalink structure' => var_export( $wp_rewrite->permalink_structure, true ),

			'page permastruct' => var_export( $wp_rewrite->get_page_permastruct(), true ),

			'matched rule and query' => var_export( $wp->matched_rule, true ),

			'request' => var_export( $wp->request, true ),

			'the query' => var_export( $wp_the_query, true )
		] );
	}

	function debug_404_template_redirect()
	{
		global $wp_filter;

		LegalDebug::debug( [
			'function' => 'debug_404_template_redirect',
			
			'template redirect filters' =>  var_export( $wp_filter[current_filter()], true ),
		] );
	}

	function debug_404_template_dump( $template )
	{
		LegalDebug::debug( [
			'function' => 'debug_404_template_dump',
			
			'template file selected' =>  var_export( $template, true ),
		] );

		exit();
	}
}

?>